@extends(config('attestation.admin_layout', 'dashboard.templates.main'))
@section(config('attestation.admin_section', 'dash-body'))
    <div class="att-wrap">
        @include('attestation::admin._nav')

        <div class="att-card">
            <div class="att-card-header">
                <h1 class="att-title">✍️ স্বাক্ষরকারী কর্মকর্তাগণ</h1>
                <a href="{{ route('attestation.signatories.create') }}" class="att-btn att-btn-primary">➕ নতুন স্বাক্ষরকারী যোগ করুন</a>
            </div>

            <table class="att-table">
                <thead>
                    <tr>
                        <th>প্রিসেট কোড</th>
                        <th>নাম</th>
                        <th>পদবী</th>
                        <th>কার্যালয় / ঠিকানা</th>
                        <th>অবস্থা</th>
                        <th style="text-align:right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($signatories as $sig)
                        <tr>
                            <td><code>{{ $sig->preset_key ?: '-' }}</code></td>
                            <td>{{ $sig->name ?: '(শুধু পদবী ছাপা হবে)' }}</td>
                            <td><strong>{{ $sig->designation }}</strong></td>
                            <td>{{ $sig->office_line }} {{ $sig->extra_line ? '— ' . $sig->extra_line : '' }}</td>
                            <td>
                                @if ($sig->is_active)
                                    <span class="att-badge att-badge-success">সক্রিয়</span>
                                @else
                                    <span class="att-badge att-badge-danger">নিষ্ক্রিয়</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <a href="{{ route('attestation.signatories.edit', $sig) }}" class="att-btn att-btn-outline att-btn-sm">এডিট</a>
                                <form action="{{ route('attestation.signatories.destroy', $sig) }}" method="POST" style="display:inline;" onsubmit="return confirm('মুছে ফেলতে চান?');">
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
    </div>
@endsection
