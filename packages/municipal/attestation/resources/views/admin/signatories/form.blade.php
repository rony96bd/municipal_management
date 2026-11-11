@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card" style="max-width:720px;">
            <div class="att-card-header">
                <h1 class="att-title">{{ $page_title }}</h1>
                <a href="{{ route('attestation.signatories.index') }}" class="att-btn att-btn-outline">← ফিরে যান</a>
            </div>

            <form method="POST" action="{{ $signatory->exists ? route('attestation.signatories.update', $signatory) : route('attestation.signatories.store') }}">
                @csrf
                @if ($signatory->exists)
                    @method('PUT')
                @endif

                <div class="att-grid att-grid-2">
                    <div class="att-field">
                        <label>প্রিসেট কোড (ঐচ্ছিক, যেমন: A, B1, C1)</label>
                        <input type="text" name="preset_key" class="att-input" value="{{ old('preset_key', $signatory->preset_key) }}">
                    </div>
                    <div class="att-field">
                        <label>ক্রম (Order)</label>
                        <input type="number" name="order" class="att-input" value="{{ old('order', $signatory->order ?? 0) }}">
                    </div>
                </div>

                <div class="att-field">
                    <label>কর্মকর্তার নাম (ঐচ্ছিক — ফাঁকা রাখলে শুধু পদবী ছাপা হবে)</label>
                    <input type="text" name="name" class="att-input" value="{{ old('name', $signatory->name) }}" placeholder="যেমন: মোঃ রাকীবুল ইসলাম">
                </div>

                <div class="att-field">
                    <label>পদবী *</label>
                    <input type="text" name="designation" class="att-input" required value="{{ old('designation', $signatory->designation) }}" placeholder="যেমন: পৌর নির্বাহী কর্মকর্তা">
                </div>

                <div class="att-grid att-grid-2">
                    <div class="att-field">
                        <label>প্রতিষ্ঠানের নাম</label>
                        <input type="text" name="office_line" class="att-input" value="{{ old('office_line', $signatory->office_line) }}">
                    </div>
                    <div class="att-field">
                        <label>অতিরিক্ত লাইন (ঠিকানা)</label>
                        <input type="text" name="extra_line" class="att-input" value="{{ old('extra_line', $signatory->extra_line) }}">
                    </div>
                </div>

                <div style="margin:12px 0;">
                    <label style="display:inline-flex;align-items:center;gap:6px;font-weight:600;cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $signatory->is_active ?? true) ? 'checked' : '' }}>
                        সক্রিয় (Active)
                    </label>
                </div>

                <button type="submit" class="att-btn att-btn-primary">💾 সংরক্ষণ করুন</button>
            </form>
        </div>
    </div>
@endsection
