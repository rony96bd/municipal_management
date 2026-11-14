@extends(config('attestation.public_layout', 'front-views.templates.othe-page-header'))
@section(config('attestation.public_section', 'page-body'))
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">

<style>
    .pub-form-wrap { max-width: 960px; margin: 24px auto 48px; padding: 0 16px; font-family: 'Tiro Bangla', serif; }
    .pub-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 4px 18px rgba(0,0,0,0.05); }
    .att-grid { display: grid; gap: 14px; }
    .att-grid-2 { grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); }
    .att-grid-3 { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
    .att-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 10px; }
    .att-field label { font-size: 14px; font-weight: 600; color: #334155; }
    .att-input, .att-select, .att-textarea { width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 14px; font-family: inherit; }
    .att-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .att-table th, .att-table td { padding: 8px; border: 1px solid #cbd5e1; }
    .att-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 7px; font-size: 14px; font-weight: 600; text-decoration: none; border: 0; cursor: pointer; }
    .att-btn-primary { background: #0f6b3a; color: #fff; }
    .att-btn-outline { background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; }
    .att-btn-danger { background: #dc2626; color: #fff; }
    .att-btn-sm { padding: 5px 10px; font-size: 12.5px; }
</style>

<div class="pub-form-wrap">
    <div class="pub-box">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;padding-bottom:16px;margin-bottom:18px;border-bottom:1px solid #e2e8f0;">
            <div>
                <h1 style="font-size:22px;font-weight:700;color:#0f6b3a;margin:0;">{{ $type->name }}</h1>
                <p style="margin:4px 0 0 0;font-size:13.5px;color:#64748b;">
                    নির্ধারিত ফি: <strong>{{ (float)$type->fee > 0 ? \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$type->fee)) . ' টাকা (কার্যালয়ে পরিশোধযোগ্য)' : 'প্রযোজ্য ক্ষেত্রে কার্যালয়ে পরিশোধযোগ্য' }}</strong>
                </p>
            </div>
            <a href="{{ route('attestation.apply.index') }}" class="att-btn att-btn-outline">← সকল প্রত্যয়নের তালিকা</a>
        </div>

        @if ($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                <strong>অনুগ্রহ করে নিচের ঘরগুলো সঠিকভাবে পূরণ করুন:</strong>
                <ul style="margin:6px 0 0 18px;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('attestation.apply.store', $type->slug) }}" enctype="multipart/form-data">
            @csrf

            @include('attestation::partials.person_and_fields', ['type' => $type, 'application' => null, 'requireMobile' => true])

            @include('attestation::partials.attachments_box', ['application' => null])

            <div style="background:#fffbeb;border:1px solid #fde68a;color:#92400e;padding:12px 16px;border-radius:8px;margin-bottom:18px;font-size:14px;">
                ℹ️ <strong>গুরুত্বপূর্ণ নির্দেশনা:</strong> অনলাইনে আবেদন জমা দেওয়ার পর আপনাকে একটি <strong>ট্র্যাকিং নম্বর</strong> প্রদান করা হবে। আবেদনটি অনুমোদিত হলে পৌরসভা কার্যালয়ে উপস্থিত হয়ে মূল প্রত্যয়নপত্র সংগ্রহ করতে হবে।
            </div>

            <button type="submit" class="att-btn att-btn-primary" style="font-size:16px;padding:11px 28px;">
                📨 আবেদন জমা দিন
            </button>
        </form>
    </div>
</div>
@endsection
