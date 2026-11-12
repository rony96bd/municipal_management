<?php

/*
|--------------------------------------------------------------------------
| Attestation package config
|--------------------------------------------------------------------------
| Host-specific values live here (or are resolved from the host app via
| callables). Publish with: php artisan vendor:publish --tag=attestation-config
*/

return [

    // ---- Organization (letterhead) ---------------------------------------
    'organization' => [
        'type'             => 'pourashava', // pourashava | union_parishad
        'bismillah'        => 'বিসমিল্লাহির রাহমানির রাহিম',
        'name'             => 'আলমডাঙ্গা পৌরসভা',
        'sub_title'        => 'আলমডাঙ্গা, চুয়াডাঙ্গা',
        'gov_line'         => 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকার',
        'address'          => 'পোষ্ট: আলমডাঙ্গা, উপজেলা : আলমডাঙ্গা, জেলা : চুয়াডাঙ্গা',
        'mobile'           => '০১৮৮৬-১৮২০৭০',
        'email'            => 'alamdangapourashava@gmail.com',
        'post_code'        => '৭২১০',
        'short_name'       => 'আঃপৌঃ', // used in memo number prefix
        'default_upazila'  => 'আলমডাঙ্গা',
        'default_district' => 'চুয়াডাঙ্গা',
        'holder_label'     => 'পৌর', // "পৌর ওয়ার্ড নম্বর" / union: "ইউনিয়ন ওয়ার্ড নম্বর"
    ],

    // ---- Logo resolution --------------------------------------------------
    // A callable returning an absolute URL / public path of the current logo,
    // or null to fall back to the packaged default logo.
    'logo_resolver' => null,
    'default_logo'  => 'vendor/attestation/default-logo.jpg',

    // ---- Routing ------------------------------------------------------------
    'routes' => [
        'admin' => [
            'prefix'     => 'dashboard/attestation',
            'name'       => 'attestation.',
            'middleware' => ['web', 'auth'],
        ],
        'public' => [
            'prefix'     => 'attestation',
            'name'       => 'attestation.',
            'middleware' => ['web', 'throttle:30,1'],
        ],
    ],

    // ---- Host integration ----------------------------------------------------
    'user_model'     => \App\Models\User::class,
    'admin_ability'  => null,
    'admin_layout'   => 'dashboard.templates.main',
    'admin_section'  => 'dash-body',
    'public_layout'  => 'front-views.templates.othe-page-header',
    'public_section' => 'page-body',

    // ---- Memo number ---------------------------------------------------------
    // Result: {prefix}/{type}/{year}/{serial}; serial restarts every year per type.
    'memo' => [
        'format'         => '{prefix}/{type}/{year}/{serial}',
        'serial_pad'     => 2, // 01, 02 ...
        'bengali_digits' => true,
    ],

    // ---- Verification (QR) -----------------------------------------------------
    'verification' => [
        'code_length' => 10,
    ],

    // ---- Print -------------------------------------------------------------------
    'print' => [
        'font'                => 'Noto Sans Bengali',
        'paper'               => 'A4',
        'with_header_default' => true,
        'watermark_default'   => true,
        'pad_top'             => 1.5, // ইঞ্চি: প্যাডে প্রিন্টের জন্য উপরে ফাঁকা মার্জিন
    ],

    // ---- Payment (manual) -----------------------------------------------------------
    'payment' => [
        'mode'           => 'manual',
        'currency_label' => 'টাকা',
    ],

    // ---- Uploads --------------------------------------------------------------------
    'uploads' => [
        'disk'   => 'public',
        'path'   => 'attestation',
        'max_kb' => 2048,
    ],
];
