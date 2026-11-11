<?php

namespace Municipal\Attestation\Http\Controllers\Front;

use Illuminate\Routing\Controller;
use Municipal\Attestation\Models\Attestation;
use Municipal\Attestation\Support\LogoHelper;

class VerifyController extends Controller
{
    public function show(string $code)
    {
        $page_title  = 'অনলাইন প্রত্যয়ন যাচাই';
        $certificate = Attestation::where('verification_code', trim($code))
            ->with('type')
            ->first();
        $logo        = LogoHelper::url();

        return view('attestation::public.verify.show', compact('page_title', 'certificate', 'code', 'logo'));
    }
}
