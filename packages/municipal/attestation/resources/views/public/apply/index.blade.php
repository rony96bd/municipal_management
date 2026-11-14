@extends(config('attestation.public_layout', 'front-views.templates.othe-page-header'))
@section(config('attestation.public_section', 'page-body'))
@php
    $logoUrl = \Municipal\Attestation\Support\LogoHelper::url();
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">

<style>
    .pub-att-wrap { max-width: 1140px; margin: 24px auto 48px; padding: 0 16px; font-family: 'Tiro Bangla', serif; }
    .pub-hero { background: linear-gradient(135deg, #0f6b3a 0%, #14a05a 100%); color: #fff; border-radius: 12px; padding: 24px 28px; margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; box-shadow: 0 6px 24px rgba(15,107,58,0.18); }
    .pub-hero-left { display: flex; align-items: center; gap: 16px; }
    .pub-hero-logo { width: 64px; height: 64px; border-radius: 50%; background: #fff; padding: 4px; object-fit: contain; box-shadow: 0 3px 10px rgba(0,0,0,.2); }
    .pub-hero h1 { font-size: 25px; font-weight: 700; margin: 0 0 5px 0; color: #fff; }
    .pub-hero p { margin: 0; font-size: 14.5px; opacity: 0.94; }
    .pub-track-btn { background: #fff; color: #0f6b3a; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14.5px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(0,0,0,.12); }
    .pub-track-btn:hover { background: #f0fdf4; color: #0f6b3a; }
</style>

<div class="pub-att-wrap">
    <div class="pub-hero">
        <div class="pub-hero-left">
            <img src="{{ $logoUrl }}" alt="Logo" class="pub-hero-logo">
            <div>
                <h1>📜 অনলাইন প্রত্যয়ন সেবা — সনদের সেবাসমূহ</h1>
                <p>{{ config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা') }} — কাঙ্ক্ষিত সেবার উপর ক্লিক করে অনলাইনে আবেদন করুন</p>
            </div>
        </div>
        <a href="{{ route('attestation.track.index') }}" class="pub-track-btn">🔍 আবেদনের অবস্থা যাচাই করুন →</a>
    </div>

    @include('attestation::partials.service_grid', [
        'types'     => $types,
        'routeMode' => 'public',
    ])
</div>
@endsection
