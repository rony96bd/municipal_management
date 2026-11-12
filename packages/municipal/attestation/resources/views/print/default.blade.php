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
@endphp
<!DOCTYPE html>
<html lang="{{ $isEnglish ? 'en' : 'bn' }}">
<head>
<meta charset="utf-8">
<title>{{ $certificate->memo_no }} — {{ $snapshot['type_name'] ?? 'প্রত্যয়ন পত্র' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --brand:#0f6b3a; --brand-2:#14a05a; --ink:#1b2430; --muted:#5d6b7a; --line:#d9e2dc; --paper:#fff;
    --pad-top:{{ $padTop }}in;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:{{ $isEnglish ? "'Times New Roman','Noto Sans Bengali',serif" : "'Noto Sans Bengali',sans-serif" }};color:var(--ink);background:#e9eeeb;padding:24px;
       -webkit-print-color-adjust:exact;print-color-adjust:exact}
  .toolbar{max-width:210mm;margin:0 auto 14px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;font-family:'Noto Sans Bengali',sans-serif}
  .toolbar .btn-group{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
  .toolbar a,.toolbar button{font:600 13px 'Noto Sans Bengali';padding:8px 14px;border:0;border-radius:8px;background:var(--brand);color:#fff;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px}
  .toolbar a.alt,.toolbar button.alt{background:#fff;color:var(--ink);border:1px solid #cbd5e1}
  .toolbar button.active-edit{background:#1d4ed8;color:#fff;border-color:#1d4ed8}

  .pad-preset-btn{background:#f8fafc;border:1px solid #cbd5e1;border-radius:4px;padding:3px 6px;font-size:11.5px;color:#334155;cursor:pointer}
  .pad-preset-btn:hover{background:#0f6b3a;color:#fff;border-color:#0f6b3a}

  .sheet{position:relative;width:210mm;min-height:297mm;margin:0 auto;background:var(--paper);
         padding:14mm 16mm 46mm;box-shadow:0 10px 40px rgba(0,0,0,.15);overflow:hidden}
  .sheet.pad-mode{padding-top:0 !important}
  .sheet[contenteditable="true"]{outline:3px dashed #2563eb;outline-offset:-4px;background:#fffef7}
  @if ($withHeader)
  /* frame */
  .sheet::before{content:"";position:absolute;inset:6mm;border:1.2px solid var(--brand);border-radius:6px;pointer-events:none}
  .sheet::after{content:"";position:absolute;inset:7.6mm;border:.5px solid var(--brand-2);border-radius:4px;pointer-events:none;opacity:.6}
  .topbar{position:absolute;top:6mm;left:6mm;right:6mm;height:3mm;border-radius:6px 6px 0 0;
          background:linear-gradient(90deg,var(--brand),var(--brand-2))}
  @endif
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

  .pad-spacer{
    position:relative;
    width:100%;
    height:var(--pad-top, 1.5in);
    border-bottom:1.5px dashed #cbd5e1;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#94a3b8;
    font-size:12px;
    margin-bottom:4mm;
    user-select:none;
  }

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
  .verify{display:flex;flex-direction:column;align-items:flex-start;gap:3px;flex:0 0 auto;width:30mm}
  .qr{flex:0 0 auto;padding:4px;border:1px solid var(--line);border-radius:10px;background:#fff;line-height:0}
  .qr svg,.qr img{width:22mm;height:22mm;display:block}
  .verify .txt{font-size:8.5px;color:var(--muted);line-height:1.35;max-width:30mm}
  .verify .txt b{display:block;color:var(--ink);font-size:9.5px}
  .verify .code{font-family:monospace;font-size:8.5px;white-space:nowrap;color:var(--brand);letter-spacing:.8px}

  .signs{display:flex;align-items:flex-end;justify-content:flex-end;gap:4mm;flex:1 1 auto;min-width:0}
  .sign{text-align:center;flex:1 1 0;min-width:0;max-width:62mm;font-size:11.5px}
  .sign .space{height:14mm}
  .sign .line{border-top:1px solid var(--ink);padding-top:4px;font-weight:600}
  .sign small{display:block;color:var(--muted);font-weight:400;line-height:1.35}
  .bottomnote{position:absolute;left:0;right:0;bottom:8.4mm;text-align:center;font-size:9.5px;color:var(--muted)}

  @page{size:A4;margin:0}
  @media print{
    body{background:none;padding:0}
    .toolbar{display:none}
    .sheet{box-shadow:none;margin:0;outline:none !important;background:#fff !important}
    .pad-spacer{border-bottom:none !important;margin-bottom:0 !important}
    .pad-spacer *{display:none !important}
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

    @unless ($withHeader)
      <div style="display:inline-flex;align-items:center;gap:6px;background:#fff;border:1px solid #cbd5e1;border-radius:8px;padding:4px 9px;font:600 13px 'Noto Sans Bengali';color:#1b2430">
        <span style="color:#0f6b3a;">⬍ প্যাড মার্জিন:</span>
        <button type="button" onclick="stepPad(-0.1)" title="০.১ ইঞ্চি কমান" style="background:#f1f5f9;border:1px solid #cbd5e1;border-radius:4px;padding:2px 7px;font-weight:700;cursor:pointer;color:#0f6b3a;">−</button>
        <input type="number" id="padTopInput" min="0" max="6" step="0.1" value="{{ $padTop }}" style="width:58px;padding:3px 5px;border:1px solid #cbd5e1;border-radius:5px;text-align:center;font-weight:700;">
        <span style="font-size:12px;color:#64748b;">ইঞ্চি</span>
        <button type="button" onclick="stepPad(0.1)" title="০.১ ইঞ্চি বাড়ান" style="background:#f1f5f9;border:1px solid #cbd5e1;border-radius:4px;padding:2px 7px;font-weight:700;cursor:pointer;color:#0f6b3a;">+</button>
        <div style="display:inline-flex;gap:4px;margin-left:4px;">
          <button type="button" onclick="setPadVal(1.0)" class="pad-preset-btn">1.0″</button>
          <button type="button" onclick="setPadVal(1.5)" class="pad-preset-btn">1.5″</button>
          <button type="button" onclick="setPadVal(1.8)" class="pad-preset-btn">1.8″</button>
          <button type="button" onclick="setPadVal(2.0)" class="pad-preset-btn">2.0″</button>
        </div>
      </div>
    @endunless

    <button type="button" class="alt" id="directEditBtn" onclick="togglePrintEdit()">✎ সরাসরি এডিট</button>
    <button type="button" class="alt" onclick="exportDocFile()">📄 Word (.doc)</button>
  </div>
  <button onclick="window.print()">🖨 প্রিন্ট করুন (A4)</button>
</div>

<div class="sheet {{ !$withHeader ? 'pad-mode' : '' }}" id="sheet">
  @if (!empty($snapshot['override_html']))
    {!! $snapshot['override_html'] !!}
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
          <b>{{ $isEnglish ? 'Verify Online' : 'অনলাইনে যাচাই করুন' }}</b>
          {{ $isEnglish ? 'Scan QR code to verify authenticity of this certificate.' : 'QR কোড স্ক্যান করে প্রত্যয়নের সত্যতা যাচাই করা যাবে।' }}
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
  const logo = @json($logo);
  const sheetEl = document.getElementById('sheet');
  sheetEl.style.setProperty('--logo', `url('${logo}')`);

  // Pad Top Controller
  (function () {
    const inp = document.getElementById('padTopInput');
    const guideVal = document.getElementById('padGuideVal');
    const key = 'attestation_pad_top';
    const urlHas = new URLSearchParams(location.search).has('pad');
    const saved = localStorage.getItem(key);

    if (inp) {
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
        sheetEl.style.setProperty('--pad-top', v + 'in');
        if (guideVal) guideVal.textContent = v;
        localStorage.setItem(key, v);
      }

      inp.addEventListener('input', applyPad);
      applyPad();
    }
  })();

  const url = @json($verifyUrl);
  const qrEl = document.getElementById('qr') || sheetEl.querySelector('.att-a4-qr');
  if (qrEl && typeof qrcode === 'function') {
    const qr = qrcode(0, 'M');
    qr.addData(url);
    qr.make();
    qrEl.innerHTML = qr.createSvgTag({cellSize: 4, margin: 0, scalable: true});
  }

  let isPrintEditable = false;
  function togglePrintEdit() {
    isPrintEditable = !isPrintEditable;
    const btn = document.getElementById('directEditBtn');
    btn.classList.toggle('active-edit', isPrintEditable);
    btn.textContent = isPrintEditable ? '✔ সরাসরি এডিট বন্ধ করুন' : '✎ সরাসরি এডিট';
    if (isPrintEditable) {
      sheetEl.setAttribute('contenteditable', 'true');
      sheetEl.setAttribute('spellcheck', 'false');
      sheetEl.focus();
    } else {
      sheetEl.removeAttribute('contenteditable');
    }
  }

  function exportDocFile() {
    const clone = sheetEl.cloneNode(true);
    clone.removeAttribute('contenteditable');
    const html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"><title>{{ $certificate->memo_no }}</title></head><body style="font-family:\'Noto Sans Bengali\',sans-serif;font-size:12pt;">' + clone.innerHTML + '</body></html>';
    const blob = new Blob(['\ufeff' + html], { type: 'application/msword;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = @json(($snapshot['type_name'] ?? 'Certificate') . ' - ' . $certificate->subject_name . '.doc');
    a.click();
  }
</script>
</body>
</html>
