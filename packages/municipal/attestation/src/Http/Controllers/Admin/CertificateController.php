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
use Municipal\Attestation\Support\LogoHelper;
use Municipal\Attestation\Support\MemoGenerator;
use Municipal\Attestation\Support\SnapshotBuilder;

class CertificateController extends Controller
{
    public function index(Request $r)
    {
        $page_title = 'ইস্যুকৃত প্রত্যয়নসমূহ';
        $types      = AttestationType::orderBy('order')->orderBy('name')->get();

        $query = Attestation::with(['type', 'application'])->latest('issue_date')->latest('id');

        if ($r->filled('q')) {
            $q = $r->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('memo_no', 'like', "%{$q}%")
                    ->orWhere('subject_name', 'like', "%{$q}%")
                    ->orWhere('verification_code', 'like', "%{$q}%")
                    ->orWhere('id_no', 'like', "%{$q}%");
            });
        }

        if ($r->filled('type_id')) {
            $query->where('attestation_type_id', $r->type_id);
        }
        if ($r->filled('year')) {
            $query->where('year', (int) $r->year);
        }

        $certificates = $query->paginate(20)->withQueryString();

        return view('attestation::admin.certificates.index', compact('page_title', 'certificates', 'types'));
    }

    public function create(Request $r)
    {
        $page_title = 'সরাসরি নতুন প্রত্যয়ন তৈরি করুন';
        $types      = AttestationType::active()->orderBy('order')->orderBy('name')->get();
        $type       = null;

        if ($r->filled('type_id')) {
            $type = AttestationType::findOrFail($r->type_id);
        } elseif ($types->isNotEmpty()) {
            $type = $types->first();
        }

        return view('attestation::admin.certificates.create', compact('page_title', 'types', 'type'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'attestation_type_id' => 'required|exists:attestation_types,id',
            'applicant_name'      => 'required|string|max:255',
            'mobile'              => 'nullable|string|max:20',
            'id_type'             => 'nullable|string|max:20',
            'id_no'               => 'nullable|string|max:40',
            'father_name'         => 'nullable|string|max:255',
            'mother_name'         => 'nullable|string|max:255',
            'spouse_name'         => 'nullable|string|max:255',
            'ward_no'             => 'nullable|string|max:10',
            'holding_no'          => 'nullable|string|max:30',
            'mohalla'             => 'nullable|string|max:255',
            'upazila'             => 'nullable|string|max:255',
            'district'            => 'nullable|string|max:255',
            'issue_date'          => 'nullable|date',
            'payment_status'      => 'nullable|in:unpaid,paid,waived',
            'paid_amount'         => 'nullable|numeric|min:0',
            'receipt_no'          => 'nullable|string|max:100',
            'data'                => 'nullable|array',
        ]);

        $type = AttestationType::findOrFail($r->attestation_type_id);
        $issueDate = $r->filled('issue_date') ? \Carbon\Carbon::parse($r->issue_date) : today();
        $year = (int) $issueDate->format('Y');

        $certificate = DB::transaction(function () use ($r, $type, $issueDate, $year) {
            $org           = config('attestation.organization', []);
            $paymentStatus = $r->input('payment_status', 'paid');
            $paidAmount    = $r->filled('paid_amount') ? (float) $r->input('paid_amount') : (float) $type->fee;
            $attachments   = \Municipal\Attestation\Support\AttachmentHelper::processUploads($r, []);

            $application = AttestationApplication::create([
                'tracking_no'         => AttestationApplication::generateTrackingNo(),
                'attestation_type_id' => $type->id,
                'applicant_name'      => $r->input('applicant_name'),
                'mobile'              => $r->input('mobile'),
                'id_type'             => $r->input('id_type', 'nid'),
                'id_no'               => $r->input('id_no'),
                'father_name'         => $r->input('father_name'),
                'mother_name'         => $r->input('mother_name'),
                'spouse_name'         => $r->input('spouse_name'),
                'ward_no'             => $r->input('ward_no'),
                'holding_no'          => $r->input('holding_no'),
                'mohalla'             => $r->input('mohalla'),
                'upazila'             => $r->input('upazila', $org['default_upazila'] ?? 'আলমডাঙ্গা'),
                'district'            => $r->input('district', $org['default_district'] ?? 'চুয়াডাঙ্গা'),
                'data'                => $r->input('data', []),
                'attachments'         => $attachments,
                'status'              => ApplicationStatus::Approved,
                'fee'                 => $type->fee,
                'payment_status'      => $paymentStatus,
                'paid_amount'         => $paidAmount,
                'receipt_no'          => $r->input('receipt_no'),
                'paid_at'             => $paymentStatus === 'paid' ? now() : null,
                'created_by'          => Auth::id(),
                'reviewed_by'         => Auth::id(),
                'reviewed_at'         => now(),
            ]);

            $memo     = MemoGenerator::next($type->id, $type->memo_name, $year);
            $snapshot = SnapshotBuilder::build($type, $application);

            $cert = Attestation::create([
                'application_id'      => $application->id,
                'attestation_type_id' => $type->id,
                'memo_no'             => $memo['memo_no'],
                'year'                => $memo['year'],
                'serial'              => $memo['serial'],
                'issue_date'          => $issueDate,
                'verification_code'   => Attestation::generateVerificationCode(),
                'snapshot'            => $snapshot,
                'subject_name'        => $application->applicant_name,
                'id_no'               => $application->id_no,
                'fee'                 => $type->fee,
                'payment_status'      => $paymentStatus,
                'paid_amount'         => $paidAmount,
                'receipt_no'          => $r->input('receipt_no'),
                'paid_at'             => $paymentStatus === 'paid' ? now() : null,
                'issued_by'           => Auth::id(),
            ]);

            AttestationLog::record($cert, 'created_direct', ['memo_no' => $cert->memo_no]);

            return $cert;
        });

        return redirect()->route('attestation.certificates.show', $certificate)
            ->with('success', "প্রত্যয়ন সফলভাবে ইস্যু হয়েছে। স্মারক নং: {$certificate->memo_no}");
    }

    public function show(Attestation $certificate)
    {
        $page_title = "প্রত্যয়ন: {$certificate->memo_no}";
        $certificate->load(['type', 'application', 'issuer', 'logs.user']);
        $logo = LogoHelper::url();

        return view('attestation::admin.certificates.show', compact('page_title', 'certificate', 'logo'));
    }

    public function print(Request $r, Attestation $certificate)
    {
        $certificate->load(['type', 'application']);
        $certificate->increment('printed_count');
        $certificate->update(['last_printed_at' => now()]);
        AttestationLog::record($certificate, 'printed', ['printed_count' => $certificate->printed_count]);

        $logo     = LogoHelper::url();
        $snapshot = $certificate->snapshot ?? [];

        // Allow toggling header/watermark via query string on print preview
        $withHeader = $r->has('with_header')
            ? $r->boolean('with_header')
            : (bool) ($snapshot['print_options']['with_header'] ?? config('attestation.print.with_header_default', true));

        $withWatermark = $r->has('watermark')
            ? $r->boolean('watermark')
            : (bool) ($snapshot['print_options']['watermark'] ?? config('attestation.print.watermark_default', true));

        $padTop = (float) ($r->input('pad') ?? ($snapshot['print_options']['pad_top'] ?? config('attestation.print.pad_top', 1.5)));

        return view('attestation::print.default', compact('certificate', 'logo', 'snapshot', 'withHeader', 'withWatermark', 'padTop'));
    }

    public function handover(Request $r, Attestation $certificate)
    {
        $certificate->update([
            'handed_over_at' => now(),
            'handed_over_to' => $r->input('handed_over_to', $certificate->subject_name),
        ]);

        if ($certificate->application) {
            $certificate->application->update(['status' => ApplicationStatus::Issued]);
        }

        AttestationLog::record($certificate, 'handed_over', [
            'handed_over_to' => $certificate->handed_over_to,
        ]);

        return back()->with('success', 'প্রত্যয়নটি হস্তান্তরিত হিসেবে নথিভুক্ত হয়েছে।');
    }

    public function destroy(Request $r, Attestation $certificate)
    {
        $certificate->update([
            'is_cancelled'  => true,
            'cancel_reason' => $r->input('cancel_reason', 'অ্যাডমিন কর্তৃক বাতিলকৃত'),
        ]);

        AttestationLog::record($certificate, 'cancelled', [
            'reason' => $certificate->cancel_reason,
        ]);

        return redirect()->route('attestation.certificates.index')
            ->with('success', "প্রত্যয়ন ({$certificate->memo_no}) বাতিল করা হয়েছে।");
    }
}


