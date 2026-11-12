@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">🗂️ প্রত্যয়নের ধরনসমূহ ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($types->total()) }} টি)</h1>
                <a href="{{ route('attestation.types.create') }}" class="att-btn att-btn-primary">➕ নতুন ধরন তৈরি করুন</a>
            </div>

            <form method="GET" action="{{ route('attestation.types.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px;">
                <input type="text" name="q" value="{{ request('q') }}" class="att-input" style="max-width:300px;" placeholder="নাম বা স্মারক সংক্ষেপ খুঁজুন...">
                <select name="status" class="att-select" style="max-width:180px;">
                    <option value="">সকল অবস্থা</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
                <button type="submit" class="att-btn att-btn-secondary">খুঁজুন</button>
            </form>

            <div style="overflow-x:auto;">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>ক্রম</th>
                            <th>শিরোনাম (নাম)</th>
                            <th>স্মারক নাম</th>
                            <th>ফি (৳)</th>
                            <th>হেডার</th>
                            <th>আবেদন / ইস্যু</th>
                            <th>অবস্থা</th>
                            <th style="text-align:right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $t)
                            <tr>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($t->order) }}</td>
                                <td>
                                    <span style="font-size:18px;margin-right:4px;">{{ $t->icon }}</span>
                                    <strong>{{ $t->name }}</strong>
                                    @if ($t->language === 'en')
                                        <span class="att-badge att-badge-info" style="margin-left:4px;">🌐 EN</span>
                                    @endif
                                    <div style="font-size:12px;color:#64748b;"><code>{{ $t->slug }}</code> {{ $t->description ? '— ' . $t->description : '' }}</div>
                                </td>
                                <td>{{ $t->memo_name }}</td>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$t->fee)) }} ৳</td>
                                <td>
                                    @if ($t->print_options['with_header'] ?? true)
                                        <span class="att-badge att-badge-info">হেডার সহ</span>
                                    @else
                                        <span class="att-badge att-badge-secondary">প্যাড (হেডার ছাড়া)</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($t->applications_count) }} /
                                    {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($t->attestations_count) }}
                                </td>
                                <td>
                                    @if ($t->is_active)
                                        <span class="att-badge att-badge-success">সক্রিয়</span>
                                    @else
                                        <span class="att-badge att-badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('attestation.certificates.create', ['type_id' => $t->id]) }}" class="att-btn att-btn-primary att-btn-sm">সরাসরি ইস্যু</a>
                                    <a href="{{ route('attestation.types.edit', $t) }}" class="att-btn att-btn-outline att-btn-sm">এডিট</a>
                                    <form action="{{ route('attestation.types.destroy', $t) }}" method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="att-btn att-btn-danger att-btn-sm">মুছুন</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                {{ $types->links() }}
            </div>
        </div>
    </div>
@endsection
