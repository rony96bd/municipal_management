@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">➕ সরাসরি নতুন প্রত্যয়ন ইস্যু করুন</h1>
                <a href="{{ route('attestation.certificates.index') }}" class="att-btn att-btn-outline">← ইস্যুকৃত তালিকা</a>
            </div>

            <form method="GET" action="{{ route('attestation.certificates.create') }}" style="background:#f0fdf4;border:1px solid #bbf7d0;padding:14px;border-radius:8px;margin-bottom:18px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <label style="font-weight:700;color:#166534;">প্রত্যয়নের ধরন নির্বাচন করুন:</label>
                <select name="type_id" class="att-select" style="max-width:420px;" onchange="this.form.submit()">
                    @foreach ($types as $t)
                        <option value="{{ $t->id }}" {{ $type && $type->id === $t->id ? 'selected' : '' }}>
                            {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($t->order) }}. {{ $t->name }} ({{ $t->memo_name }})
                        </option>
                    @endforeach
                </select>
                <noscript><button type="submit" class="att-btn att-btn-primary att-btn-sm">লোড করুন</button></noscript>
            </form>

            @if ($type)
                <form method="POST" action="{{ route('attestation.certificates.store') }}">
                    @csrf
                    <input type="hidden" name="attestation_type_id" value="{{ $type->id }}">

                    @include('attestation::partials.person_and_fields', ['type' => $type, 'application' => null, 'requireMobile' => false])

                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:18px;">
                        <h3 style="font-size:16px;font-weight:700;color:#0f6b3a;margin:0 0 12px 0;">📅 ইস্যুর তারিখ ও পেমেন্ট তথ্য</h3>
                        <div class="att-grid att-grid-4">
                            <div class="att-field">
                                <label>ইস্যুর তারিখ</label>
                                <input type="date" name="issue_date" class="att-input" value="{{ old('issue_date', date('Y-m-d')) }}">
                            </div>
                            <div class="att-field">
                                <label>পেমেন্ট অবস্থা</label>
                                <select name="payment_status" class="att-select">
                                    <option value="paid">পরিশোধিত (Paid)</option>
                                    <option value="unpaid">অপরিশোধিত (Unpaid)</option>
                                    <option value="waived">মওকুফ (Waived)</option>
                                </select>
                            </div>
                            <div class="att-field">
                                <label>ফি পরিমাণ (৳)</label>
                                <input type="number" step="0.01" name="paid_amount" class="att-input" value="{{ old('paid_amount', $type->fee) }}">
                            </div>
                            <div class="att-field">
                                <label>রসিদ নম্বর (ঐচ্ছিক)</label>
                                <input type="text" name="receipt_no" class="att-input" value="{{ old('receipt_no') }}" placeholder="রসিদ নম্বর">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="att-btn att-btn-primary" style="font-size:15px;padding:11px 24px;">
                        🖨 সনদ জেনারেট ও প্রিন্ট প্রিভিউতে যান
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
