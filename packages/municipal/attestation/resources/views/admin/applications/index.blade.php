@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">📥 নাগরিক আবেদনসমূহ ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($applications->total()) }} টি)</h1>
                <a href="{{ route('attestation.certificates.create') }}" class="att-btn att-btn-primary">➕ সরাসরি প্রত্যয়ন ইস্যু</a>
            </div>

            <form method="GET" action="{{ route('attestation.applications.index') }}" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
                <input type="text" name="q" value="{{ request('q') }}" class="att-input" style="max-width:220px;" placeholder="ট্র্যাকিং নং / নাম / মোবাইল">
                <select name="type_id" class="att-select" style="max-width:240px;">
                    <option value="">সকল প্রত্যয়নের ধরন</option>
                    @foreach ($types as $t)
                        <option value="{{ $t->id }}" {{ (string)request('type_id') === (string)$t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="att-select" style="max-width:160px;">
                    <option value="">সকল অবস্থা</option>
                    @foreach (\Municipal\Attestation\Enums\ApplicationStatus::cases() as $st)
                        <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="att-input" style="max-width:155px;">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="att-input" style="max-width:155px;">
                <button type="submit" class="att-btn att-btn-secondary">ফিল্টার</button>
                <a href="{{ route('attestation.applications.index') }}" class="att-btn att-btn-outline">রিসেট</a>
            </form>

            <div style="overflow-x:auto;">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>ট্র্যাকিং নং</th>
                            <th>আবেদনকারী</th>
                            <th>মোবাইল</th>
                            <th>প্রত্যয়নের ধরন</th>
                            <th>ওয়ার্ড</th>
                            <th>পেমেন্ট</th>
                            <th>অবস্থা</th>
                            <th>তারিখ</th>
                            <th style="text-align:right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $app)
                            <tr>
                                <td><code>{{ $app->tracking_no }}</code></td>
                                <td><strong>{{ $app->applicant_name }}</strong></td>
                                <td>{{ $app->mobile ?: '-' }}</td>
                                <td>{{ $app->type?->name }}</td>
                                <td>{{ $app->ward_no ?: '-' }}</td>
                                <td>
                                    @if ($app->payment_status === 'paid')
                                        <span class="att-badge att-badge-success">পরিশোধিত</span>
                                    @elseif ($app->payment_status === 'waived')
                                        <span class="att-badge att-badge-info">মওকুফ</span>
                                    @else
                                        <span class="att-badge att-badge-warning">অপরিশোধিত</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="att-badge att-badge-{{ $app->status->badge() }}">
                                        {{ $app->status->label() }}
                                    </span>
                                </td>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($app->created_at?->format('d/m/Y')) }}</td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('attestation.applications.show', $app) }}" class="att-btn att-btn-primary att-btn-sm">দেখুন ও এডিট</a>
                                    @if ($app->attestation)
                                        <a href="{{ route('attestation.certificates.print', $app->attestation) }}" target="_blank" class="att-btn att-btn-outline att-btn-sm">🖨 প্রিন্ট</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;padding:24px;color:#64748b;">কোনো আবেদন পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
@endsection
