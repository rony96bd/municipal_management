@extends(config('attestation.public_layout', 'front-views.templates.othe-page-header'))
@section(config('attestation.public_section', 'page-body'))
<style>
    .pub-att-wrap { max-width: 1080px; margin: 24px auto 48px; padding: 0 16px; font-family: 'Noto Sans Bengali', sans-serif; }
    .pub-hero { background: linear-gradient(135deg, #0f6b3a 0%, #14a05a 100%); color: #fff; border-radius: 12px; padding: 28px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; box-shadow: 0 6px 24px rgba(15,107,58,0.18); }
    .pub-hero h1 { font-size: 26px; font-weight: 700; margin: 0 0 6px 0; color: #fff; }
    .pub-hero p { margin: 0; font-size: 14.5px; opacity: 0.92; }
    .pub-track-btn { background: #fff; color: #0f6b3a; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14.5px; display: inline-flex; align-items: center; gap: 6px; }
    .pub-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
    .pub-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,0.04); transition: transform .15s, border-color .15s; }
    .pub-card:hover { transform: translateY(-2px); border-color: #14a05a; }
    .pub-card h3 { font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0; line-height: 1.4; }
    .pub-card .meta { font-size: 13px; color: #64748b; margin-bottom: 14px; }
    .pub-apply-btn { display: inline-flex; justify-content: center; align-items: center; background: #0f6b3a; color: #fff; text-decoration: none; padding: 9px 16px; border-radius: 7px; font-weight: 600; font-size: 14px; }
    .pub-apply-btn:hover { background: #14a05a; color: #fff; }
</style>

<div class="pub-att-wrap">
    <div class="pub-hero">
        <div>
            <h1>📜 অনলাইন প্রত্যয়ন সেবা</h1>
            <p>{{ config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা') }} — নাগরিকদের বিভিন্ন প্রত্যয়নপত্রের অনলাইন আবেদন ও যাচাই সেবা</p>
        </div>
        <a href="{{ route('attestation.track.index') }}" class="pub-track-btn">🔍 আবেদনের অবস্থা যাচাই করুন →</a>
    </div>

    <form method="GET" action="{{ route('attestation.apply.index') }}" style="display:flex;gap:10px;margin-bottom:20px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="প্রত্যয়নের নাম লিখে খুঁজুন (যেমন: উত্তরাধিকার, অবিবাহিত, আয়)..."
            style="flex:1;padding:11px 14px;border:1px solid #cbd5e1;border-radius:8px;font-size:15px;">
        <button type="submit" style="background:#0f6b3a;color:#fff;border:0;padding:0 22px;border-radius:8px;font-weight:600;cursor:pointer;">খুঁজুন</button>
    </form>

    <div class="pub-grid">
        @forelse ($types as $t)
            <div class="pub-card">
                <div>
                    <div style="font-size:12px;color:#0f6b3a;font-weight:700;margin-bottom:4px;">
                        ক্রমিক #{{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($t->order) }}
                    </div>
                    <h3>{{ $t->name }}</h3>
                    <div class="meta">
                        ফি: <strong>{{ (float)$t->fee > 0 ? \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$t->fee)) . ' টাকা' : 'বিনামূল্যে / অফিসে নির্ধারিত' }}</strong>
                    </div>
                </div>
                <a href="{{ route('attestation.apply.show', $t->slug) }}" class="pub-apply-btn">আবেদন করুন →</a>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:32px;background:#fff;border-radius:10px;border:1px solid #e2e8f0;">
                কোনো প্রত্যয়নের ধরন পাওয়া যায়নি।
            </div>
        @endforelse
    </div>
</div>
@endsection
