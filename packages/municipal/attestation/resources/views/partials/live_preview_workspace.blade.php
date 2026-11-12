@php
    $org         = config('attestation.organization', []);
    $logoUrl     = \Municipal\Attestation\Support\LogoHelper::url();
    $isEnglish   = ($type->language ?? 'bn') === 'en';
    $isDeceased  = ($type->subject_status === 'deceased');
    $withHeader  = (bool) ($type->print_options['with_header'] ?? true);
    $presetMap   = \Municipal\Attestation\Models\AttestationSignatory::whereNotNull('preset_key')->get()->keyBy('preset_key');
    $idMap       = \Municipal\Attestation\Models\AttestationSignatory::all()->keyBy('id');

    $defaultSigs = [];
    foreach ($type->signatories ?? [] as $slot) {
        $sigModel = !empty($slot['signatory_id'])
            ? ($idMap[$slot['signatory_id']] ?? null)
            : (!empty($slot['preset_key']) ? ($presetMap[$slot['preset_key']] ?? null) : null);
        $defaultSigs[] = [
            'label'       => $slot['label'] ?? '',
            'name'        => $sigModel?->name ?? ($slot['name'] ?? ''),
            'designation' => $sigModel?->designation ?? ($slot['designation'] ?? ($isEnglish ? 'Pouro Nirbahi Officer' : 'পৌর নির্বাহী কর্মকর্তা')),
            'office_line' => $sigModel?->office_line ?? ($isEnglish ? 'Alamdanga Pourashava' : ($org['name'] ?? 'আলমডাঙ্গা পৌরসভা')),
            'extra_line'  => $sigModel?->extra_line ?? ($isEnglish ? 'Alamdanga, Chuadanga' : ($org['sub_title'] ?? 'আলমডাঙ্গা, চুয়াডাঙ্গা')),
        ];
    }
    if (empty($defaultSigs)) {
        $def = $presetMap->get($isEnglish ? 'EN_A' : 'A');
        $defaultSigs[] = [
            'label'       => '',
            'name'        => $def?->name ?? '',
            'designation' => $def?->designation ?? ($isEnglish ? 'Pouro Nirbahi Officer' : 'পৌর নির্বাহী কর্মকর্তা'),
            'office_line' => $def?->office_line ?? ($isEnglish ? 'Alamdanga Pourashava' : ($org['name'] ?? 'আলমডাঙ্গা পৌরসভা')),
            'extra_line'  => $def?->extra_line ?? ($isEnglish ? 'Alamdanga, Chuadanga' : ($org['sub_title'] ?? 'আলমডাঙ্গা, চুয়াডাঙ্গা')),
        ];
    }

    $previewConfig = [
        'type_name'           => $type->name,
        'memo_name'           => $type->memo_name,
        'language'            => $isEnglish ? 'en' : 'bn',
        'is_deceased'         => $isDeceased,
        'holder_label'        => $org['holder_label'] ?? 'পৌর',
        'person_fields'       => $type->person_fields ?: ['applicant_name', 'id_no', 'father_name', 'mother_name', 'ward_no', 'holding_no', 'mohalla', 'upazila'],
        'fields'              => $type->fields ?? [],
        'body_template'       => (string) $type->body_template,
        'closing_line'        => (string) ($type->closing_line ?: ($isEnglish ? 'I wish him/her every success and prosperity in life.' : ($isDeceased ? 'আমি তাঁর আত্মার মাগফিরাত কামনা করি।' : 'আমি তাঁর সার্বিক মঙ্গল কামনা করি।'))),
        'lead_line'           => $isEnglish ? 'This is to certify that,' : ($isDeceased ? 'এই মর্মে প্রত্যয়ন পত্র প্রদান করা যাচ্ছে যে,' : 'এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে,'),
        'signatories'         => $defaultSigs,
        'guardian_signatures' => !empty($type->print_options['guardian_signatures']) || $type->slug === 'obhibhabak-sommoti',
        'with_header'         => $withHeader,
        'org'                 => $org,
        'logo'                => $logoUrl,
    ];
@endphp

<style>
    .att-live-split {
        display: grid;
        grid-template-columns: minmax(380px, 460px) 1fr;
        gap: 18px;
        align-items: start;
    }
    @media (max-width: 1100px) {
        .att-live-split {
            grid-template-columns: 1fr;
        }
    }
    .att-live-form-col {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 16px;
        max-height: calc(100vh - 90px);
        overflow-y: auto;
        position: sticky;
        top: 14px;
    }
    @media (max-width: 1100px) {
        .att-live-form-col {
            max-height: none;
            position: static;
        }
    }
    .att-live-preview-col {
        background: #dde3ea;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 720px;
    }
    .att-preview-toolbar {
        width: 100%;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 9px 12px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .att-preview-toolbar .t-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f6b3a;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .att-preview-toolbar .t-btns {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .att-preview-btn {
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #1e293b;
        padding: 5px 11px;
        border-radius: 6px;
        font: 600 12.5px 'Noto Sans Bengali', sans-serif;
        cursor: pointer;
        transition: all .15s;
    }
    .att-preview-btn.active {
        background: #1d4ed8;
        color: #ffffff;
        border-color: #1d4ed8;
    }
    .att-preview-btn.green {
        background: #0f6b3a;
        color: #ffffff;
        border-color: #0f6b3a;
    }

    /* Live A4 Sheet inside Preview */
    .att-a4-scaler {
        width: 100%;
        display: flex;
        justify-content: center;
        overflow-x: auto;
    }
    .att-a4-sheet {
        position: relative;
        width: 210mm;
        min-height: 297mm;
        background: #ffffff;
        padding: 14mm 16mm 44mm;
        box-shadow: 0 8px 30px rgba(0,0,0,.18);
        color: #1b2430;
        font-family: 'Noto Sans Bengali', sans-serif;
        overflow: hidden;
        transform-origin: top center;
    }
    .att-a4-sheet.en-font {
        font-family: 'Times New Roman', 'Noto Sans Bengali', serif;
    }
    .att-a4-sheet[contenteditable="true"] {
        outline: 3px dashed #2563eb;
        outline-offset: -4px;
        background: #fffef7;
        cursor: text;
    }
    .att-a4-sheet.with-frame::before {
        content: "";
        position: absolute;
        inset: 6mm;
        border: 1.2px solid #0f6b3a;
        border-radius: 6px;
        pointer-events: none;
    }
    .att-a4-sheet.with-frame::after {
        content: "";
        position: absolute;
        inset: 7.6mm;
        border: .5px solid #14a05a;
        border-radius: 4px;
        pointer-events: none;
        opacity: .6;
    }
    .att-a4-topbar {
        position: absolute;
        top: 6mm;
        left: 6mm;
        right: 6mm;
        height: 3mm;
        border-radius: 6px 6px 0 0;
        background: linear-gradient(90deg, #0f6b3a, #14a05a);
    }
    .att-a4-watermark {
        position: absolute;
        left: 50%;
        top: 52%;
        width: 115mm;
        height: 115mm;
        transform: translate(-50%, -50%);
        background: url('{{ $logoUrl }}') center/contain no-repeat;
        opacity: .07;
        filter: grayscale(1);
        pointer-events: none;
    }
    .att-a4-header {
        position: relative;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 3mm 0 4mm;
        border-bottom: 1px solid #d9e2dc;
    }
    .att-a4-header img {
        width: 21mm;
        height: 21mm;
        object-fit: contain;
    }
    .att-a4-header .h-titles {
        flex: 1;
        text-align: center;
    }
    .att-a4-header .h-bismillah { font-size: 11px; color: #5d6b7a; }
    .att-a4-header .h-gov { font-size: 11.5px; color: #5d6b7a; }
    .att-a4-header .h-org { font-size: 24px; font-weight: 700; color: #0f6b3a; line-height: 1.25; }
    .att-a4-header .h-sub { font-size: 12px; color: #5d6b7a; }
    .att-a4-pad-spacer {
        height: 2.5in;
        border-bottom: 1px dashed #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 12px;
    }
    .att-a4-meta {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin-top: 4mm;
        font-size: 13.5px;
    }
    .att-a4-meta b { color: #0f6b3a; }
    .att-a4-title {
        position: relative;
        text-align: center;
        margin: 5.5mm 0 4.5mm;
    }
    .att-a4-title span {
        display: inline-block;
        padding: 5px 28px;
        border-radius: 999px;
        font-size: 18px;
        font-weight: 700;
        color: #ffffff;
        background: linear-gradient(90deg, #0f6b3a, #14a05a);
    }
    .att-a4-lead {
        position: relative;
        font-size: 14px;
        line-height: 1.85;
        margin-bottom: 2.5mm;
    }
    .att-a4-details {
        position: relative;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4mm;
        font-size: 14px;
    }
    .att-a4-details td {
        padding: 5px 7px;
        border-bottom: 1px dashed #d9e2dc;
        vertical-align: top;
    }
    .att-a4-details td:first-child { width: 36%; color: #5d6b7a; }
    .att-a4-details td:nth-child(2) { width: 12px; color: #5d6b7a; }
    .att-a4-details td:last-child { font-weight: 600; color: #1b2430; }
    .att-a4-body {
        position: relative;
        font-size: 14px;
        line-height: 1.9;
        text-align: justify;
        margin-bottom: 3.5mm;
    }
    .att-a4-rep-wrap { position: relative; margin: 3.5mm 0; }
    .att-a4-rep-title { font-size: 13.5px; font-weight: 700; color: #0f6b3a; margin-bottom: 3px; }
    .att-a4-rep-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .att-a4-rep-table th, .att-a4-rep-table td { border: 1px solid #cbd5e1; padding: 4px 6px; text-align: left; }
    .att-a4-rep-table th { background: #f1f5f9; font-weight: 700; }
    .att-a4-wish { position: relative; margin-top: 3.5mm; font-size: 14px; }
    .att-a4-footer {
        position: absolute;
        left: 16mm;
        right: 16mm;
        bottom: 13mm;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 5mm;
    }
    .att-a4-qrbox {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .att-a4-qr {
        width: 21mm;
        height: 21mm;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #0f6b3a;
        background: #f8fafc;
        text-align: center;
        padding: 3px;
    }
    .att-a4-signs {
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
        gap: 5mm;
        flex: 1;
    }
    .att-a4-sign {
        text-align: center;
        min-width: 40mm;
        max-width: 58mm;
        font-size: 12px;
    }
    .att-a4-sign .s-space { height: 12mm; }
    .att-a4-sign .s-line { border-top: 1px solid #1b2430; padding-top: 3px; font-weight: 600; }
    .att-a4-sign small { display: block; color: #5d6b7a; font-weight: 400; line-height: 1.3; }
    .att-a4-bottomnote {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 8mm;
        text-align: center;
        font-size: 9.5px;
        color: #5d6b7a;
    }
</style>

<div class="att-live-preview-col" id="livePreviewCol">
    <div class="att-preview-toolbar">
        <div class="t-title">
            <span>👁️ লাইভ A4 সনদ প্রিভিউ</span>
            <span id="directEditBadge" style="display:none;background:#dbeafe;color:#1e40af;padding:2px 8px;border-radius:999px;font-size:11.5px;">
                সরাসরি সম্পাদিত
            </span>
        </div>
        <div class="t-btns">
            <button type="button" class="att-preview-btn" id="togglePadModeBtn">
                {{ $withHeader ? '📄 প্যাড মোড দেখুন' : '🏛️ লেটারহেড মোড দেখুন' }}
            </button>
            <button type="button" class="att-preview-btn" id="toggleDirectEditBtn">
                ✎ সরাসরি এডিট
            </button>
            <button type="button" class="att-preview-btn" id="resetDirectEditBtn" style="display:none;color:#dc2626;border-color:#fca5a5;">
                ↻ ফর্ম থেকে পুনরায় তৈরি
            </button>
        </div>
    </div>

    <div class="att-a4-scaler" id="a4ScalerWrap">
        <div class="att-a4-sheet {{ $withHeader ? 'with-frame' : '' }} {{ $isEnglish ? 'en-font' : '' }}" id="liveA4Sheet">
            <!-- Populated dynamically by JS -->
        </div>
    </div>
</div>

<script>
    (function () {
        const CFG = @json($previewConfig);
        const sheet = document.getElementById('liveA4Sheet');
        const scalerWrap = document.getElementById('a4ScalerWrap');
        const previewCol = document.getElementById('livePreviewCol');
        const overrideInput = document.getElementById('override_html_input');
        const togglePadBtn = document.getElementById('togglePadModeBtn');
        const toggleEditBtn = document.getElementById('toggleDirectEditBtn');
        const resetEditBtn = document.getElementById('resetDirectEditBtn');
        const directEditBadge = document.getElementById('directEditBadge');

        let showHeader = !!CFG.with_header;
        let isDirectEdit = false;

        const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        const toBn = s => String(s ?? '').replace(/\d/g, d => bnDigits[d]);
        const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));

        function getFormEl() {
            return document.getElementById('attLiveForm') || document.querySelector('form[action*="certificates"], form[action*="applications"]');
        }

        function readFormVal(name) {
            const form = getFormEl();
            if (!form) return '';
            const el = form.querySelector(`[name="${CSS.escape(name)}"]`);
            return el ? (el.value || '').trim() : '';
        }

        function renderTemplateStr(tpl, dataMap) {
            let out = String(tpl || '');
            out = out.replace(/\{\{(\w+)\}\}/g, (_, k) => {
                const v = dataMap[k];
                return v !== undefined && v !== '' ? esc(v) : '..........';
            });
            out = out.replace(/\*\*(.+?)\*\*/gs, '<strong>$1</strong>');
            return out;
        }

        function buildSheetHtml() {
            const isEn = CFG.language === 'en';
            const numFmt = v => v ? (isEn ? v : toBn(v)) : '-';

            const applicantName = readFormVal('applicant_name') || (isEn ? '....................' : '....................');
            const idType = readFormVal('id_type') || 'nid';
            const idNo = readFormVal('id_no');
            const fatherName = readFormVal('father_name') || '-';
            const motherName = readFormVal('mother_name') || '-';
            const spouseName = readFormVal('spouse_name') || '';
            const wardNo = readFormVal('ward_no');
            const holdingNo = readFormVal('holding_no');
            const mohalla = readFormVal('mohalla') || '-';
            const upazila = readFormVal('upazila') || (isEn ? 'Alamdanga' : (CFG.org.default_upazila || 'আলমডাঙ্গা'));
            const district = readFormVal('district') || (isEn ? 'Chuadanga' : (CFG.org.default_district || 'চুয়াডাঙ্গা'));
            const issueDateRaw = readFormVal('issue_date') || new Date().toISOString().slice(0, 10);
            const [yy, mm, dd] = issueDateRaw.split('-');
            const formattedDate = dd && mm && yy ? (isEn ? `${dd}/${mm}/${yy}` : toBn(`${dd}/${mm}/${yy}`)) : '';

            const dataMap = {
                applicant_name: applicantName,
                name: applicantName,
                id_no: numFmt(idNo),
                nid: numFmt(idNo),
                father_name: fatherName,
                mother_name: motherName,
                spouse_name: spouseName || '-',
                ward_no: numFmt(wardNo),
                holding_no: numFmt(holdingNo),
                mohalla: mohalla,
                upazila: upazila,
                district: district,
            };

            (CFG.fields || []).forEach(f => {
                if (f.type !== 'repeater') {
                    let v = readFormVal(`data[${f.key}]`);
                    if (f.type === 'bn_number' && v && !isEn) {
                        v = toBn(v);
                    }
                    dataMap[f.key] = v;
                    if (f.type === 'amount_with_words') {
                        dataMap[f.key + '_words'] = readFormVal(`data[${f.key}_words]`) || '...';
                    }
                }
            });

            // Header HTML
            let headerHtml = '';
            if (showHeader) {
                if (isEn) {
                    headerHtml = `
                        <div class="att-a4-topbar"></div>
                        <div class="att-a4-watermark"></div>
                        <div class="att-a4-header">
                            <img src="${esc(CFG.logo)}" alt="logo">
                            <div class="h-titles">
                                <div class="h-gov">Government of the People's Republic of Bangladesh</div>
                                <div class="h-org">Office of the Alamdanga Pourashava</div>
                                <div class="h-sub">Alamdanga, Chuadanga</div>
                            </div>
                            <div style="width:21mm"></div>
                        </div>`;
                } else {
                    headerHtml = `
                        <div class="att-a4-topbar"></div>
                        <div class="att-a4-watermark"></div>
                        <div class="att-a4-header">
                            <img src="${esc(CFG.logo)}" alt="logo">
                            <div class="h-titles">
                                <div class="h-bismillah">${esc(CFG.org.bismillah || 'বিসমিল্লাহির রাহমানির রাহিম')}</div>
                                <div class="h-gov">${esc(CFG.org.gov_line || 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকার')}</div>
                                <div class="h-org">${esc(CFG.org.name || 'আলমডাঙ্গা পৌরসভা')}</div>
                                <div class="h-sub">${esc(CFG.org.address || CFG.org.sub_title || 'আলমডাঙ্গা, চুয়াডাঙ্গা')}</div>
                            </div>
                            <div style="width:21mm"></div>
                        </div>`;
                }
            } else {
                headerHtml = `<div class="att-a4-pad-spacer">[ প্যাড মোড: উপরে ২.৬ ইঞ্চি ফাঁকা রাখা হয়েছে ]</div>`;
            }

            // Meta
            const memoSample = isEn
                ? `A:P:/${esc(CFG.memo_name)}/${yy || '2026'}/01`
                : `${esc(CFG.org.short_name || 'আঃপৌঃ')}/${esc(CFG.memo_name)}/${toBn(yy || '2026')}/০১`;

            const metaHtml = `
                <div class="att-a4-meta">
                    <div><b>${isEn ? 'Memo No:' : 'স্মারক নং:'}</b> ${memoSample}</div>
                    <div><b>${isEn ? 'Date:' : 'তারিখ:'}</b> ${formattedDate}</div>
                </div>`;

            const titleText = readFormVal('data[_override_title]') || CFG.type_name;
            const leadText = readFormVal('data[_override_lead]') || CFG.lead_line;
            const bodyTpl = readFormVal('data[_override_body]') || CFG.body_template;
            const closingText = readFormVal('data[_override_closing]') || CFG.closing_line;

            // Person rows
            const labelsBn = {
                applicant_name: CFG.is_deceased ? 'মৃত ব্যক্তির নাম' : 'নাম',
                id_no: idType === 'birth_reg' ? 'জন্ম নিবন্ধন নম্বর' : (idType === 'death_reg' ? 'মৃত্যু নিবন্ধন নম্বর' : 'জাতীয় পরিচয়পত্র নম্বর'),
                father_name: 'পিতার নাম',
                mother_name: 'মাতার নাম',
                spouse_name: 'স্বামী / স্ত্রীর নাম',
                ward_no: `${CFG.holder_label} ওয়ার্ড নম্বর`,
                holding_no: 'হোল্ডিং নম্বর',
                mohalla: 'মহল্লা / গ্রাম',
                upazila: 'উপজেলা / জেলা',
            };
            const labelsEn = {
                applicant_name: CFG.is_deceased ? 'Name of Deceased' : 'Name',
                id_no: idType === 'birth_reg' ? 'Birth Registration No' : (idType === 'death_reg' ? 'Death Registration No' : 'National ID (NID) No'),
                father_name: "Father's Name",
                mother_name: "Mother's Name",
                spouse_name: 'Husband / Wife Name',
                ward_no: 'Ward No',
                holding_no: 'Holding No',
                mohalla: 'Village / Road / Mohalla',
                upazila: 'Upazila & District',
            };
            const lbls = isEn ? labelsEn : labelsBn;

            let rowsHtml = '';
            (CFG.person_fields || []).forEach(pf => {
                if (pf === 'district') return;
                if (pf === 'spouse_name' && !spouseName) return;
                if (pf === 'upazila') {
                    const upVal = isEn
                        ? `Upazila: ${esc(upazila)}, District: ${esc(district)}`
                        : `উপজেলা: ${esc(upazila)}, জেলা: ${esc(district)} — এর ${CFG.is_deceased ? 'স্থায়ী বাসিন্দা ছিলেন' : 'স্থায়ী বাসিন্দা'}`;
                    rowsHtml += `<tr><td>${esc(lbls.upazila)}</td><td>:</td><td>${upVal}</td></tr>`;
                    return;
                }
                if (lbls[pf]) {
                    rowsHtml += `<tr><td>${esc(lbls[pf])}</td><td>:</td><td>${esc(dataMap[pf] || '-')}</td></tr>`;
                }
            });

            // Repeater tables
            let repHtml = '';
            (CFG.fields || []).forEach(f => {
                if (f.type === 'repeater') {
                    const tblEl = document.getElementById('repeater-' + f.key);
                    if (!tblEl) return;
                    const cols = f.columns || [];
                    const trs = tblEl.querySelectorAll('tbody tr');
                    let tbodyRows = '';
                    trs.forEach(tr => {
                        const inputs = tr.querySelectorAll('input');
                        let hasVal = false;
                        let tds = '';
                        cols.forEach((c, idx) => {
                            const v = inputs[idx] ? inputs[idx].value.trim() : '';
                            if (v) hasVal = true;
                            tds += `<td>${esc(v)}</td>`;
                        });
                        if (hasVal) {
                            tbodyRows += `<tr>${tds}</tr>`;
                        }
                    });
                    if (tbodyRows) {
                        const ths = cols.map(c => `<th>${esc(c.label || c.key)}</th>`).join('');
                        repHtml += `
                            <div class="att-a4-rep-wrap">
                                <div class="att-a4-rep-title">${esc(f.label)}:</div>
                                <table class="att-a4-rep-table">
                                    <thead><tr>${ths}</tr></thead>
                                    <tbody>${tbodyRows}</tbody>
                                </table>
                            </div>`;
                    }
                }
            });

            // Guardian signatures if applicable
            let guardianHtml = '';
            if (CFG.guardian_signatures) {
                const g1 = readFormVal('data[guardian_1_name]');
                const g1r = readFormVal('data[guardian_1_relation]');
                const g2 = readFormVal('data[guardian_2_name]');
                const g2r = readFormVal('data[guardian_2_relation]');
                guardianHtml = `
                    <div style="display:flex;justify-content:space-around;margin-top:8mm;font-size:12px;text-align:center;">
                        <div style="border-top:1px dashed #1b2430;padding-top:3px;min-width:48mm;">
                            <b>১ম অভিভাবকের স্বাক্ষর</b>
                            <div>${esc(g1)} ${g1r ? '(' + esc(g1r) + ')' : ''}</div>
                        </div>
                        <div style="border-top:1px dashed #1b2430;padding-top:3px;min-width:48mm;">
                            <b>২য় অভিভাবকের স্বাক্ষর</b>
                            <div>${esc(g2)} ${g2r ? '(' + esc(g2r) + ')' : ''}</div>
                        </div>
                    </div>`;
            }

            // Signatories
            let sigsHtml = '';
            (CFG.signatories || []).forEach((s, idx) => {
                const ovName = readFormVal(`data[_override_signatories][${idx}][name]`) || s.name || '';
                const ovDesig = readFormVal(`data[_override_signatories][${idx}][designation]`) || s.designation || '';
                sigsHtml += `
                    <div class="att-a4-sign">
                        <div class="s-space"></div>
                        <div class="s-line">
                            ${ovName ? `<div>${esc(ovName)}</div>` : ''}
                            <small><b>${esc(ovDesig)}</b></small>
                            ${s.office_line ? `<small>${esc(s.office_line)}</small>` : ''}
                            ${s.extra_line ? `<small>${esc(s.extra_line)}</small>` : ''}
                        </div>
                    </div>`;
            });

            return `
                ${headerHtml}
                ${metaHtml}
                <div class="att-a4-title"><span>${esc(titleText)}</span></div>
                <p class="att-a4-lead">${esc(leadText)}</p>
                <table class="att-a4-details">${rowsHtml}</table>
                <p class="att-a4-body">${renderTemplateStr(bodyTpl, dataMap)}</p>
                ${repHtml}
                ${closingText ? `<p class="att-a4-wish">${esc(closingText)}</p>` : ''}
                ${guardianHtml}
                <div class="att-a4-footer">
                    <div class="att-a4-qrbox">
                        <div class="att-a4-qr">QR<br>Code</div>
                        <div style="font-size:9.5px;color:#5d6b7a;max-width:42mm;line-height:1.45;">
                            <b style="color:#1b2430;display:block;">${isEn ? 'Verify Online' : 'অনলাইনে যাচাই করুন'}</b>
                            ${isEn ? 'QR code will be generated upon issue.' : 'ইস্যুর পর স্বয়ংক্রিয় QR কোড যুক্ত হবে।'}
                        </div>
                    </div>
                    <div class="att-a4-signs">${sigsHtml}</div>
                </div>
                <div class="att-a4-bottomnote">
                    ${isEn ? 'Computer generated certificate; invalid without authorized signature and seal.' : 'এটি কম্পিউটার-নির্মিত প্রত্যয়ন; কর্তৃপক্ষের স্বাক্ষর ও সিল ব্যতীত বৈধ নয়।'}
                </div>`;
        }

        function fitPreviewZoom() {
            if (!previewCol || !sheet) return;
            const avail = previewCol.clientWidth - 28;
            const sheetPx = 794; // 210mm at 96dpi
            const z = Math.min(1, Math.max(0.45, avail / sheetPx));
            sheet.style.zoom = z;
        }

        function updatePreview() {
            if (!sheet) return;
            sheet.classList.toggle('with-frame', showHeader);
            const customHtml = overrideInput ? overrideInput.value.trim() : '';
            if (customHtml) {
                if (!isDirectEdit) {
                    sheet.innerHTML = customHtml;
                }
                if (resetEditBtn) resetEditBtn.style.display = '';
                if (directEditBadge) directEditBadge.style.display = '';
            } else {
                sheet.innerHTML = buildSheetHtml();
                if (resetEditBtn) resetEditBtn.style.display = 'none';
                if (directEditBadge) directEditBadge.style.display = 'none';
            }
            fitPreviewZoom();
        }

        window.triggerLiveAttestationPreview = updatePreview;

        // Bind events
        const form = getFormEl();
        if (form) {
            form.addEventListener('input', function (e) {
                if (e.target && e.target.closest('#liveA4Sheet')) return;
                updatePreview();
            });
            form.addEventListener('change', function (e) {
                if (e.target && e.target.closest('#liveA4Sheet')) return;
                updatePreview();
            });
        }

        if (togglePadBtn) {
            togglePadBtn.addEventListener('click', function () {
                showHeader = !showHeader;
                this.textContent = showHeader ? '📄 প্যাড মোড দেখুন' : '🏛️ লেটারহেড মোড দেখুন';
                updatePreview();
            });
        }

        if (toggleEditBtn) {
            toggleEditBtn.addEventListener('click', function () {
                isDirectEdit = !isDirectEdit;
                this.classList.toggle('active', isDirectEdit);
                this.textContent = isDirectEdit ? '✔ সরাসরি এডিট বন্ধ করুন' : '✎ সরাসরি এডিট';
                if (isDirectEdit) {
                    sheet.setAttribute('contenteditable', 'true');
                    sheet.setAttribute('spellcheck', 'false');
                    sheet.focus();
                } else {
                    sheet.removeAttribute('contenteditable');
                }
            });
        }

        if (sheet) {
            sheet.addEventListener('input', function () {
                if (!isDirectEdit || !overrideInput) return;
                overrideInput.value = sheet.innerHTML;
                if (resetEditBtn) resetEditBtn.style.display = '';
                if (directEditBadge) directEditBadge.style.display = '';
            });
        }

        if (resetEditBtn) {
            resetEditBtn.addEventListener('click', function () {
                if (!confirm('সরাসরি করা সব সম্পাদনা বাদ দিয়ে ফর্মের তথ্য থেকে পত্রটি পুনরায় তৈরি করবেন?')) return;
                if (overrideInput) overrideInput.value = '';
                isDirectEdit = false;
                if (toggleEditBtn) {
                    toggleEditBtn.classList.remove('active');
                    toggleEditBtn.textContent = '✎ সরাসরি এডিট';
                }
                sheet.removeAttribute('contenteditable');
                updatePreview();
            });
        }

        window.addEventListener('resize', fitPreviewZoom);
        updatePreview();
    })();
</script>
