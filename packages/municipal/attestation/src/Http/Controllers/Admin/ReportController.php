<?php

namespace Municipal\Attestation\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Municipal\Attestation\Models\Attestation;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationType;

class ReportController extends Controller
{
    public function index(Request $r)
    {
        $page_title = 'প্রত্যয়ন রেজিস্টার ও রিপোর্ট';
        $types      = AttestationType::orderBy('order')->orderBy('name')->get();

        $query = Attestation::with(['type', 'application'])->orderByDesc('issue_date')->orderByDesc('id');

        if ($r->filled('date_from')) {
            $query->whereDate('issue_date', '>=', $r->date_from);
        }
        if ($r->filled('date_to')) {
            $query->whereDate('issue_date', '<=', $r->date_to);
        }
        if ($r->filled('type_id')) {
            $query->where('attestation_type_id', $r->type_id);
        }
        if ($r->filled('ward_no')) {
            $ward = $r->ward_no;
            $query->whereHas('application', fn ($q) => $q->where('ward_no', $ward));
        }
        if ($r->filled('payment_status')) {
            $query->where('payment_status', $r->payment_status);
        }

        $summary = [
            'total_issued'     => (clone $query)->where('is_cancelled', false)->count(),
            'total_cancelled'  => (clone $query)->where('is_cancelled', true)->count(),
            'total_handed_over'=> (clone $query)->whereNotNull('handed_over_at')->count(),
            'total_fee'        => (clone $query)->where('payment_status', 'paid')->sum('paid_amount'),
            'pending_apps'     => AttestationApplication::whereIn('status', ['pending', 'under_review'])->count(),
        ];

        $certificates = $query->paginate(30)->withQueryString();

        return view('attestation::admin.reports.index', compact('page_title', 'types', 'summary', 'certificates'));
    }

    public function export(Request $r)
    {
        $query = Attestation::with(['type', 'application'])->orderByDesc('issue_date')->orderByDesc('id');

        if ($r->filled('date_from')) {
            $query->whereDate('issue_date', '>=', $r->date_from);
        }
        if ($r->filled('date_to')) {
            $query->whereDate('issue_date', '<=', $r->date_to);
        }
        if ($r->filled('type_id')) {
            $query->where('attestation_type_id', $r->type_id);
        }
        if ($r->filled('ward_no')) {
            $ward = $r->ward_no;
            $query->whereHas('application', fn ($q) => $q->where('ward_no', $ward));
        }

        $records = $query->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="attestation-register-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($records) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'স্মারক নং',
                'প্রত্যয়নের ধরন',
                'ইস্যুর তারিখ',
                'নাম',
                'পিতার নাম',
                'ওয়ার্ড নং',
                'এনআইডি/নিবন্ধন নং',
                'যাচাই কোড',
                'পেমেন্ট অবস্থা',
                'আদায়কৃত ফি (টাকা)',
                'রসিদ নং',
                'অবস্থা',
            ]);

            foreach ($records as $row) {
                fputcsv($handle, [
                    $row->memo_no,
                    $row->type?->name,
                    $row->issue_date?->format('Y-m-d'),
                    $row->subject_name,
                    $row->application?->father_name ?? ($row->snapshot['person']['father_name'] ?? ''),
                    $row->application?->ward_no ?? ($row->snapshot['person']['ward_no'] ?? ''),
                    $row->id_no,
                    $row->verification_code,
                    $row->payment_status,
                    $row->paid_amount,
                    $row->receipt_no,
                    $row->is_cancelled ? 'বাতিল' : ($row->handed_over_at ? 'হস্তান্তরিত' : 'ইস্যুকৃত'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
