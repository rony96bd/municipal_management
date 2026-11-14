@extends(config('attestation.public_layout', 'front-views.templates.othe-page-header'))
@section(config('attestation.public_section', 'page-body'))
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
<div style="max-width:680px;margin:32px auto 56px;padding:0 16px;font-family:'Tiro Bangla',serif;">
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:28px;text-align:center;box-shadow:0 6px 24px rgba(0,0,0,0.06);">
        <img src="{{ $logo }}" alt="logo" style="width:72px;height:72px;object-fit:contain;margin-bottom:10px;">
        <h1 style="font-size:22px;font-weight:700;color:#0f6b3a;margin:0 0 4px 0;">
            {{ config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা') }}
        </h1>
        <p style="font-size:14px;color:#64748b;margin:0 0 20px 0;">অনলাইন প্রত্যয়নপত্র সত্যতা যাচাইকরণ (QR Verification)</p>

        @if (!$certificate)
            <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:20px;border-radius:10px;">
                <div style="font-size:28px;margin-bottom:6px;">❌</div>
                <h2 style="font-size:19px;margin:0 0 6px 0;">প্রত্যয়নপত্র খুঁজে পাওয়া যায়নি!</h2>
                <p style="margin:0;font-size:14px;">যাচাই কোড <code>{{ $code }}</code>-এর বিপরীতে কোনো বৈধ সনদ নিবন্ধিত নেই।</p>
            </div>
        @elseif ($certificate->is_cancelled)
            <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:20px;border-radius:10px;">
                <div style="font-size:28px;margin-bottom:6px;">⚠️</div>
                <h2 style="font-size:19px;margin:0 0 6px 0;">এই প্রত্যয়নপত্রটি বাতিল (Revoked) করা হয়েছে</h2>
                <p style="margin:0;font-size:14px;">স্মারক নং: <strong>{{ $certificate->memo_no }}</strong> | কারণ: {{ $certificate->cancel_reason }}</p>
            </div>
        @else
            <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:16px;border-radius:10px;margin-bottom:18px;">
                <div style="font-size:28px;margin-bottom:4px;">✅</div>
                <h2 style="font-size:20px;font-weight:700;margin:0;">প্রত্যয়নপত্রটি বৈধ ও সত্য (Verified & Authentic)</h2>
            </div>

            <table style="width:100%;border-collapse:collapse;text-align:left;font-size:15px;">
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px 8px;color:#64748b;width:40%;">প্রত্যয়নের ধরন</td>
                    <td style="padding:10px 8px;font-weight:700;">{{ $certificate->snapshot['type_name'] ?? $certificate->type?->name }}</td>
                </tr>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px 8px;color:#64748b;">স্মারক নম্বর</td>
                    <td style="padding:10px 8px;font-weight:700;color:#0f6b3a;">{{ $certificate->memo_no }}</td>
                </tr>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px 8px;color:#64748b;">প্রত্যয়ন-প্রাপকের নাম</td>
                    <td style="padding:10px 8px;font-weight:700;">{{ $certificate->subject_name }}</td>
                </tr>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px 8px;color:#64748b;">ওয়ার্ড / ঠিকানা</td>
                    <td style="padding:10px 8px;">
                        ওয়ার্ড নং: {{ $certificate->snapshot['person']['ward_no'] ?? '-' }},
                        মহল্লা: {{ $certificate->snapshot['person']['mohalla'] ?? '-' }}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px 8px;color:#64748b;">ইস্যুর তারিখ</td>
                    <td style="padding:10px 8px;">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($certificate->issue_date?->format('d/m/Y')) }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 8px;color:#64748b;">যাচাই কোড</td>
                    <td style="padding:10px 8px;font-family:monospace;font-weight:700;">{{ $certificate->verification_code }}</td>
                </tr>
            </table>
        @endif
    </div>
</div>
@endsection
