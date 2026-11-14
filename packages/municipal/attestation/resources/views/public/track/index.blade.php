@extends(config('attestation.public_layout', 'front-views.templates.othe-page-header'))
@section(config('attestation.public_section', 'page-body'))
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
<div style="max-width:740px;margin:28px auto 56px;padding:0 16px;font-family:'Tiro Bangla',serif;">
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:24px;box-shadow:0 4px 18px rgba(0,0,0,0.05);">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid #e2e8f0;">
            <h1 style="font-size:22px;font-weight:700;color:#0f6b3a;margin:0;">🔍 প্রত্যয়ন আবেদনের অবস্থা যাচাই</h1>
            <a href="{{ route('attestation.apply.index') }}" style="color:#0f6b3a;text-decoration:none;font-weight:600;font-size:14px;">← সকল প্রত্যয়ন তালিকা</a>
        </div>

        @if ($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('attestation.track.track') }}" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-bottom:10px;">
            @csrf
            <div>
                <label style="display:block;font-size:13.5px;font-weight:600;margin-bottom:4px;">ট্র্যাকিং নম্বর</label>
                <input type="text" name="tracking_no" value="{{ old('tracking_no', request('tracking_no')) }}"
                    placeholder="যেমন: ATT-2026-12345" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:7px;">
            </div>
            <div>
                <label style="display:block;font-size:13.5px;font-weight:600;margin-bottom:4px;">মোবাইল নম্বর</label>
                <input type="text" name="mobile" value="{{ old('mobile', request('mobile')) }}"
                    placeholder="যেমন: 01XXXXXXXXX" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:7px;">
            </div>
            <div style="display:flex;align-items:flex-end;">
                <button type="submit" style="width:100%;background:#0f6b3a;color:#fff;border:0;padding:11px 18px;border-radius:7px;font-weight:700;cursor:pointer;">
                    অবস্থা দেখুন
                </button>
            </div>
        </form>

        <p style="font-size:12.5px;color:#64748b;margin:0 0 20px 0;">
            💡 <em>ট্র্যাকিং নম্বর অথবা মোবাইল নম্বর—যেকোনো একটি দিলেই আবেদনের অবস্থা দেখতে পারবেন।</em>
        </p>

        @if ($application)
            <div style="background:#f8fafc;border:1px solid #cbd5e1;border-radius:10px;padding:20px;margin-top:16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:12px;">
                    <div>
                        <span style="font-size:13px;color:#64748b;">ট্র্যাকিং নম্বর:</span>
                        <strong style="font-family:monospace;font-size:16px;">{{ $application->tracking_no }}</strong>
                    </div>
                    <span style="padding:5px 14px;border-radius:999px;font-weight:700;font-size:13.5px;background:#dcfce7;color:#166534;">
                        বর্তমান অবস্থা: {{ $application->status->label() }}
                    </span>
                </div>

                <table style="width:100%;border-collapse:collapse;font-size:14.5px;">
                    <tr>
                        <td style="padding:7px 0;color:#64748b;width:38%;">প্রত্যয়নের ধরন</td>
                        <td style="padding:7px 0;font-weight:600;">{{ $application->type?->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:7px 0;color:#64748b;">আবেদনকারীর নাম</td>
                        <td style="padding:7px 0;font-weight:600;">{{ $application->applicant_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:7px 0;color:#64748b;">আবেদনের তারিখ</td>
                        <td style="padding:7px 0;">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($application->created_at?->format('d/m/Y')) }}</td>
                    </tr>
                    @if ($application->attestation)
                        <tr>
                            <td style="padding:7px 0;color:#64748b;">স্মারক নম্বর</td>
                            <td style="padding:7px 0;font-weight:700;color:#0f6b3a;">{{ $application->attestation->memo_no }}</td>
                        </tr>
                    @endif
                </table>

                @if ($application->status->value === 'approved' || $application->status->value === 'issued')
                    <div style="margin-top:14px;padding:12px 16px;background:#dcfce7;color:#166534;border-radius:8px;font-weight:600;">
                        🎉 আপনার প্রত্যয়নপত্র প্রস্তুত হয়েছে! অনুগ্রহ করে পৌরসভা কার্যালয়ে উপস্থিত হয়ে মূল কপি সংগ্রহ করুন।
                    </div>
                @elseif ($application->status->value === 'rejected')
                    <div style="margin-top:14px;padding:12px 16px;background:#fee2e2;color:#991b1b;border-radius:8px;">
                        <strong>আবেদনটি বাতিল হয়েছে।</strong> কারণ: {{ $application->reject_reason ?: 'বিস্তারিত জানতে কার্যালয়ে যোগাযোগ করুন।' }}
                    </div>
                @else
                    <div style="margin-top:14px;padding:12px 16px;background:#fef3c7;color:#92400e;border-radius:8px;">
                        ⏳ আপনার আবেদনটি বর্তমানে পর্যালোচনাধীন রয়েছে। অনুমোদিত হলে এখানে স্ট্যাটাস আপডেট হবে।
                    </div>
                @endif
            </div>
        @elseif (isset($applications) && $applications->total() > 1)
            <div style="margin-top:20px;">
                <h3 style="font-size:16px;font-weight:700;color:#0f6b3a;margin-bottom:12px;">
                    📋 প্রাপ্ত আবেদনসমূহ (মোট: {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($applications->total()) }}টি):
                </h3>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach ($applications as $item)
                        <div style="background:#f8fafc;border:1px solid #cbd5e1;border-radius:9px;padding:16px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
                            <div>
                                <div style="font-size:15px;font-weight:700;color:#000325;margin-bottom:3px;">
                                    {{ $item->type?->name }}
                                </div>
                                <div style="font-size:13px;color:#64748b;">
                                    ট্র্যাকিং: <strong style="font-family:monospace;color:#0f6b3a;">{{ $item->tracking_no }}</strong> |
                                    আবেদনকারী: <strong>{{ $item->applicant_name }}</strong> |
                                    তারিখ: {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($item->created_at?->format('d/m/Y')) }}
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span style="padding:4px 12px;border-radius:999px;font-weight:700;font-size:12.5px;background:#dcfce7;color:#166534;">
                                    {{ $item->status->label() }}
                                </span>
                                <a href="{{ route('attestation.track.index', ['tracking_no' => $item->tracking_no]) }}"
                                    style="background:#0f6b3a;color:#fff;padding:6px 14px;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;">
                                    বিস্তারিত দেখুন
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($applications->hasPages())
                    <div style="margin-top:20px;">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
