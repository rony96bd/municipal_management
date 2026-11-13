<?php

namespace Municipal\Attestation\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Municipal\Attestation\Models\AttestationApplication;

class TrackController extends Controller
{
    private function normalizeDigits(?string $input): string
    {
        if ($input === null) {
            return '';
        }
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return trim(str_replace($bn, $en, $input));
    }

    public function index(Request $r)
    {
        $page_title   = 'প্রত্যয়ন আবেদনের অবস্থা যাচাই';
        $application  = null;
        $applications = null;

        $trackingNo = $this->normalizeDigits($r->input('tracking_no'));
        $mobile     = $this->normalizeDigits($r->input('mobile'));

        if ($trackingNo !== '' || $mobile !== '') {
            $query = AttestationApplication::query()->with(['type', 'attestation', 'logs']);

            if ($trackingNo !== '' && $mobile !== '') {
                $query->where('tracking_no', $trackingNo)->where('mobile', $mobile);
            } elseif ($trackingNo !== '') {
                $query->where('tracking_no', $trackingNo);
            } else {
                $query->where('mobile', $mobile);
            }

            $paginated = $query->latest('id')->paginate(20)->withQueryString();

            if ($paginated->total() === 1) {
                $application = $paginated->first();
                $page_title  = "আবেদনের অবস্থা: {$application->tracking_no}";
            } elseif ($paginated->total() > 1) {
                $applications = $paginated;
                $page_title   = "আবেদনসমূহের অবস্থা ({$paginated->total()}টি)";
            }
        }

        return view('attestation::public.track.index', compact('page_title', 'application', 'applications'));
    }

    public function track(Request $r)
    {
        $r->merge([
            'tracking_no' => $this->normalizeDigits($r->input('tracking_no')),
            'mobile'      => $this->normalizeDigits($r->input('mobile')),
        ]);

        $r->validate([
            'tracking_no' => 'required_without:mobile|nullable|string|max:50',
            'mobile'      => 'required_without:tracking_no|nullable|string|max:20',
        ], [
            'tracking_no.required_without' => 'অনুগ্রহ করে ট্র্যাকিং নম্বর অথবা মোবাইল নম্বর দিন।',
            'mobile.required_without'      => 'অনুগ্রহ করে ট্র্যাকিং নম্বর অথবা মোবাইল নম্বর দিন।',
        ]);

        $trackingNo = $r->input('tracking_no');
        $mobile     = $r->input('mobile');

        $query = AttestationApplication::query()->with(['type', 'attestation', 'logs']);

        if (!empty($trackingNo) && !empty($mobile)) {
            $query->where('tracking_no', $trackingNo)->where('mobile', $mobile);
        } elseif (!empty($trackingNo)) {
            $query->where('tracking_no', $trackingNo);
        } elseif (!empty($mobile)) {
            $query->where('mobile', $mobile);
        }

        $paginated = $query->latest('id')->paginate(20)->withQueryString();

        if ($paginated->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['tracking_no' => 'কোনো আবেদন পাওয়া যায়নি। অনুগ্রহ করে ট্র্যাকিং নম্বর অথবা মোবাইল নম্বর সঠিকভাবে লিখুন।']);
        }

        $application  = $paginated->total() === 1 ? $paginated->first() : null;
        $applications = $paginated->total() > 1 ? $paginated : null;

        $page_title = $application
            ? "আবেদনের অবস্থা: {$application->tracking_no}"
            : "আবেদনসমূহের অবস্থা ({$paginated->total()}টি)";

        return view('attestation::public.track.index', compact('page_title', 'application', 'applications'));
    }
}
