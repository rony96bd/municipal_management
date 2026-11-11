@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-grid att-grid-4" style="margin-bottom:20px;">
            <div class="att-stat">
                <div class="lbl">বৈধ ইস্যুকৃত সনদ</div>
                <div class="val">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($summary['total_issued']) }} টি</div>
            </div>
            <div class="att-stat">
                <div class="lbl">হস্তান্তরিত সনদ</div>
                <div class="val">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($summary['total_handed_over']) }} টি</div>
            </div>
            <div class="att-stat">
                <div class="lbl">বাতিলকৃত সনদ</div>
                <div class="val" style="color:#dc2626;">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($summary['total_cancelled']) }} টি</div>
            </div>
            <div class="att-stat">
                <div class="lbl">আদায়কৃত মোট ফি</div>
                <div class="val">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$summary['total_fee'])) }} ৳</div>
            </div>
        </div>

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">📈 প্রত্যয়ন রেজিস্টার ও রিপোর্ট</h1>
                <a href="{{ route('attestation.reports.export', request()->query()) }}" class="att-btn att-btn-primary">📥 CSV (Excel) ডাউনলোড করুন</a>
            </div>

            <form method="GET" action="{{ route('attestation.reports.index') }}" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
                <select name="type_id" class="att-select" style="max-width:250px;">
                    <option value="">সকল প্রত্যয়নের ধরন</option>
                    @foreach ($types as $t)
                        <option value="{{ $t->id }}" {{ (string)request('type_id') === (string)$t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
                <select name="ward_no" class="att-select" style="max-width:150px;">
                    <option value="">সকল ওয়ার্ড</option>
                    @foreach (['০১','০২','০৩','০৪','০৫','০৬','০৭','০৮','০৯'] as $w)
                        <option value="{{ $w }}" {{ request('ward_no') === $w ? 'selected' : '' }}>ওয়ার্ড {{ $w }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="att-input" style="max-width:160px;">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="att-input" style="max-width:160px;">
                <button type="submit" class="att-btn att-btn-secondary">ফিল্টার করুন</button>
                <a href="{{ route('attestation.reports.index') }}" class="att-btn att-btn-outline">রিসেট</a>
            </form>

            <div style="overflow-x:auto;">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>স্মারক নং</th>
                            <th>ইস্যুর তারিখ</th>
                            <th>প্রত্যয়নের ধরন</th>
                            <th>নাম</th>
                            <th>ওয়ার্ড</th>
                            <th>ফি (৳)</th>
                            <th>যাচাই কোড</th>
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($certificates as $cert)
                            <tr>
                                <td><strong>{{ $cert->memo_no }}</strong></td>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($cert->issue_date?->format('d/m/Y')) }}</td>
                                <td>{{ $cert->type?->name }}</td>
                                <td>{{ $cert->subject_name }}</td>
                                <td>{{ $cert->application?->ward_no ?? ($cert->snapshot['person']['ward_no'] ?? '-') }}</td>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$cert->paid_amount)) }} ৳</td>
                                <td><code>{{ $cert->verification_code }}</code></td>
                                <td>
                                    <a href="{{ route('attestation.certificates.print', $cert) }}" target="_blank" class="att-btn att-btn-primary att-btn-sm">🖨 প্রিন্ট</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;padding:24px;color:#64748b;">কোনো রেকর্ড পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                {{ $certificates->links() }}
            </div>
        </div>
    </div>
@endsection
