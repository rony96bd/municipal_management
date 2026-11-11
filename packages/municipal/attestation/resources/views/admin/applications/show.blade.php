@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <div>
                    <h1 class="att-title">আবেদন নং: <code>{{ $application->tracking_no }}</code> — {{ $application->type?->name }}</h1>
                    <div style="margin-top:6px;">
                        <span class="att-badge att-badge-{{ $application->status->badge() }}">{{ $application->status->label() }}</span>
                        @if ($application->attestation)
                            <span style="margin-left:10px;font-size:14px;">স্মারক নং: <strong>{{ $application->attestation->memo_no }}</strong></span>
                        @endif
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @if ($application->attestation)
                        <a href="{{ route('attestation.certificates.print', $application->attestation) }}" target="_blank" class="att-btn att-btn-primary">🖨 সনদ প্রিন্ট করুন</a>
                        <a href="{{ route('attestation.certificates.show', $application->attestation) }}" class="att-btn att-btn-outline">সনদ বিস্তারিত</a>
                    @endif
                    <a href="{{ route('attestation.applications.index') }}" class="att-btn att-btn-outline">← তালিকায় ফিরে যান</a>
                </div>
            </div>

            <form method="POST" action="{{ route('attestation.applications.update', $application) }}">
                @csrf
                @method('PUT')

                @include('attestation::partials.person_and_fields', ['type' => $application->type, 'application' => $application, 'requireMobile' => false])

                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:18px;">
                    <h3 style="font-size:16px;font-weight:700;color:#0f6b3a;margin:0 0 12px 0;">💳 ম্যানুয়াল পেমেন্ট ও অ্যাডমিন নোট</h3>
                    <div class="att-grid att-grid-3">
                        <div class="att-field">
                            <label>পেমেন্ট অবস্থা</label>
                            <select name="payment_status" class="att-select">
                                <option value="unpaid" {{ $application->payment_status === 'unpaid' ? 'selected' : '' }}>অপরিশোধিত (Unpaid)</option>
                                <option value="paid" {{ $application->payment_status === 'paid' ? 'selected' : '' }}>পরিশোধিত (Paid)</option>
                                <option value="waived" {{ $application->payment_status === 'waived' ? 'selected' : '' }}>মওকুফ (Waived)</option>
                            </select>
                        </div>
                        <div class="att-field">
                            <label>আদায়কৃত টাকা (৳)</label>
                            <input type="number" step="0.01" name="paid_amount" class="att-input" value="{{ old('paid_amount', $application->paid_amount ?? $application->fee) }}">
                        </div>
                        <div class="att-field">
                            <label>রসিদ নম্বর (Receipt No)</label>
                            <input type="text" name="receipt_no" class="att-input" value="{{ old('receipt_no', $application->receipt_no) }}" placeholder="রসিদ নম্বর">
                        </div>
                    </div>
                    <div class="att-field" style="margin-bottom:0;">
                        <label>অ্যাডমিন নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_note" rows="2" class="att-textarea exclude-tyne">{{ old('admin_note', $application->admin_note) }}</textarea>
                    </div>
                </div>

                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <button type="submit" class="att-btn att-btn-secondary">💾 পরিবর্তন সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>

        <div class="att-grid att-grid-2">
            @if (!$application->attestation)
                <div class="att-card" style="border-color:#86efac;background:#f0fdf4;">
                    <h3 style="font-size:17px;font-weight:700;color:#166534;margin:0 0 10px 0;">✅ আবেদন অনুমোদন ও প্রত্যয়ন জেনারেট করুন</h3>
                    <p style="font-size:13.5px;color:#166534;margin-bottom:12px;">অনুমোদন করলে স্বয়ংক্রিয়ভাবে স্মারক নম্বর ও যাচাই কোড তৈরি হবে এবং প্রিন্টের জন্য প্রস্তুত হবে।</p>
                    <form method="POST" action="{{ route('attestation.applications.approve', $application) }}">
                        @csrf
                        <div class="att-grid att-grid-2">
                            <div class="att-field">
                                <label>পেমেন্ট অবস্থা</label>
                                <select name="payment_status" class="att-select">
                                    <option value="paid">পরিশোধিত (Paid)</option>
                                    <option value="unpaid">অপরিশোধিত (Unpaid)</option>
                                    <option value="waived">মওকুফ (Waived)</option>
                                </select>
                            </div>
                            <div class="att-field">
                                <label>রসিদ নং (ঐচ্ছিক)</label>
                                <input type="text" name="receipt_no" class="att-input" value="{{ $application->receipt_no }}" placeholder="রসিদ নম্বর">
                            </div>
                        </div>
                        <button type="submit" class="att-btn att-btn-primary">✔️ অনুমোদন ও সনদ তৈরি করুন</button>
                    </form>
                </div>

                <div class="att-card" style="border-color:#fca5a5;background:#fef2f2;">
                    <h3 style="font-size:17px;font-weight:700;color:#991b1b;margin:0 0 10px 0;">❌ আবেদন বাতিল (Reject) করুন</h3>
                    <form method="POST" action="{{ route('attestation.applications.reject', $application) }}">
                        @csrf
                        <div class="att-field">
                            <label>বাতিলের কারণ *</label>
                            <textarea name="reject_reason" rows="2" class="att-textarea exclude-tyne" required placeholder="কেন বাতিল করা হলো তা উল্লেখ করুন...">{{ $application->reject_reason }}</textarea>
                        </div>
                        <button type="submit" class="att-btn att-btn-danger">বাতিল করুন</button>
                    </form>
                </div>
            @else
                <div class="att-card">
                    <h3 style="font-size:17px;font-weight:700;color:#0f6b3a;margin:0 0 10px 0;">🤝 হার্ডকপি হস্তান্তর রেকর্ড</h3>
                    <form method="POST" action="{{ route('attestation.applications.handover', $application) }}">
                        @csrf
                        <div class="att-field">
                            <label>গ্রহীতার নাম</label>
                            <input type="text" name="handed_over_to" class="att-input" value="{{ $application->attestation->handed_over_to ?? $application->applicant_name }}">
                        </div>
                        <button type="submit" class="att-btn att-btn-primary">হস্তান্তর সম্পন্ন চিহ্নিত করুন</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="att-card">
            <h3 style="font-size:16px;font-weight:700;margin:0 0 12px 0;">🕒 অডিট লগ (কার্যক্রম ইতিহাস)</h3>
            <table class="att-table">
                <thead>
                    <tr>
                        <th>সময়</th>
                        <th>অ্যাকশন</th>
                        <th>বিবরণ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($application->logs as $log)
                        <tr>
                            <td>{{ $log->created_at?->format('d/m/Y H:i') }}</td>
                            <td><code>{{ $log->action }}</code></td>
                            <td>{{ json_encode($log->changes, JSON_UNESCAPED_UNICODE) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
