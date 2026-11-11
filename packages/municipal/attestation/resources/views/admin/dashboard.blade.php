@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-grid att-grid-4" style="margin-bottom:20px;">
            <div class="att-stat">
                <div class="lbl">সক্রিয় প্রত্যয়নের ধরন</div>
                <div class="val">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($stats['types_count']) }} টি</div>
            </div>
            <div class="att-stat">
                <div class="lbl">অপেক্ষমান আবেদন</div>
                <div class="val" style="color:#d97706;">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($stats['pending_count'] + $stats['under_review_count']) }} টি</div>
            </div>
            <div class="att-stat">
                <div class="lbl">মোট ইস্যুকৃত প্রত্যয়ন</div>
                <div class="val">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($stats['issued_count']) }} টি</div>
            </div>
            <div class="att-stat">
                <div class="lbl">মোট আদায়কৃত ফি</div>
                <div class="val">{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$stats['total_revenue'])) }} ৳</div>
            </div>
        </div>

        <div class="att-grid att-grid-2">
            <div class="att-card">
                <div class="att-card-header">
                    <h2 class="att-title">📥 সাম্প্রতিক নাগরিক আবেদন</h2>
                    <a href="{{ route('attestation.applications.index') }}" class="att-btn att-btn-outline att-btn-sm">সব দেখুন →</a>
                </div>
                @if ($recentApplications->isEmpty())
                    <p style="color:#64748b;font-size:14px;">এখনো কোনো আবেদন জমা পড়েনি।</p>
                @else
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th>ট্র্যাকিং নং</th>
                                <th>আবেদনকারী</th>
                                <th>ধরন</th>
                                <th>অবস্থা</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentApplications as $app)
                                <tr>
                                    <td><code>{{ $app->tracking_no }}</code></td>
                                    <td>{{ $app->applicant_name }}</td>
                                    <td>{{ $app->type?->name }}</td>
                                    <td>
                                        <span class="att-badge att-badge-{{ $app->status->badge() }}">
                                            {{ $app->status->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('attestation.applications.show', $app) }}" class="att-btn att-btn-primary att-btn-sm">দেখুন</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="att-card">
                <div class="att-card-header">
                    <h2 class="att-title">📜 সাম্প্রতিক ইস্যুকৃত প্রত্যয়ন</h2>
                    <a href="{{ route('attestation.certificates.create') }}" class="att-btn att-btn-primary att-btn-sm">➕ নতুন ইস্যু করুন</a>
                </div>
                @if ($recentCertificates->isEmpty())
                    <p style="color:#64748b;font-size:14px;">এখনো কোনো প্রত্যয়ন ইস্যু করা হয়নি।</p>
                @else
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th>স্মারক নং</th>
                                <th>নাম</th>
                                <th>ধরন</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentCertificates as $cert)
                                <tr>
                                    <td><strong>{{ $cert->memo_no }}</strong></td>
                                    <td>{{ $cert->subject_name }}</td>
                                    <td>{{ $cert->type?->name }}</td>
                                    <td style="white-space:nowrap;">
                                        <a href="{{ route('attestation.certificates.print', $cert) }}" target="_blank" class="att-btn att-btn-primary att-btn-sm">🖨 প্রিন্ট</a>
                                        <a href="{{ route('attestation.certificates.show', $cert) }}" class="att-btn att-btn-outline att-btn-sm">বিস্তারিত</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
