@php
    $org = $snapshot['organization'] ?? config('attestation.organization', []);
    $issueDateBn = \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($certificate->issue_date ? $certificate->issue_date->format('d/m/Y') : now()->format('d/m/Y'));
    $verifyUrl = route('attestation.verify.show', $certificate->verification_code);
    $signatories = $snapshot['signatories'] ?? [];
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="utf-8">
<title>{{ $certificate->memo_no }} — {{ $snapshot['type_name'] ?? 'প্রত্যয়ন পত্র' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --brand:#0f6b3a; --brand-2:#14a05a; --ink:#1b2430; --muted:#5d6b7a; --line:#d9e2dc; --paper:#fff;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Noto Sans Bengali',sans-serif;color:var(--ink);background:#e9eeeb;padding:24px;
       -webkit-print-color-adjust:exact;print-color-adjust:exact}
  .toolbar{max-width:210mm;margin:0 auto 14px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px}
  .toolbar .btn-group{display:flex;gap:8px;flex-wrap:wrap}
  .toolbar a,.toolbar button{font:600 13.5px 'Noto Sans Bengali';padding:8px 16px;border:0;border-radius:8px;background:var(--brand);color:#fff;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px}
  .toolbar a.alt{background:#fff;color:var(--ink);border:1px solid #cbd5e1}

  .sheet{position:relative;width:210mm;min-height:297mm;margin:0 auto;background:var(--paper);
         padding:14mm 16mm 46mm;box-shadow:0 10px 40px rgba(0,0,0,.15);overflow:hidden}
  /* frame */
  .sheet::before{content:"";position:absolute;inset:6mm;border:1.2px solid var(--brand);border-radius:6px;pointer-events:none}
  .sheet::after{content:"";position:absolute;inset:7.6mm;border:.5px solid var(--brand-2);border-radius:4px;pointer-events:none;opacity:.6}
  .topbar{position:absolute;top:6mm;left:6mm;right:6mm;height:3mm;border-radius:6px 6px 0 0;
          background:linear-gradient(90deg,var(--brand),var(--brand-2))}
  .watermark{position:absolute;left:50%;top:52%;width:120mm;height:120mm;transform:translate(-50%,-50%);
             background:var(--logo) center/contain no-repeat;opacity:.07;filter:grayscale(1);mix-blend-mode:multiply;pointer-events:none}

  header{position:relative;display:flex;align-items:center;gap:14px;padding:4mm 0 4mm;border-bottom:1px solid var(--line)}
  header .logo{width:22mm;height:22mm;object-fit:contain}
  header .titles{flex:1;text-align:center}
  .bismillah{font-size:11px;color:var(--muted);margin-bottom:2px}
  .gov{font-size:11.5px;color:var(--muted);letter-spacing:.3px}
  .org{font-size:25px;font-weight:700;color:var(--brand);line-height:1.25}
  .sub{font-size:12px;color:var(--muted)}
  header .spacer{width:22mm}
  .pad-spacer{height:28mm;border-bottom:1px dashed var(--line)}

  .meta{position:relative;display:flex;justify-content:space-between;margin-top:4.5mm;font-size:13.5px}
  .meta b{color:var(--brand);font-weight:600}

  .title{position:relative;text-align:center;margin:6mm 0 5mm}
  .title span{display:inline-block;padding:6px 32px;border-radius:999px;font-size:19px;font-weight:700;color:#fff;
              background:linear-gradient(90deg,var(--brand),var(--brand-2));letter-spacing:.3px}

  .lead{position:relative;font-size:14.5px;line-height:1.9;margin-bottom:3mm}
  .details{position:relative;width:100%;border-collapse:collapse;margin-bottom:4.5mm;font-size:14.5px}
  .details td{padding:5.5px 8px;border-bottom:1px dashed var(--line);vertical-align:top}
  .details td:first-child{width:36%;color:var(--muted)}
  .details td:nth-child(2){width:14px;color:var(--muted)}
  .details td:last-child{font-weight:600}

  .body{position:relative;font-size:14.5px;line-height:1.95;text-align:justify;margin-bottom:4mm}
  .rep-wrap{position:relative;margin:4mm 0}
  .rep-title{font-size:14px;font-weight:700;color:var(--brand);margin-bottom:4px}
  .rep-table{width:100%;border-collapse:collapse;font-size:12.5px}
  .rep-table th,.rep-table td{border:1px solid #cbd5e1;padding:5px 7px;text-align:left}
  .rep-table th{background:#f1f5f9;font-weight:700;color:var(--ink)}

  .wish{position:relative;margin-top:4mm;font-size:14.5px}

  .guardians{position:relative;display:flex;justify-content:space-around;gap:12mm;margin-top:10mm;padding-top:4mm}
  .guardian-box{text-align:center;min-width:52mm;font-size:12.5px}
  .guardian-box .line{border-top:1px dashed var(--ink);padding-top:4px;font-weight:600}

  .footer{position:absolute;left:16mm;right:16mm;bottom:13mm;display:flex;align-items:flex-end;justify-content:space-between;gap:6mm}
  .verify{display:flex;align-items:center;gap:9px}
  .qr{padding:5px;border:1px solid var(--line);border-radius:10px;background:#fff;line-height:0}
  .qr svg,.qr img{width:23mm;height:23mm}
  .verify .txt{font-size:10px;color:var(--muted);line-height:1.55;max-width:48mm}
  .verify .txt b{display:block;color:var(--ink);font-size:11px}
  .verify .code{font-family:monospace;font-size:10.5px;color:var(--brand);letter-spacing:.8px}

  .signs{display:flex;align-items:flex-end;justify-content:flex-end;gap:6mm;flex:1}
  .sign{text-align:center;min-width:44mm;max-width:62mm;font-size:12.5px}
  .sign .space{height:14mm}
  .sign .line{border-top:1px solid var(--ink);padding-top:4px;font-weight:600}
  .sign small{display:block;color:var(--muted);font-weight:400;line-height:1.35}
  .bottomnote{position:absolute;left:0;right:0;bottom:8.4mm;text-align:center;font-size:9.5px;color:var(--muted)}

  @page{size:A4;margin:0}
  @media print{
    body{background:none;padding:0}
    .toolbar{display:none}
    .sheet{box-shadow:none;margin:0}
  }
</style>
</head>
<body>
<div class="toolbar">
  <div class="btn-group">
    <a href="{{ route('attestation.certificates.show', $certificate) }}" class="alt">← বিস্তারিত পেজে ফিরুন</a>
    <a href="{{ route('attestation.certificates.print', [$certificate, 'with_header' => $withHeader ? 0 : 1, 'watermark' => $withWatermark ? 1 : 0]) }}" class="alt">
      {{ $withHeader ? '📄 প্যাড মোড (হেডার ছাড়া)' : '🏛️ লেটারহেড মোড (হেডার সহ)' }}
    </a>
    <a href="{{ route('attestation.certificates.print', [$certificate, 'with_header' => $withHeader ? 1 : 0, 'watermark' => $withWatermark ? 0 : 1]) }}" class="alt">
      {{ $withWatermark ? '💧 জলছাপ বন্ধ করুন' : '💧 জলছাপ চালু করুন' }}
    </a>
  </div>
  <button onclick="window.print()">🖨 প্রিন্ট করুন (A4)</button>
</div>

<div class="sheet" id="sheet">
  <div class="topbar"></div>
  @if ($withWatermark)
    <div class="watermark"></div>
  @endif

  @if ($withHeader)
    <header>
      <img class="logo" id="logoImg" src="{{ $logo }}" alt="logo">
      <div class="titles">
        @if (!empty($org['bismillah']))
          <div class="bismillah">{{ $org['bismillah'] }}</div>
        @endif
        <div class="gov">{{ $org['gov_line'] ?? 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকার' }}</div>
        <div class="org">{{ $org['name'] ?? 'আলমডাঙ্গা পৌরসভা' }}</div>
        <div class="sub">{{ $org['address'] ?? ($org['sub_title'] ?? 'আলমডাঙ্গা, চুয়াডাঙ্গা') }}</div>
        @if (!empty($org['mobile']) || !empty($org['email']))
          <div class="sub">মোবাইল: {{ $org['mobile'] ?? '' }} {{ !empty($org['email']) ? '| ই-মেইল: ' . $org['email'] : '' }}</div>
        @endif
      </div>
      <div class="spacer"></div>
    </header>
  @else
    <div class="pad-spacer"></div>
  @endif

  <div class="meta">
    <div><b>স্মারক নং:</b> {{ $certificate->memo_no }}</div>
    <div><b>তারিখ:</b> {{ $issueDateBn }}</div>
  </div>

  <div class="title"><span>{{ $snapshot['type_name'] ?? $certificate->type?->name }}</span></div>

  <p class="lead">{{ $snapshot['lead_line'] ?? 'এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে,' }}</p>

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
    <p class="body">{!! $snapshot['rendered_body'] !!}</p>
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

  <div class="footer">
    <div class="verify">
      <div class="qr" id="qr"></div>
      <div class="txt">
        <b>অনলাইনে যাচাই করুন</b>
        QR কোড স্ক্যান করে প্রত্যয়নের সত্যতা যাচাই করা যাবে।
        <div class="code">কোড: {{ $certificate->verification_code }}</div>
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

  <div class="bottomnote">এটি কম্পিউটার-নির্মিত প্রত্যয়ন; কর্তৃপক্ষের স্বাক্ষর ও সিল ব্যতীত বৈধ নয়।</div>
</div>

<script src="{{ asset('vendor/attestation/qrcode.js') }}"></script>
<script>
  const logo = @json($logo);
  document.getElementById('sheet').style.setProperty('--logo', `url('${logo}')`);

  const url = @json($verifyUrl);
  if (typeof qrcode === 'function') {
    const qr = qrcode(0, 'M');
    qr.addData(url);
    qr.make();
    document.getElementById('qr').innerHTML = qr.createSvgTag({cellSize: 4, margin: 0, scalable: true});
  }
</script>
</body>
</html>
