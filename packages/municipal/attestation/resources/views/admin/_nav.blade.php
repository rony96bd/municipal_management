<style>
    .att-wrap { font-family: 'Noto Sans Bengali', sans-serif; color: #1e293b; max-width: 1280px; margin: 0 auto; }
    .att-subnav { display: flex; flex-wrap: wrap; gap: 8px; background: #ffffff; padding: 12px 16px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; align-items: center; border: 1px solid #e2e8f0; }
    .att-subnav a { text-decoration: none; padding: 8px 14px; border-radius: 7px; font-size: 14px; font-weight: 600; color: #334155; transition: all .15s; display: inline-flex; align-items: center; gap: 6px; }
    .att-subnav a:hover { background: #f1f5f9; color: #0f6b3a; }
    .att-subnav a.active { background: #0f6b3a; color: #ffffff; }
    .att-subnav .spacer { flex: 1; }
    .att-card { background: #ffffff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .att-card-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; padding-bottom: 14px; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; }
    .att-title { font-size: 20px; font-weight: 700; color: #0f172a; margin: 0; }
    .att-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 7px; font-size: 14px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: opacity .15s; }
    .att-btn:hover { opacity: .92; }
    .att-btn-primary { background: #0f6b3a; color: #fff; }
    .att-btn-secondary { background: #475569; color: #fff; }
    .att-btn-outline { background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; }
    .att-btn-danger { background: #dc2626; color: #fff; }
    .att-btn-warning { background: #d97706; color: #fff; }
    .att-btn-sm { padding: 5px 10px; font-size: 12.5px; border-radius: 5px; }
    .att-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .att-table th { background: #f8fafc; color: #334155; font-weight: 700; text-align: left; padding: 11px 12px; border-bottom: 2px solid #e2e8f0; }
    .att-table td { padding: 11px 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .att-table tr:hover td { background: #f8fafc; }
    .att-badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .att-badge-warning { background: #fef3c7; color: #92400e; }
    .att-badge-info { background: #dbeafe; color: #1e40af; }
    .att-badge-success { background: #dcfce7; color: #166534; }
    .att-badge-danger { background: #fee2e2; color: #991b1b; }
    .att-badge-secondary { background: #e2e8f0; color: #334155; }
    .att-grid { display: grid; gap: 16px; }
    .att-grid-2 { grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); }
    .att-grid-3 { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
    .att-grid-4 { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
    .att-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px; }
    .att-field label { font-size: 13.5px; font-weight: 600; color: #334155; }
    .att-input, .att-select, .att-textarea { width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 14px; font-family: inherit; background: #fff; color: #0f172a; }
    .att-input:focus, .att-select:focus, .att-textarea:focus { outline: none; border-color: #0f6b3a; box-shadow: 0 0 0 3px rgba(15,107,58,0.12); }
    .att-alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: 500; }
    .att-alert-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .att-alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .att-stat { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; }
    .att-stat .lbl { font-size: 13px; color: #64748b; margin-bottom: 4px; }
    .att-stat .val { font-size: 24px; font-weight: 700; color: #0f6b3a; }
</style>

<div class="att-subnav">
    <a href="{{ route('attestation.index') }}" class="{{ request()->routeIs('attestation.index') ? 'active' : '' }}">📊 ড্যাশবোর্ড</a>
    <a href="{{ route('attestation.certificates.create') }}" class="{{ request()->routeIs('attestation.certificates.create') ? 'active' : '' }}">➕ সরাসরি প্রত্যয়ন ইস্যু</a>
    <a href="{{ route('attestation.applications.index') }}" class="{{ request()->routeIs('attestation.applications.*') ? 'active' : '' }}">📥 নাগরিক আবেদনসমূহ</a>
    <a href="{{ route('attestation.certificates.index') }}" class="{{ request()->routeIs('attestation.certificates.index') || request()->routeIs('attestation.certificates.show') ? 'active' : '' }}">📜 ইস্যুকৃত সনদসমূহ</a>
    <a href="{{ route('attestation.types.index') }}" class="{{ request()->routeIs('attestation.types.*') ? 'active' : '' }}">🗂️ প্রত্যয়নের ধরন (২৮+)</a>
    <a href="{{ route('attestation.signatories.index') }}" class="{{ request()->routeIs('attestation.signatories.*') ? 'active' : '' }}">✍️ স্বাক্ষরকারী</a>
    <a href="{{ route('attestation.reports.index') }}" class="{{ request()->routeIs('attestation.reports.*') ? 'active' : '' }}">📈 রেজিস্টার ও রিপোর্ট</a>
    <div class="spacer"></div>
    <a href="{{ route('attestation.apply.index') }}" target="_blank" style="background:#f0fdf4;color:#0f6b3a;border:1px solid #bbf7d0;">🌐 পাবলিক আবেদন পেজ ↗</a>
</div>

@if (session('success'))
    <div class="att-alert att-alert-success">✅ {{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="att-alert att-alert-danger">⚠️ {{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="att-alert att-alert-danger">
        <strong>অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</strong>
        <ul style="margin:6px 0 0 18px;">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
