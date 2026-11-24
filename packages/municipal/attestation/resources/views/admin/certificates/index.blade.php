@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">📜 ইস্যুকৃত প্রত্যয়নসমূহ ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($certificates->total()) }} টি)</h1>
                <a href="{{ route('attestation.certificates.create') }}" class="att-btn att-btn-primary">➕ সরাসরি নতুন প্রত্যয়ন ইস্যু করুন</a>
            </div>

            <form method="GET" action="{{ route('attestation.certificates.index') }}" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
                <input type="text" name="q" value="{{ request('q') }}" class="att-input" style="max-width:240px;" placeholder="স্মারক নং / নাম / যাচাই কোড">
                <select name="type_id" class="att-select" style="max-width:240px;">
                    <option value="">সকল প্রত্যয়নের ধরন</option>
                    @foreach ($types as $t)
                        <option value="{{ $t->id }}" {{ (string)request('type_id') === (string)$t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="att-btn att-btn-secondary">খুঁজুন</button>
            </form>

            <div style="overflow-x:auto;">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>স্মারক নং</th>
                            <th>প্রত্যয়নের ধরন</th>
                            <th>নাম</th>
                            <th>ইস্যুর তারিখ</th>
                            <th>যাচাই কোড (QR)</th>
                            <th>প্রিন্ট সংখ্যা</th>
                            <th>অবস্থা</th>
                            <th style="text-align:right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($certificates as $cert)
                            <tr>
                                <td><strong>{{ $cert->memo_no }}</strong></td>
                                <td>{{ $cert->type?->name }}</td>
                                <td>{{ $cert->subject_name }}</td>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($cert->issue_date?->format('d/m/Y')) }}</td>
                                <td><code>{{ $cert->verification_code }}</code></td>
                                <td>{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($cert->printed_count) }} বার</td>
                                <td>
                                    @if ($cert->is_cancelled)
                                        <span class="att-badge att-badge-danger">বাতিল</span>
                                    @elseif ($cert->handed_over_at)
                                        <span class="att-badge att-badge-secondary">হস্তান্তরিত</span>
                                    @else
                                        <span class="att-badge att-badge-success">বৈধ</span>
                                    @endif
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('attestation.certificates.print', $cert) }}" target="_blank" class="att-btn att-btn-primary att-btn-sm">🖨 প্রিন্ট</a>
                                    <a href="{{ route('attestation.certificates.show', $cert) }}" class="att-btn att-btn-outline att-btn-sm">বিস্তারিত</a>
                                    @if ($cert->is_cancelled)
                                        <form action="{{ route('attestation.certificates.destroy', $cert) }}" method="POST" style="display:inline-block;margin:0 0 0 4px;vertical-align:middle;" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই বাতিল প্রত্যয়নটি স্থায়ীভাবে ডিলিট করতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="att-btn att-btn-danger att-btn-sm" style="background:#dc2626 !important;background-color:#dc2626 !important;color:#ffffff !important;border:1px solid #dc2626 !important;font-family:inherit;font-size:12.5px;font-weight:600;padding:5px 10px;border-radius:5px;line-height:1.4;cursor:pointer;vertical-align:middle;display:inline-flex;align-items:center;gap:4px;">🗑 ডিলিট</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;padding:24px;color:#64748b;">কোনো ইস্যুকৃত প্রত্যয়ন পাওয়া যায়নি।</td>
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
