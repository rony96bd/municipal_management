<?php

namespace Municipal\Attestation\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Municipal\Attestation\Models\AttestationApplication;

class TrackController extends Controller
{
    public function index(Request $r)
    {
        $page_title  = 'প্রত্যয়ন আবেদনের অবস্থা যাচাই';
        $application = null;

        if ($r->filled('tracking_no') && $r->filled('mobile')) {
            $application = AttestationApplication::where('tracking_no', trim($r->tracking_no))
                ->where('mobile', trim($r->mobile))
                ->with(['type', 'attestation', 'logs'])
                ->first();
        }

        return view('attestation::public.track.index', compact('page_title', 'application'));
    }

    public function track(Request $r)
    {
        $r->validate([
            'tracking_no' => 'required|string|max:50',
            'mobile'      => 'required|string|max:20',
        ]);

        $application = AttestationApplication::where('tracking_no', trim($r->tracking_no))
            ->where('mobile', trim($r->mobile))
            ->with(['type', 'attestation', 'logs'])
            ->first();

        if (!$application) {
            return back()
                ->withInput()
                ->withErrors(['tracking_no' => 'আবেদন পাওয়া যায়নি। অনুগ্রহ করে ট্র্যাকিং নম্বর ও মোবাইল নম্বর সঠিকভাবে লিখুন।']);
        }

        $page_title = "আবেদনের অবস্থা: {$application->tracking_no}";

        return view('attestation::public.track.index', compact('page_title', 'application'));
    }
}
