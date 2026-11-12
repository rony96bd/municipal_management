@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap" style="max-width:1440px;">
        @include('attestation::admin._nav')

        <div class="att-card" style="padding:16px 20px;">
            <div class="att-card-header" style="margin-bottom:14px;padding-bottom:12px;">
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <span style="font-size:26px;">{{ $type?->icon ?? '📜' }}</span>
                    <div>
                        <h1 class="att-title" style="font-size:19px;">
                            {{ $type ? $type->name : 'সরাসরি নতুন প্রত্যয়ন ইস্যু করুন' }}
                        </h1>
                        @if ($type)
                            <div style="font-size:12.5px;color:#0f6b3a;font-weight:600;">
                                স্মারক ধরন: {{ $type->memo_name }} | ভাষা: {{ $type->language === 'en' ? '🌐 English' : 'বাংলা' }}
                            </div>
                        @endif
                    </div>
                </div>

                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <form method="GET" action="{{ route('attestation.certificates.create') }}" style="display:inline-flex;align-items:center;gap:6px;">
                        <select name="type_id" class="att-select" style="min-width:260px;padding:7px 10px;font-weight:600;" onchange="this.form.submit()">
                            @foreach ($types as $t)
                                <option value="{{ $t->id }}" {{ $type && $type->id === $t->id ? 'selected' : '' }}>
                                    {{ $t->icon }} {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($t->order) }}. {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <button type="button" class="att-btn att-btn-outline" onclick="const g=document.getElementById('serviceGridDrawer');g.style.display=g.style.display==='none'?'block':'none';">
                        🎛️ সনদের সেবাসমূহ গ্রিড
                    </button>
                    <a href="{{ route('attestation.certificates.index') }}" class="att-btn att-btn-outline">← ইস্যুকৃত তালিকা</a>
                </div>
            </div>

            <div id="serviceGridDrawer" style="display:none;margin-bottom:18px;">
                @include('attestation::partials.service_grid', [
                    'types'        => $types,
                    'routeMode'    => 'admin',
                    'activeTypeId' => $type?->id,
                ])
            </div>

            @if ($type)
                <div class="att-live-split">
                    <div class="att-live-form-col">
                        <form method="POST" action="{{ route('attestation.certificates.store') }}" enctype="multipart/form-data" id="attLiveForm">
                            @csrf
                            <input type="hidden" name="attestation_type_id" value="{{ $type->id }}">

                            @include('attestation::partials.person_and_fields', ['type' => $type, 'application' => null, 'requireMobile' => false])

                            @include('attestation::partials.attachments_box', ['application' => null])

                            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:14px;margin-bottom:16px;">
                                <h3 style="font-size:15px;font-weight:700;color:#0f6b3a;margin:0 0 10px 0;">📅 ইস্যুর তারিখ ও পেমেন্ট তথ্য</h3>
                                <div class="att-grid att-grid-2">
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

                            <button type="submit" class="att-btn att-btn-primary" style="width:100%;justify-content:center;font-size:15.5px;padding:12px 20px;">
                                💾 সনদ সংরক্ষণ ও চূড়ান্ত প্রিন্ট ভিউতে যান →
                            </button>
                        </form>
                    </div>

                    @include('attestation::partials.live_preview_workspace', ['type' => $type])
                </div>
            @endif
        </div>
    </div>
@endsection
