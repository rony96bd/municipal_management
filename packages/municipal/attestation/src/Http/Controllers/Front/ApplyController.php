<?php

namespace Municipal\Attestation\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Municipal\Attestation\Enums\ApplicationStatus;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationLog;
use Municipal\Attestation\Models\AttestationType;

class ApplyController extends Controller
{
    public function index(Request $r)
    {
        $page_title = 'অনলাইন প্রত্যয়ন আবেদন';
        $query      = AttestationType::public()->orderBy('order')->orderBy('id');

        if ($r->filled('q')) {
            $q = $r->input('q');
            $query->where('name', 'like', "%{$q}%");
        }

        $types = $query->get();

        return view('attestation::public.apply.index', compact('page_title', 'types'));
    }

    public function show(AttestationType $type)
    {
        abort_unless($type->is_active && $type->is_public, 404);
        $page_title = "আবেদন: {$type->name}";

        return view('attestation::public.apply.show', compact('page_title', 'type'));
    }

    public function store(Request $r, AttestationType $type)
    {
        abort_unless($type->is_active && $type->is_public, 404);

        $rules = [
            'applicant_name' => 'required|string|max:255',
            'mobile'         => 'required|string|max:20',
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
            'data'           => 'nullable|array',
        ];

        // Dynamic field validation
        foreach ($type->fields ?? [] as $field) {
            if (!empty($field['required']) && !empty($field['key'])) {
                $rules['data.' . $field['key']] = 'required';
            }
        }

        $r->validate($rules);

        $org        = config('attestation.organization', []);
        $trackingNo = AttestationApplication::generateTrackingNo();

        $app = AttestationApplication::create([
            'tracking_no'         => $trackingNo,
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
            'status'              => ApplicationStatus::Pending,
            'fee'                 => $type->fee,
            'payment_status'      => 'unpaid',
        ]);

        AttestationLog::record($app, 'created_public', ['tracking_no' => $trackingNo]);

        return redirect()->route('attestation.apply.confirmation', $trackingNo)
            ->with('success', 'আপনার আবেদন সফলভাবে জমা হয়েছে।');
    }

    public function confirmation(string $tracking)
    {
        $application = AttestationApplication::where('tracking_no', $tracking)
            ->with('type')
            ->firstOrFail();
        $page_title = "আবেদন নিশ্চিতকরণ: {$application->tracking_no}";

        return view('attestation::public.apply.confirmation', compact('page_title', 'application'));
    }
}
