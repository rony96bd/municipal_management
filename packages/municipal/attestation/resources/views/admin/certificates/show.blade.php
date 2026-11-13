@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <div>
                    <h1 class="att-title">প্রত্যয়ন স্মারক: {{ $certificate->memo_no }}</h1>
                    <p style="color:#64748b;margin:4px 0 0 0;">ধরন: <strong>{{ $certificate->type?->name }}</strong> | যাচাই কোড: <code>{{ $certificate->verification_code }}</code></p>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <a href="{{ route('attestation.certificates.print', $certificate) }}" target="_blank" class="att-btn att-btn-primary">🖨 প্রিন্ট ভিউ (ডিফল্ট)</a>
                    <a href="{{ route('attestation.certificates.print', [$certificate, 'with_header' => 1]) }}" target="_blank" class="att-btn att-btn-outline">🖨 হেডার সহ প্রিন্ট</a>
                    <a href="{{ route('attestation.certificates.print', [$certificate, 'with_header' => 0]) }}" target="_blank" class="att-btn att-btn-outline">🖨 প্যাডে প্রিন্ট (হেডার ছাড়া)</a>
                    @if ($certificate->application)
                        <a href="{{ route('attestation.applications.show', $certificate->application) }}" class="att-btn att-btn-secondary">✏️ তথ্য এডিট করুন</a>
                    @endif
                </div>
            </div>

            <div class="att-grid att-grid-2">
                <div style="background:#f8fafc;padding:16px;border-radius:8px;border:1px solid #e2e8f0;">
                    <h3 style="margin:0 0 10px 0;font-size:16px;color:#0f6b3a;">প্রত্যয়নের বিবরণ</h3>
                    <table class="att-table">
                        @foreach ($certificate->snapshot['person_rows'] ?? [] as $row)
                            <tr>
                                <td style="width:40%;color:#64748b;">{{ $row['label'] }}</td>
                                <td><strong>{{ $row['value'] }}</strong></td>
                            </tr>
                        @endforeach
                    </table>
                    <div style="margin-top:14px;padding:12px;background:#fff;border-radius:6px;border:1px solid #e2e8f0;line-height:1.8;">
                        {!! \App\Support\HtmlSanitizer::clean($certificate->snapshot['rendered_body'] ?? '') !!}
                    </div>
                </div>

                <div style="background:#f8fafc;padding:16px;border-radius:8px;border:1px solid #e2e8f0;">
                    <h3 style="margin:0 0 10px 0;font-size:16px;color:#0f6b3a;">মেটাডেটা ও যাচাই তথ্য</h3>
                    <p style="margin:6px 0;"><strong>ইস্যুর তারিখ:</strong> {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($certificate->issue_date?->format('d/m/Y')) }}</p>
                    <p style="margin:6px 0;"><strong>প্রিন্ট হয়েছে:</strong> {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($certificate->printed_count) }} বার</p>
                    <p style="margin:6px 0;"><strong>পেমেন্ট:</strong> {{ $certificate->payment_status }} ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$certificate->paid_amount)) }} ৳) — রসিদ: {{ $certificate->receipt_no ?: '-' }}</p>
                    <p style="margin:6px 0;"><strong>পাবলিক যাচাই লিংক:</strong> <a href="{{ route('attestation.verify.show', $certificate->verification_code) }}" target="_blank">{{ route('attestation.verify.show', $certificate->verification_code) }}</a></p>

                    @php
                        $certAttachments = is_array($certificate->application?->attachments) ? $certificate->application->attachments : [];
                    @endphp
                    @if (count($certAttachments) > 0)
                        <div style="margin-top:14px;padding:12px;background:#f0fdf4;border:1px solid #86efac;border-radius:8px;">
                            <strong style="color:#166534;font-size:14px;display:block;margin-bottom:8px;">
                                📎 সংযুক্ত প্রমাণক ফাইলসমূহ ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(count($certAttachments)) }} টি):
                            </strong>
                            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                                @foreach ($certAttachments as $att)
                                    <a href="{{ asset($att['path'] ?? '') }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;background:#fff;border:1px solid #bbf7d0;padding:6px 10px;border-radius:6px;font-size:13px;color:#0f6b3a;text-decoration:none;font-weight:600;">
                                        <span>{{ str_contains($att['mime'] ?? '', 'pdf') ? '📄' : '🖼️' }}</span>
                                        <span>{{ $att['label'] ?? 'প্রমাণক' }}: {{ $att['name'] ?? 'দেখুন' }} ↗</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!$certificate->is_cancelled)
                        <form action="{{ route('attestation.certificates.destroy', $certificate) }}" method="POST" style="margin-top:18px;" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই সনদটি বাতিল করতে চান?');">
                            @csrf
                            @method('DELETE')
                            <input type="text" name="cancel_reason" class="att-input" placeholder="বাতিলের কারণ (ঐচ্ছিক)" style="margin-bottom:8px;">
                            <button type="submit" class="att-btn att-btn-danger att-btn-sm">সনদ বাতিল (Revoke) করুন</button>
                        </form>
                    @else
                        <div class="att-alert att-alert-danger" style="margin-top:12px;">এই সনদটি বাতিল করা হয়েছে। কারণ: {{ $certificate->cancel_reason }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
