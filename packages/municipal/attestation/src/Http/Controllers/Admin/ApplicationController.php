<?php

namespace Municipal\Attestation\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Municipal\Attestation\Enums\ApplicationStatus;
use Municipal\Attestation\Models\Attestation;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationLog;
use Municipal\Attestation\Models\AttestationType;
use Municipal\Attestation\Support\MemoGenerator;
use Municipal\Attestation\Support\SnapshotBuilder;

class ApplicationController extends Controller
{
    public function dashboard()
    {
        $page_title = 'প্রত্যয়ন ব্যবস্থাপনা ড্যাশবোর্ড';

        $stats = [
            'types_count'        => AttestationType::active()->count(),
            'pending_count'      => AttestationApplication::where('status', ApplicationStatus::Pending->value)->count(),
            'under_review_count' => AttestationApplication::where('status', ApplicationStatus::UnderReview->value)->count(),
            'approved_count'     => AttestationApplication::where('status', ApplicationStatus::Approved->value)->count(),
            'issued_count'       => Attestation::where('is_cancelled', false)->count(),
            'today_issued'       => Attestation::whereDate('issue_date', today())->count(),
            'total_revenue'      => Attestation::where('payment_status', 'paid')->sum('paid_amount'),
        ];

        $recentApplications = AttestationApplication::with('type')
            ->latest()
            ->take(8)
            ->get();

        $recentCertificates = Attestation::with('type')
            ->latest()
            ->take(8)
            ->get();

        return view('attestation::admin.dashboard', compact('page_title', 'stats', 'recentApplications', 'recentCertificates'));
    }

    public function index(Request $r)
    {
        $page_title = 'প্রত্যয়নের আবেদনসমূহ';
        $types      = AttestationType::orderBy('order')->orderBy('name')->get();

        $query = AttestationApplication::with(['type', 'attestation'])->latest();

        if ($r->filled('q')) {
            $q = $r->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('tracking_no', 'like', "%{$q}%")
                    ->orWhere('applicant_name', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%")
                    ->orWhere('id_no', 'like', "%{$q}%");
            });
        }

        if ($r->filled('status')) {
            $query->where('status', $r->status);
        }
        if ($r->filled('type_id')) {
            $query->where('attestation_type_id', $r->type_id);
        }
        if ($r->filled('ward_no')) {
            $query->where('ward_no', $r->ward_no);
        }
        if ($r->filled('date_from')) {
            $query->whereDate('created_at', '>=', $r->date_from);
        }
        if ($r->filled('date_to')) {
            $query->whereDate('created_at', '<=', $r->date_to);
        }

        $applications = $query->paginate(20)->withQueryString();

        return view('attestation::admin.applications.index', compact('page_title', 'applications', 'types'));
    }

    public function show(AttestationApplication $application)
    {
        $page_title = "আবেদন: {$application->tracking_no}";
        $application->load(['type', 'attestation', 'logs.user']);

        // Auto move from pending -> under_review when admin opens it
        if ($application->status === ApplicationStatus::Pending) {
            $application->update(['status' => ApplicationStatus::UnderReview]);
            AttestationLog::record($application, 'under_review', ['note' => 'অ্যাডমিন আবেদনটি পর্যালোচনা শুরু করেছেন।']);
        }

        return view('attestation::admin.applications.show', compact('page_title', 'application'));
    }

    public function edit(AttestationApplication $application)
    {
        return $this->show($application);
    }

    public function update(Request $r, AttestationApplication $application)
    {
        $r->validate([
            'applicant_name' => 'required|string|max:255',
            'mobile'         => 'nullable|string|max:20',
            'id_type'        => 'nullable|string|max:20',
            'id_no'          => 'nullable|string|max:40',
            'father_name'    => 'nullable|string|max:255',
            'mother_name'    => 'nullable|string|max:255',
            'spouse_name'    => 'nullable|string|max:255',
            'ward_no'        => 'nullable|string|max:10',
            'holding_no'     => 'nullable|string|max:30',
            'mohalla'        => 'nullable|string|max:255',
            'upazila'        => 'nullable|string|max:255',
            'district'       => 'nullable|string|max:255',
            'payment_status' => 'nullable|in:unpaid,paid,waived',
            'paid_amount'    => 'nullable|numeric|min:0',
            'receipt_no'     => 'nullable|string|max:100',
            'admin_note'     => 'nullable|string',
            'data'           => 'nullable|array',
        ]);

        $paymentStatus = $r->input('payment_status', $application->payment_status);

        $application->update([
            'applicant_name' => $r->input('applicant_name'),
            'mobile'         => $r->input('mobile'),
            'id_type'        => $r->input('id_type', 'nid'),
            'id_no'          => $r->input('id_no'),
            'father_name'    => $r->input('father_name'),
            'mother_name'    => $r->input('mother_name'),
            'spouse_name'    => $r->input('spouse_name'),
            'ward_no'        => $r->input('ward_no'),
            'holding_no'     => $r->input('holding_no'),
            'mohalla'        => $r->input('mohalla'),
            'upazila'        => $r->input('upazila'),
            'district'       => $r->input('district'),
            'data'           => $r->input('data', $application->data ?? []),
            'payment_status' => $paymentStatus,
            'paid_amount'    => $r->input('paid_amount'),
            'receipt_no'     => $r->input('receipt_no'),
            'paid_at'        => $paymentStatus === 'paid' ? ($application->paid_at ?? now()) : null,
            'admin_note'     => $r->input('admin_note'),
        ]);

        // If an attestation certificate already exists, refresh its snapshot too!
        if ($application->attestation) {
            $application->load('type');
            $snapshot = SnapshotBuilder::build($application->type, $application);
            $application->attestation->update([
                'subject_name'   => $application->applicant_name,
                'id_no'          => $application->id_no,
                'snapshot'       => $snapshot,
                'payment_status' => $application->payment_status,
                'paid_amount'    => $application->paid_amount,
                'receipt_no'     => $application->receipt_no,
                'paid_at'        => $application->paid_at,
            ]);
        }

        AttestationLog::record($application, 'updated', ['note' => 'অ্যাডমিন আবেদনের তথ্য এডিট করেছেন।']);

        return redirect()->route('attestation.applications.show', $application)
            ->with('success', 'আবেদনের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    public function approve(Request $r, AttestationApplication $application)
    {
        $application->load(['type', 'attestation']);

        if ($application->attestation) {
            return redirect()->route('attestation.certificates.show', $application->attestation)
                ->with('info', 'এই আবেদনের বিপরীতে ইতিমধ্যে সনদ তৈরি হয়েছে।');
        }

        $type = $application->type;
        $year = (int) now()->format('Y');

        $certificate = DB::transaction(function () use ($r, $application, $type, $year) {
            $paymentStatus = $r->input('payment_status', $application->payment_status ?: 'paid');
            $paidAmount    = $r->filled('paid_amount') ? (float) $r->input('paid_amount') : (float) $application->fee;
            $receiptNo     = $r->input('receipt_no', $application->receipt_no);

            $application->update([
                'status'         => ApplicationStatus::Approved,
                'payment_status' => $paymentStatus,
                'paid_amount'    => $paidAmount,
                'receipt_no'     => $receiptNo,
                'paid_at'        => $paymentStatus === 'paid' ? now() : null,
                'reviewed_by'    => Auth::id(),
                'reviewed_at'    => now(),
                'admin_note'     => $r->input('admin_note', $application->admin_note),
            ]);

            $memo     = MemoGenerator::next($type->id, $type->memo_name, $year);
            $snapshot = SnapshotBuilder::build($type, $application);

            $cert = Attestation::create([
                'application_id'      => $application->id,
                'attestation_type_id' => $type->id,
                'memo_no'             => $memo['memo_no'],
                'year'                => $memo['year'],
                'serial'              => $memo['serial'],
                'issue_date'          => today(),
                'verification_code'   => Attestation::generateVerificationCode(),
                'snapshot'            => $snapshot,
                'subject_name'        => $application->applicant_name,
                'id_no'               => $application->id_no,
                'fee'                 => $application->fee,
                'payment_status'      => $paymentStatus,
                'paid_amount'         => $paidAmount,
                'receipt_no'          => $receiptNo,
                'paid_at'             => $paymentStatus === 'paid' ? now() : null,
                'issued_by'           => Auth::id(),
            ]);

            AttestationLog::record($application, 'approved', [
                'memo_no'        => $cert->memo_no,
                'certificate_id' => $cert->id,
            ]);

            return $cert;
        });

        return redirect()->route('attestation.certificates.show', $certificate)
            ->with('success', "আবেদনটি অনুমোদিত হয়েছে এবং প্রত্যয়ন তৈরি হয়েছে। স্মারক নং: {$certificate->memo_no}");
    }

    public function reject(Request $r, AttestationApplication $application)
    {
        $r->validate([
            'reject_reason' => 'required|string|max:500',
        ]);

        $application->update([
            'status'        => ApplicationStatus::Rejected,
            'reject_reason' => $r->input('reject_reason'),
            'reviewed_by'   => Auth::id(),
            'reviewed_at'   => now(),
        ]);

        AttestationLog::record($application, 'rejected', [
            'reason' => $r->input('reject_reason'),
        ]);

        return redirect()->route('attestation.applications.show', $application)
            ->with('success', 'আবেদনটি বাতিল করা হয়েছে।');
    }

    public function handover(Request $r, AttestationApplication $application)
    {
        $application->update([
            'status' => ApplicationStatus::Issued,
        ]);

        if ($application->attestation) {
            $application->attestation->update([
                'handed_over_at' => now(),
                'handed_over_to' => $r->input('handed_over_to', $application->applicant_name),
            ]);
        }

        AttestationLog::record($application, 'issued', [
            'handed_over_to' => $r->input('handed_over_to', $application->applicant_name),
        ]);

        return back()->with('success', 'প্রত্যয়নটি নাগরিককে হস্তান্তর হিসেবে চিহ্নিত করা হয়েছে।');
    }

    public function destroy(AttestationApplication $application)
    {
        $tracking = $application->tracking_no;
        $application->delete();

        return redirect()->route('attestation.applications.index')
            ->with('success', "আবেদন ({$tracking}) মুছে ফেলা হয়েছে।");
    }
}
