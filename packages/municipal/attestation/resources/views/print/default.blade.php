@php
    $org = $snapshot['organization'] ?? config('attestation.organization', []);
    $isEnglish = (($snapshot['language'] ?? $certificate->type?->language ?? 'bn') === 'en');
    $issueDateFormatted = $certificate->issue_date ? $certificate->issue_date->format('d/m/Y') : now()->format('d/m/Y');
    $issueDateDisplay = $isEnglish
        ? $issueDateFormatted
        : \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($issueDateFormatted);
    $verifyUrl = route('attestation.verify.show', $certificate->verification_code);
    $signatories = $snapshot['signatories'] ?? [];
    $padTop = $padTop ?? 1.5;

    $siteSettings = class_exists(\App\Models\SiteSettings::class) ? \App\Models\SiteSettings::first() : null;
    $siteFont = !empty($siteSettings?->google_font) ? $siteSettings->google_font : config('attestation.print.font', 'Tiro Bangla');

    $activeFont = $fontFamily ?? ($snapshot['print_options']['font_family'] ?? $siteFont);
    $numFontSize = (float) preg_replace('/[^0-9.]/', '', (string) ($fontSize ?? ($snapshot['print_options']['font_size'] ?? '14')));
    if ($numFontSize < 9 || $numFontSize > 22) $numFontSize = 14;

    $numLineHeight = (float) ($lineHeight ?? ($snapshot['print_options']['line_height'] ?? 1.8));
    if ($numLineHeight < 1.1 || $numLineHeight > 3) $numLineHeight = 1.8;

    $activeSpacing = $sectionSpacing ?? ($snapshot['print_options']['section_spacing'] ?? 'normal');
    $typeId = $snapshot['type_id'] ?? $certificate->attestation_type_id ?? 'global';
@endphp
<!DOCTYPE html>
<html lang="{{ $isEnglish ? 'en' : 'bn' }}">
<head>
<meta charset="utf-8">
<title>{{ $certificate->memo_no }} — {{ $snapshot['type_name'] ?? 'প্রত্যয়ন পত্র' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;500;600;700&family=Baloo+Da+2:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@400;500;600;700&family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
@if ($siteFont && !in_array($siteFont, ['Tiro Bangla', 'Hind Siliguri', 'Noto Sans Bengali', 'Noto Serif Bengali', 'Anek Bangla', 'Baloo Da 2']))
<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $siteFont) }}:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
@endif
@if ($activeFont && $activeFont !== $siteFont && !in_array($activeFont, ['Tiro Bangla', 'Hind Siliguri', 'Noto Sans Bengali', 'Noto Serif Bengali', 'Anek Bangla', 'Baloo Da 2']) && !str_contains($activeFont, 'Kalpurush'))
<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $activeFont) }}:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
@endif
<style>
  :root {
    --brand: #0f6b3a;
    --brand-2: #14a05a;
    --ink: #1b2430;
    --muted: #5d6b7a;
    --line: #d9e2dc;
    --paper: #fff;
    --pad-top: {{ $padTop }}in;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: var(--font-family, '{{ $activeFont }}', 'Tiro Bangla', serif);
    color: var(--ink);
    background: #e9eeeb;
    padding: 14px 20px 40px;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

  /* Toolbar */
  .toolbar-wrapper {
    position: sticky;
    top: 8px;
    z-index: 999;
    max-width: 210mm;
    margin: 0 auto 14px;
  }
  .toolbar {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .toolbar-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
  }
  .toolbar-nav {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    align-items: center;
  }
  .btn-tool {
    font: 600 13px inherit;
    padding: 7px 13px;
    border-radius: 7px;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all .15s ease;
    line-height: 1.3;
    white-space: nowrap;
  }
  .btn-tool.btn-primary { background: var(--brand); color: #fff; }
  .btn-tool.btn-primary:hover { background: #0c522d; }
  .btn-tool.btn-outline { background: #fff; color: var(--ink); border-color: #cbd5e1; }
  .btn-tool.btn-outline:hover { background: #f8fafc; border-color: #94a3b8; }
  .btn-tool.btn-autofit { background: #0284c7; color: #fff; }
  .btn-tool.btn-autofit:hover { background: #0369a1; }
  .btn-tool.btn-reset { background: #64748b; color: #fff; }
  .btn-tool.btn-reset:hover { background: #475569; }
  .btn-tool.active-edit { background: #1d4ed8 !important; color: #fff !important; border-color: #1d4ed8 !important; }

  .pad-preset-btn { background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 2px 5px; font-size: 11px; color: #334155; cursor: pointer; }
  .pad-preset-btn:hover { background: #0f6b3a; color: #fff; border-color: #0f6b3a; }

  /* Control Panel in Toolbar */
  .ctrl-bar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px 12px;
    background: #f8fafc;
    padding: 7px 12px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    font-size: 13px;
  }
  .ctrl-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .ctrl-label {
    font-weight: 600;
    color: #475569;
    white-space: nowrap;
    font-size: 12.5px;
  }
  .ctrl-select {
    font-family: inherit;
    font-size: 12.5px;
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    background: #fff;
    color: var(--ink);
    cursor: pointer;
  }
  .ctrl-stepper {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 2px 4px;
  }
  .btn-step {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #1e293b;
    font-weight: 700;
    font-size: 11.5px;
    min-width: 24px;
    height: 22px;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .btn-step:hover { background: #e2e8f0; }
  .ctrl-slider {
    width: 65px;
    cursor: pointer;
  }
  .ctrl-badge {
    font-family: monospace;
    font-weight: 700;
    color: var(--brand);
    min-width: 44px;
    text-align: center;
    font-size: 12px;
  }

  /* Live Fit Status */
  .status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 999px;
    line-height: 1.2;
    margin-left: auto;
  }
  .status-ok { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
  .status-warn { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; animation: pulse 2s infinite; }
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.75; }
  }

  /* Sheet Layout */
  .sheet {
    position: relative;
    width: 210mm;
    height: 297mm;
    min-height: 297mm;
    max-height: 297mm;
    margin: 0 auto;
    background: var(--paper);
    padding: 14mm 16mm 44mm;
    box-shadow: 0 10px 40px rgba(0,0,0,.15);
    overflow: hidden;
    font-family: var(--font-family, '{{ $activeFont }}', 'Tiro Bangla', serif);
    --font-family: '{{ $activeFont }}', 'Tiro Bangla', 'SolaimanLipi', 'Kalpurush', sans-serif;
    --content-font-size: {{ $numFontSize }}px;
    --content-line-height: {{ $numLineHeight }};
    --section-spacing: 3.5mm;
    --table-padding-y: 5px;
    --table-padding-x: 8px;
    --sign-space: 14mm;
    transition: outline .2s ease;
  }
  .sheet.pad-mode { padding-top: 0 !important; }
  .sheet[contenteditable="true"] { outline: 3px dashed #2563eb; outline-offset: -4px; background: #fffef7; }
  .sheet.has-overflow { outline: 3px dashed #ef4444; }

  @if ($withHeader)
  /* Border Frame */
  .sheet::before { content: ""; position: absolute; inset: 6mm; border: 1.2px solid var(--brand); border-radius: 6px; pointer-events: none; }
  .sheet::after { content: ""; position: absolute; inset: 7.6mm; border: .5px solid var(--brand-2); border-radius: 4px; pointer-events: none; opacity: .6; }
  .topbar { position: absolute; top: 6mm; left: 6mm; right: 6mm; height: 3mm; border-radius: 6px 6px 0 0; background: linear-gradient(90deg, var(--brand), var(--brand-2)); }
  @endif
  .watermark { position: absolute; left: 50%; top: 52%; width: 120mm; height: 120mm; transform: translate(-50%,-50%); background: var(--logo) center/contain no-repeat; opacity: .07; filter: grayscale(1); mix-blend-mode: multiply; pointer-events: none; }

  header { position: relative; display: flex; align-items: center; gap: 14px; padding: 4mm 0 4mm; border-bottom: 1px solid var(--line); }
  header .logo { width: 22mm; height: 22mm; object-fit: contain; }
  header .titles { flex: 1; text-align: center; }
  .bismillah { font-size: 11px; color: var(--muted); margin-bottom: 2px; }
  .gov { font-size: 11.5px; color: var(--muted); letter-spacing: .3px; }
  .org { font-size: 25px; font-weight: 700; color: var(--brand); line-height: 1.25; }
  .sub { font-size: 12px; color: var(--muted); }
  header .spacer { width: 22mm; }

  .pad-spacer {
    position: relative;
    width: 100%;
    height: var(--pad-top, 1.5in);
    border-bottom: 1.5px dashed #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 12px;
    margin-bottom: 4mm;
    user-select: none;
  }

  /* Flowing Content Block */
  .sheet-content {
    position: relative;
  }
  .meta {
    position: relative;
    display: flex;
    justify-content: space-between;
    margin-top: calc(var(--section-spacing) * 0.9);
    font-size: calc(var(--content-font-size) - 0.5px);
  }
  .meta b { color: var(--brand); font-weight: 600; }

  .title {
    position: relative;
    text-align: center;
    margin: calc(var(--section-spacing) * 1.1) 0 calc(var(--section-spacing) * 0.9);
  }
  .title span {
    display: inline-block;
    padding: 6px 32px;
    border-radius: 999px;
    font-size: 19px;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(90deg, var(--brand), var(--brand-2));
    letter-spacing: .3px;
  }

  .lead {
    position: relative;
    font-size: var(--content-font-size);
    line-height: var(--content-line-height);
    margin-bottom: calc(var(--section-spacing) * 0.7);
  }
  .details {
    position: relative;
    width: 100%;
    border-collapse: collapse;
    margin-bottom: var(--section-spacing);
    font-size: var(--content-font-size);
    line-height: var(--content-line-height);
  }
  .details td {
    padding: var(--table-padding-y) var(--table-padding-x);
    border-bottom: 1px dashed var(--line);
    vertical-align: top;
  }
  .details td:first-child { width: 36%; color: var(--muted); }
  .details td:nth-child(2) { width: 14px; color: var(--muted); }
  .details td:last-child { font-weight: 600; }

  .body {
    position: relative;
    font-size: var(--content-font-size);
    line-height: var(--content-line-height);
    text-align: justify;
    margin-bottom: var(--section-spacing);
  }
  .body p {
    margin-bottom: calc(var(--section-spacing) * 0.5);
  }
  .body p:last-child {
    margin-bottom: 0;
  }

  .rep-wrap {
    position: relative;
    margin: calc(var(--section-spacing) * 0.8) 0;
  }
  .rep-title {
    font-size: calc(var(--content-font-size) - 0.5px);
    font-weight: 700;
    color: var(--brand);
    margin-bottom: 3px;
  }
  .rep-table {
    width: 100%;
    border-collapse: collapse;
    font-size: calc(var(--content-font-size) - 1.5px);
    line-height: calc(var(--content-line-height) - 0.2);
  }
  .rep-table th, .rep-table td {
    border: 1px solid #cbd5e1;
    padding: calc(var(--table-padding-y) - 1px) 7px;
    text-align: left;
  }
  .rep-table th { background: #f1f5f9; font-weight: 700; color: var(--ink); }

  .wish {
    position: relative;
    margin-top: calc(var(--section-spacing) * 0.8);
    font-size: var(--content-font-size);
    line-height: var(--content-line-height);
  }

  .guardians {
    position: relative;
    display: flex;
    justify-content: space-around;
    gap: 12mm;
    margin-top: calc(var(--section-spacing) * 1.5);
    padding-top: 3mm;
  }
  .guardian-box {
    text-align: center;
    min-width: 52mm;
    font-size: calc(var(--content-font-size) - 1.5px);
  }
  .guardian-box .line { border-top: 1px dashed var(--ink); padding-top: 4px; font-weight: 600; }

  /* Footer Area (QR & Signatures) */
  .footer {
    position: absolute;
    left: 16mm;
    right: 16mm;
    bottom: 13mm;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 6mm;
    z-index: 10;
  }
  .verify { display: flex; flex-direction: column; align-items: flex-start; gap: 3px; flex: 0 0 auto; width: 30mm; }
  .qr { flex: 0 0 auto; padding: 4px; border: 1px solid var(--line); border-radius: 10px; background: #fff; line-height: 0; }
  .qr svg, .qr img { width: 22mm; height: 22mm; display: block; }
  .verify .txt { font-size: 8.5px; color: var(--muted); line-height: 1.35; max-width: 30mm; }
  .verify .txt b { display: block; color: var(--ink); font-size: 9.5px; }
  .verify .code { font-family: monospace; font-size: 8.5px; white-space: nowrap; color: var(--brand); letter-spacing: .8px; }

  .signs { display: flex; align-items: flex-end; justify-content: flex-end; gap: 4mm; flex: 1 1 auto; min-width: 0; }
  .sign { text-align: center; flex: 1 1 0; min-width: 0; max-width: 62mm; font-size: 11.5px; }
  .sign .space { height: var(--sign-space, 14mm); }
  .sign .line { border-top: 1px solid var(--ink); padding-top: 4px; font-weight: 600; }
  .sign small { display: block; color: var(--muted); font-weight: 400; line-height: 1.35; }
  .bottomnote { position: absolute; left: 0; right: 0; bottom: 8.4mm; text-align: center; font-size: 9.5px; color: var(--muted); }

  /* Print Stylesheet */
  @page { size: A4; margin: 0; }
  @media print {
    body { background: none; padding: 0; }
    .toolbar-wrapper, .no-print { display: none !important; }
    .sheet {
      box-shadow: none;
      margin: 0;
      width: 210mm;
      height: 297mm;
      min-height: 297mm;
      max-height: 297mm;
      overflow: hidden;
      page-break-after: avoid;
      page-break-inside: avoid;
      outline: none !important;
      background: #fff !important;
    }
    .pad-spacer { border-bottom: none !important; margin-bottom: 0 !important; }
    .pad-spacer * { display: none !important; }
  }
</style>
</head>
<body>

<div class="toolbar-wrapper">
  <div class="toolbar">
    <div class="toolbar-row">
      <div class="toolbar-nav">
        <a href="{{ route('attestation.certificates.show', $certificate) }}" class="btn-tool btn-outline">← বিস্তারিত পেজ</a>
        <a href="{{ route('attestation.certificates.print', [$certificate, 'with_header' => $withHeader ? 0 : 1, 'watermark' => $withWatermark ? 1 : 0]) }}" class="btn-tool btn-outline">
          {{ $withHeader ? '📄 প্যাড মোড (হেডার ছাড়া)' : '🏛️ লেটারহেড মোড (হেডার সহ)' }}
        </a>
        <a href="{{ route('attestation.certificates.print', [$certificate, 'with_header' => $withHeader ? 1 : 0, 'watermark' => $withWatermark ? 0 : 1]) }}" class="btn-tool btn-outline">
          {{ $withWatermark ? '💧 জলছাপ বন্ধ' : '💧 জলছাপ চালু' }}
        </a>

        @unless ($withHeader)
          <div style="display:inline-flex;align-items:center;gap:5px;background:#fff;border:1px solid #cbd5e1;border-radius:7px;padding:3px 8px;font:600 12.5px inherit;color:#1b2430">
            <span style="color:#0f6b3a;">⬍ প্যাড মার্জিন:</span>
            <button type="button" onclick="stepPad(-0.1)" title="০.১ ইঞ্চি কমান" style="background:#f1f5f9;border:1px solid #cbd5e1;border-radius:4px;padding:2px 6px;font-weight:700;cursor:pointer;color:#0f6b3a;">−</button>
            <input type="number" id="padTopInput" min="0" max="6" step="0.1" value="{{ $padTop }}" style="width:52px;padding:2px 4px;border:1px solid #cbd5e1;border-radius:4px;text-align:center;font-weight:700;font-size:12px;">
            <span style="font-size:11.5px;color:#64748b;">ইঞ্চি</span>
            <button type="button" onclick="stepPad(0.1)" title="০.১ ইঞ্চি বাড়ান" style="background:#f1f5f9;border:1px solid #cbd5e1;border-radius:4px;padding:2px 6px;font-weight:700;cursor:pointer;color:#0f6b3a;">+</button>
            <div style="display:inline-flex;gap:3px;margin-left:3px;">
              <button type="button" onclick="setPadVal(1.0)" class="pad-preset-btn">1.0″</button>
              <button type="button" onclick="setPadVal(1.5)" class="pad-preset-btn">1.5″</button>
              <button type="button" onclick="setPadVal(1.8)" class="pad-preset-btn">1.8″</button>
              <button type="button" onclick="setPadVal(2.0)" class="pad-preset-btn">2.0″</button>
            </div>
          </div>
        @endunless

        <button type="button" class="btn-tool btn-outline" id="directEditBtn" onclick="togglePrintEdit()">✎ সরাসরি এডিট</button>
        <button type="button" class="btn-tool btn-outline" onclick="exportDocFile()">📄 Word (.doc)</button>
      </div>

      <div class="toolbar-nav">
        <button type="button" class="btn-tool btn-primary" onclick="window.print()">🖨 প্রিন্ট করুন (A4)</button>
      </div>
    </div>

    <div class="ctrl-bar">
      <div class="ctrl-item">
        <span class="ctrl-label">ফন্ট:</span>
        <select id="ctrlFont" class="ctrl-select">
          <option value="{{ $siteFont }}">সাইটের ফন্ট ({{ $siteFont }})</option>
          <option value="Tiro Bangla">Tiro Bangla (টিরো বাংলা)</option>
          <option value="Hind Siliguri">Hind Siliguri (হিন্দ শিলিগুড়ি)</option>
          <option value="Noto Sans Bengali">Noto Sans (নোতো সান্স)</option>
          <option value="Noto Serif Bengali">Noto Serif (নোতো সেরিফ)</option>
          <option value="Anek Bangla">Anek Bangla (অনেক বাংলা)</option>
          <option value="Baloo Da 2">Baloo Da 2 (বালু দা)</option>
          <option value="'Kalpurush', 'SolaimanLipi', sans-serif">Kalpurush / SolaimanLipi</option>
        </select>
      </div>

      <div class="ctrl-item">
        <span class="ctrl-label">ফন্ট সাইজ:</span>
        <div class="ctrl-stepper">
          <button type="button" class="btn-step" id="btnFontMinus" title="ফন্ট সাইজ কমান">A−</button>
          <input type="range" class="ctrl-slider" id="rngFontSize" min="10" max="18" step="0.5" value="{{ $numFontSize }}">
          <span class="ctrl-badge" id="valFontSize">{{ $numFontSize }}px</span>
          <button type="button" class="btn-step" id="btnFontPlus" title="ফন্ট সাইজ বাড়ান">A+</button>
        </div>
      </div>

      <div class="ctrl-item">
        <span class="ctrl-label">লাইন হাইট:</span>
        <div class="ctrl-stepper">
          <button type="button" class="btn-step" id="btnLhMinus" title="লাইন হাইট কমান">−</button>
          <input type="range" class="ctrl-slider" id="rngLineHeight" min="1.2" max="2.3" step="0.05" value="{{ $numLineHeight }}">
          <span class="ctrl-badge" id="valLineHeight">{{ $numLineHeight }}</span>
          <button type="button" class="btn-step" id="btnLhPlus" title="লাইন হাইট বাড়ান">+</button>
        </div>
      </div>

      <div class="ctrl-item">
        <span class="ctrl-label">স্পেস:</span>
        <select id="ctrlSpacing" class="ctrl-select">
          <option value="compact">আঁটোসাঁটো (Compact)</option>
          <option value="normal">স্বাভাবিক (Normal)</option>
          <option value="spacious">খোলামেলা (Spacious)</option>
        </select>
      </div>

      <div class="ctrl-item">
        <button type="button" class="btn-tool btn-autofit" id="btnAutoFit" title="লেখা যেন স্বাক্ষরের ভিতরে না যায়, স্বয়ংক্রিয়ভাবে ১ পাতায় সাজান">
          ⚡ এক পাতায় ফিট
        </button>
        <button type="button" class="btn-tool btn-reset" id="btnReset" title="মূল সাইজে রিসেট করুন">
          🔄 রিসেট
        </button>
      </div>

      <div id="statusBadge" class="status-indicator status-ok">
        <span id="statusText">✓ ১ পাতায় সম্পূর্ণ ফিট</span>
      </div>
    </div>
  </div>
</div>

<div class="sheet {{ !$withHeader ? 'pad-mode' : '' }}" id="sheet">
  @if (!empty($snapshot['override_html']))
    {!! \App\Support\HtmlSanitizer::clean($snapshot['override_html']) !!}
  @else
    @if ($withHeader)
      <div class="topbar"></div>
    @endif
    @if ($withWatermark)
      <div class="watermark"></div>
    @endif

    @if ($withHeader)
      <header>
        <img class="logo" id="logoImg" src="{{ $logo }}" alt="logo">
        <div class="titles">
          @if ($isEnglish)
            <div class="gov">Government of the People's Republic of Bangladesh</div>
            <div class="org">Office of the Alamdanga Pourashava</div>
            <div class="sub">Alamdanga, Chuadanga</div>
            <div class="sub">Phone: 02477786245 | Email: alamdangapourashava@gmail.com | Web: www.alamdangapourashava.org</div>
          @else
            @if (!empty($org['bismillah']))
              <div class="bismillah">{{ $org['bismillah'] }}</div>
            @endif
            <div class="gov">{{ $org['gov_line'] ?? 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকার' }}</div>
            <div class="org">{{ $org['name'] ?? 'আলমডাঙ্গা পৌরসভা' }}</div>
            <div class="sub">{{ $org['address'] ?? ($org['sub_title'] ?? 'আলমডাঙ্গা, চুয়াডাঙ্গা') }}</div>
            @if (!empty($org['mobile']) || !empty($org['email']))
              <div class="sub">মোবাইল: {{ $org['mobile'] ?? '' }} {{ !empty($org['email']) ? '| ই-মেইল: ' . $org['email'] : '' }}</div>
            @endif
          @endif
        </div>
        <div class="spacer"></div>
      </header>
    @else
      <div class="pad-spacer" id="padSpacer">
        <span>[ ⬍ প্যাড মার্জিন: <b id="padGuideVal">{{ $padTop }}</b> ইঞ্চি ফাঁকা (নিচে প্রিন্ট শুরু) ]</span>
      </div>
    @endif

    <div class="sheet-content" id="sheetContent">
      <div class="meta">
        <div><b>{{ $isEnglish ? 'Memo No:' : 'স্মারক নং:' }}</b> {{ $certificate->memo_no }}</div>
        <div><b>{{ $isEnglish ? 'Date:' : 'তারিখ:' }}</b> {{ $issueDateDisplay }}</div>
      </div>

      <div class="title"><span>{{ $snapshot['type_name'] ?? $certificate->type?->name }}</span></div>

      <p class="lead">{{ $snapshot['lead_line'] ?? ($isEnglish ? 'This is to certify that,' : 'এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে,') }}</p>

      @if (!empty($snapshot['person_rows']))
        <table class="details">
          @foreach ($snapshot['person_rows'] as $row)
            <tr>
              <td>{{ $row['label'] }}</td>
              <td>:</td>
              <td>{{ $row['value'] }}</td>
            </tr>
          @endforeach
        </table>
      @endif

      @if (!empty($snapshot['rendered_body']))
        <div class="body">{!! \App\Support\HtmlSanitizer::clean($snapshot['rendered_body']) !!}</div>
      @endif

      @if (!empty($snapshot['tables']))
        @foreach ($snapshot['tables'] as $tbl)
          <div class="rep-wrap">
            @if (!empty($tbl['label']))
              <div class="rep-title">{{ $tbl['label'] }}:</div>
            @endif
            <table class="rep-table">
              <thead>
                <tr>
                  @foreach ($tbl['columns'] as $col)
                    <th>{{ $col['label'] ?? $col['key'] }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach ($tbl['rows'] as $r)
                  <tr>
                    @foreach ($tbl['columns'] as $col)
                      <td>{{ $r[$col['key']] ?? '' }}</td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach
      @endif

      @if (!empty($snapshot['closing_line']))
        <p class="wish">{{ $snapshot['closing_line'] }}</p>
      @endif

      @if (!empty($snapshot['guardian_signatures']))
        <div class="guardians">
          <div class="guardian-box">
            <div class="line">
              ১ম অভিভাবকের স্বাক্ষর
              <div style="font-weight:400;color:var(--muted);font-size:11.5px;">
                {{ $snapshot['data']['guardian_1_name'] ?? '' }}
                {{ !empty($snapshot['data']['guardian_1_relation']) ? '(' . $snapshot['data']['guardian_1_relation'] . ')' : '' }}
              </div>
            </div>
          </div>
          <div class="guardian-box">
            <div class="line">
              ২য় অভিভাবকের স্বাক্ষর
              <div style="font-weight:400;color:var(--muted);font-size:11.5px;">
                {{ $snapshot['data']['guardian_2_name'] ?? '' }}
                {{ !empty($snapshot['data']['guardian_2_relation']) ? '(' . $snapshot['data']['guardian_2_relation'] . ')' : '' }}
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>

    <div class="footer" id="sheetFooter">
      <div class="verify">
        <div class="qr" id="qr"></div>
        <div class="txt">
          <b>{{ $isEnglish ? 'Verify Online' : 'অনলাইনে যাচাই করুন' }}</b>
          <div class="code">{{ $isEnglish ? 'Code:' : 'কোড:' }} {{ $certificate->verification_code }}</div>
        </div>
      </div>

      <div class="signs">
        @foreach ($signatories as $sig)
          <div class="sign">
            <div class="space"></div>
            <div class="line">
              @if (!empty($sig['name']))
                <div>{{ $sig['name'] }}</div>
              @endif
              <small><b>{{ $sig['designation'] ?? '' }}</b></small>
              @if (!empty($sig['office_line']))
                <small>{{ $sig['office_line'] }}</small>
              @endif
              @if (!empty($sig['extra_line']))
                <small>{{ $sig['extra_line'] }}</small>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="bottomnote">
      {{ $isEnglish ? 'Computer generated certificate; invalid without authorized signature and seal.' : 'এটি কম্পিউটার-নির্মিত প্রত্যয়ন; কর্তৃপক্ষের স্বাক্ষর ও সিল ব্যতীত বৈধ নয়।' }}
    </div>
  @endif
</div>

<script>{!! \Municipal\Attestation\Support\AssetHelper::qrcodeJs() !!}</script>
<script>
(function() {
  const logo = @json($logo);
  const sheet = document.getElementById('sheet');
  const sheetContent = document.getElementById('sheetContent');
  const sheetFooter = document.getElementById('sheetFooter');
  const typeId = @json($typeId);
  const storageKey = 'att_print_prefs_' + typeId;

  if (sheet) {
    sheet.style.setProperty('--logo', `url('${logo}')`);
  }

  // Pad Top Controller
  (function () {
    const inp = document.getElementById('padTopInput');
    const guideVal = document.getElementById('padGuideVal');
    const key = 'attestation_pad_top';
    const urlHas = new URLSearchParams(location.search).has('pad');
    const saved = localStorage.getItem(key);

    if (inp && sheet) {
      if (!urlHas && saved !== null && saved !== '') {
        inp.value = saved;
      }

      window.setPadVal = function (v) {
        inp.value = v;
        applyPad();
      };

      window.stepPad = function (delta) {
        let cur = parseFloat(inp.value) || 1.5;
        cur = Math.round((cur + delta) * 10) / 10;
        if (cur < 0) cur = 0;
        if (cur > 6) cur = 6;
        inp.value = cur;
        applyPad();
      };

      function applyPad() {
        const v = Math.max(0, Math.min(6, parseFloat(inp.value) || 0));
        sheet.style.setProperty('--pad-top', v + 'in');
        if (guideVal) guideVal.textContent = v;
        localStorage.setItem(key, v);
      }

      inp.addEventListener('input', applyPad);
      applyPad();
    }
  })();

  const url = @json($verifyUrl);
  const qrEl = document.getElementById('qr') || (sheet ? sheet.querySelector('.att-a4-qr') : null);
  if (qrEl && typeof qrcode === 'function') {
    const qr = qrcode(0, 'M');
    qr.addData(url);
    qr.make();
    qrEl.innerHTML = qr.createSvgTag({cellSize: 4, margin: 0, scalable: true});
  }

  // Initial defaults resolved from server
  const serverDefaults = {
    font: @json($activeFont),
    fontSize: {{ $numFontSize }},
    lineHeight: {{ $numLineHeight }},
    spacing: @json($activeSpacing)
  };

  // UI Elements
  const ctrlFont = document.getElementById('ctrlFont');
  const rngFontSize = document.getElementById('rngFontSize');
  const valFontSize = document.getElementById('valFontSize');
  const btnFontMinus = document.getElementById('btnFontMinus');
  const btnFontPlus = document.getElementById('btnFontPlus');
  const rngLineHeight = document.getElementById('rngLineHeight');
  const valLineHeight = document.getElementById('valLineHeight');
  const btnLhMinus = document.getElementById('btnLhMinus');
  const btnLhPlus = document.getElementById('btnLhPlus');
  const ctrlSpacing = document.getElementById('ctrlSpacing');
  const btnAutoFit = document.getElementById('btnAutoFit');
  const btnReset = document.getElementById('btnReset');
  const statusBadge = document.getElementById('statusBadge');
  const statusText = document.getElementById('statusText');

  const spacingPresets = {
    compact: { section: '2.2mm', tdY: '3.5px', signSpace: '11mm' },
    normal: { section: '3.5mm', tdY: '5px', signSpace: '14mm' },
    spacious: { section: '5mm', tdY: '6.5px', signSpace: '16mm' }
  };

  function checkFit() {
    if (!sheetContent || !sheetFooter || !sheet) return true;
    const contentRect = sheetContent.getBoundingClientRect();
    const footerRect = sheetFooter.getBoundingClientRect();

    // Check if bottom of flowing content enters into the footer zone (with 6px safety gap)
    const isOverflowing = contentRect.bottom > (footerRect.top - 6);

    if (statusBadge && statusText) {
      if (isOverflowing) {
        statusBadge.className = 'status-indicator status-warn';
        statusText.textContent = '⚠️ লেখা স্বাক্ষরে ঢুকে গেছে! সাইজ কমান বা "এক পাতায় ফিট" চাপুন';
        sheet.classList.add('has-overflow');
      } else {
        statusBadge.className = 'status-indicator status-ok';
        statusText.textContent = '✓ ১ পাতায় সম্পূর্ণ ফিট (প্রিন্টের জন্য প্রস্তুত)';
        sheet.classList.remove('has-overflow');
      }
    }
    return !isOverflowing;
  }

  function applySettings(font, fs, lh, spacing) {
    if (!sheet) return;
    if (font) {
      const fontVal = font.includes('sans-serif') || font.includes('serif') ? font : `'${font}', 'Tiro Bangla', sans-serif`;
      sheet.style.setProperty('--font-family', fontVal);
      document.body.style.setProperty('--font-family', fontVal);
    }
    sheet.style.setProperty('--content-font-size', fs + 'px');
    sheet.style.setProperty('--content-line-height', lh);

    const sp = spacingPresets[spacing] || spacingPresets.normal;
    sheet.style.setProperty('--section-spacing', sp.section);
    sheet.style.setProperty('--table-padding-y', sp.tdY);
    sheet.style.setProperty('--sign-space', sp.signSpace);

    // Sync input controls
    if (ctrlFont) ctrlFont.value = font;
    if (rngFontSize) rngFontSize.value = fs;
    if (valFontSize) valFontSize.textContent = fs + 'px';
    if (rngLineHeight) rngLineHeight.value = lh;
    if (valLineHeight) valLineHeight.textContent = lh;
    if (ctrlSpacing) ctrlSpacing.value = spacing;

    checkFit();
  }

  function savePrefs() {
    const prefs = {
      font: ctrlFont ? ctrlFont.value : serverDefaults.font,
      fontSize: rngFontSize ? parseFloat(rngFontSize.value) : serverDefaults.fontSize,
      lineHeight: rngLineHeight ? parseFloat(rngLineHeight.value) : serverDefaults.lineHeight,
      spacing: ctrlSpacing ? ctrlSpacing.value : serverDefaults.spacing
    };
    try {
      localStorage.setItem(storageKey, JSON.stringify(prefs));
    } catch (e) {}
  }

  function loadPrefs() {
    // 1. URL search params take highest priority
    const urlParams = new URLSearchParams(window.location.search);
    let font = urlParams.get('font_family') || null;
    let fs = urlParams.get('font_size') ? parseFloat(urlParams.get('font_size')) : null;
    let lh = urlParams.get('line_height') ? parseFloat(urlParams.get('line_height')) : null;
    let spacing = urlParams.get('section_spacing') || null;

    // 2. Check localStorage if no URL query params
    if (!font && !fs && !lh && !spacing) {
      try {
        const saved = JSON.parse(localStorage.getItem(storageKey));
        if (saved) {
          font = saved.font || null;
          fs = saved.fontSize || null;
          lh = saved.lineHeight || null;
          spacing = saved.spacing || null;
        }
      } catch (e) {}
    }

    applySettings(
      font || serverDefaults.font,
      fs || serverDefaults.fontSize,
      lh || serverDefaults.lineHeight,
      spacing || serverDefaults.spacing
    );
  }

  function autoFit() {
    if (!rngFontSize || !rngLineHeight || !ctrlSpacing) return;
    let font = ctrlFont ? ctrlFont.value : serverDefaults.font;
    let fs = parseFloat(rngFontSize.value);
    let lh = parseFloat(rngLineHeight.value);
    let spacing = ctrlSpacing.value;

    if (checkFit()) return;

    // First try compact spacing
    if (spacing !== 'compact') {
      spacing = 'compact';
      applySettings(font, fs, lh, spacing);
      if (checkFit()) {
        savePrefs();
        return;
      }
    }

    // Iteratively step down line-height and font-size
    let safety = 0;
    while (!checkFit() && safety < 35) {
      if (lh > 1.40) {
        lh = Math.max(1.35, Math.round((lh - 0.05) * 100) / 100);
      }
      if (fs > 10.5) {
        fs = Math.max(10.5, Math.round((fs - 0.5) * 10) / 10);
      }
      applySettings(font, fs, lh, spacing);
      safety++;
    }

    savePrefs();
  }

  function resetPrefs() {
    try {
      localStorage.removeItem(storageKey);
    } catch (e) {}
    applySettings(
      serverDefaults.font,
      serverDefaults.fontSize,
      serverDefaults.lineHeight,
      serverDefaults.spacing
    );
  }

  // Event Listeners
  if (ctrlFont) {
    ctrlFont.addEventListener('change', function() {
      applySettings(this.value, parseFloat(rngFontSize.value), parseFloat(rngLineHeight.value), ctrlSpacing.value);
      savePrefs();
    });
  }

  if (rngFontSize) {
    rngFontSize.addEventListener('input', function() {
      valFontSize.textContent = this.value + 'px';
      if (sheet) sheet.style.setProperty('--content-font-size', this.value + 'px');
      checkFit();
      savePrefs();
    });
  }

  if (btnFontMinus) {
    btnFontMinus.addEventListener('click', function() {
      let val = Math.max(10, Math.round((parseFloat(rngFontSize.value) - 0.5) * 10) / 10);
      rngFontSize.value = val;
      valFontSize.textContent = val + 'px';
      if (sheet) sheet.style.setProperty('--content-font-size', val + 'px');
      checkFit();
      savePrefs();
    });
  }

  if (btnFontPlus) {
    btnFontPlus.addEventListener('click', function() {
      let val = Math.min(18, Math.round((parseFloat(rngFontSize.value) + 0.5) * 10) / 10);
      rngFontSize.value = val;
      valFontSize.textContent = val + 'px';
      if (sheet) sheet.style.setProperty('--content-font-size', val + 'px');
      checkFit();
      savePrefs();
    });
  }

  if (rngLineHeight) {
    rngLineHeight.addEventListener('input', function() {
      valLineHeight.textContent = this.value;
      if (sheet) sheet.style.setProperty('--content-line-height', this.value);
      checkFit();
      savePrefs();
    });
  }

  if (btnLhMinus) {
    btnLhMinus.addEventListener('click', function() {
      let val = Math.max(1.2, Math.round((parseFloat(rngLineHeight.value) - 0.05) * 100) / 100);
      rngLineHeight.value = val;
      valLineHeight.textContent = val;
      if (sheet) sheet.style.setProperty('--content-line-height', val);
      checkFit();
      savePrefs();
    });
  }

  if (btnLhPlus) {
    btnLhPlus.addEventListener('click', function() {
      let val = Math.min(2.3, Math.round((parseFloat(rngLineHeight.value) + 0.05) * 100) / 100);
      rngLineHeight.value = val;
      valLineHeight.textContent = val;
      if (sheet) sheet.style.setProperty('--content-line-height', val);
      checkFit();
      savePrefs();
    });
  }

  if (ctrlSpacing) {
    ctrlSpacing.addEventListener('change', function() {
      const sp = spacingPresets[this.value] || spacingPresets.normal;
      if (sheet) {
        sheet.style.setProperty('--section-spacing', sp.section);
        sheet.style.setProperty('--table-padding-y', sp.tdY);
        sheet.style.setProperty('--sign-space', sp.signSpace);
      }
      checkFit();
      savePrefs();
    });
  }

  if (btnAutoFit) {
    btnAutoFit.addEventListener('click', autoFit);
  }

  if (btnReset) {
    btnReset.addEventListener('click', resetPrefs);
  }

  // Initialize and run initial check
  window.addEventListener('DOMContentLoaded', function() {
    loadPrefs();
    setTimeout(checkFit, 200);
  });
  window.addEventListener('load', function() {
    setTimeout(checkFit, 300);
  });
  window.addEventListener('resize', checkFit);

  // Direct print editor toggle & export
  let isPrintEditable = false;
  window.togglePrintEdit = function() {
    if (!sheet) return;
    isPrintEditable = !isPrintEditable;
    const btn = document.getElementById('directEditBtn');
    if (btn) {
      btn.classList.toggle('active-edit', isPrintEditable);
      btn.textContent = isPrintEditable ? '✔ সরাসরি এডিট বন্ধ করুন' : '✎ সরাসরি এডিট';
    }
    if (isPrintEditable) {
      sheet.setAttribute('contenteditable', 'true');
      sheet.setAttribute('spellcheck', 'false');
      sheet.focus();
    } else {
      sheet.removeAttribute('contenteditable');
    }
  };

  window.exportDocFile = function() {
    if (!sheet) return;
    const clone = sheet.cloneNode(true);
    clone.removeAttribute('contenteditable');
    const html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"><title>{{ $certificate->memo_no }}</title></head><body style="font-family:\'Tiro Bangla\',serif;font-size:12pt;">' + clone.innerHTML + '</body></html>';
    const blob = new Blob(['\ufeff' + html], { type: 'application/msword;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = @json(($snapshot['type_name'] ?? 'Certificate') . ' - ' . $certificate->subject_name . '.doc');
    a.click();
  };
})();
</script>
</body>
</html>