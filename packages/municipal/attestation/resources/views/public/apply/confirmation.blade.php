@extends(config('attestation.public_layout', 'front-views.templates.othe-page-header'))
@section(config('attestation.public_section', 'page-body'))
<div style="max-width:680px;margin:32px auto 56px;padding:0 16px;font-family:'Noto Sans Bengali',sans-serif;">
    <div style="background:#fff;border:1px solid #86efac;border-radius:12px;padding:32px;text-align:center;box-shadow:0 6px 24px rgba(15,107,58,0.08);">
        <div style="width:64px;height:64px;border-radius:50%;background:#dcfce7;color:#166534;font-size:32px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">✔</div>
        <h1 style="font-size:24px;font-weight:700;color:#166534;margin:0 0 8px 0;">আপনার আবেদন সফলভাবে গৃহীত হয়েছে!</h1>
        <p style="color:#475569;font-size:15px;margin:0 0 20px 0;">প্রত্যয়নের ধরন: <strong>{{ $application->type?->name }}</strong></p>

        <div style="background:#f0fdf4;border:2px dashed #14a05a;border-radius:10px;padding:18px;margin-bottom:20px;">
            <div style="font-size:13px;color:#166534;margin-bottom:4px;">আপনার ট্র্যাকিং নম্বর (সংরক্ষণ করুন):</div>
            <div style="font-size:26px;font-weight:700;color:#0f6b3a;font-family:monospace;letter-spacing:1px;">
                {{ $application->tracking_no }}
            </div>
            <div style="font-size:13px;color:#475569;margin-top:6px;">
                আবেদনকারীর নাম: <strong>{{ $application->applicant_name }}</strong> | মোবাইল: <strong>{{ $application->mobile }}</strong>
            </div>
        </div>

        <div style="background:#fffbeb;border:1px solid #fde68a;color:#92400e;padding:14px;border-radius:8px;font-size:14px;text-align:left;margin-bottom:22px;line-height:1.7;">
            📌 <strong>পরবর্তী করণীয়:</strong><br>
            ১. উপরের <strong>ট্র্যাকিং নম্বর ({{ $application->tracking_no }})</strong> এবং আপনার মোবাইল নম্বর দিয়ে যেকোনো সময় আবেদনের অবস্থা যাচাই করতে পারবেন।<br>
            ২. আবেদনটি যাচাই ও অনুমোদিত হওয়ার পর <strong>{{ config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা') }}</strong> কার্যালয়ে সরাসরি উপস্থিত হয়ে নির্ধারিত ফি (প্রযোজ্য ক্ষেত্রে) পরিশোধপূর্বক স্বাক্ষরিত মূল প্রত্যয়নপত্র সংগ্রহ করুন।
        </div>

        <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
            <a href="{{ route('attestation.track.index', ['tracking_no' => $application->tracking_no, 'mobile' => $application->mobile]) }}"
                style="background:#0f6b3a;color:#fff;text-decoration:none;padding:10px 20px;border-radius:8px;font-weight:600;">
                🔍 আবেদনের অবস্থা দেখুন
            </a>
            <button onclick="window.print()" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:10px 20px;border-radius:8px;font-weight:600;cursor:pointer;">
                🖨 রসিদ প্রিন্ট করুন
            </button>
            <a href="{{ route('attestation.apply.index') }}"
                style="background:#fff;color:#0f6b3a;border:1px solid #0f6b3a;text-decoration:none;padding:10px 20px;border-radius:8px;font-weight:600;">
                নতুন আবেদন করুন
            </a>
        </div>
    </div>
</div>
@endsection
