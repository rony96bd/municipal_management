@php
    $org = config('attestation.organization', []);
    $holderLabel = $org['holder_label'] ?? 'পৌর';
    $activePersonFields = $type->person_fields ?: ['applicant_name', 'id_no', 'father_name', 'mother_name', 'ward_no', 'holding_no', 'mohalla', 'upazila', 'district'];
    $app = $application ?? null;
    $existingData = old('data', $app?->data ?? []);
    $isDeceased = $type->subject_status === 'deceased';
@endphp

<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:18px;">
    <h3 style="font-size:16px;font-weight:700;color:#0f6b3a;margin:0 0 12px 0;">
        👤 {{ $isDeceased ? 'মৃত ব্যক্তি ও আবেদনকারীর মৌলিক তথ্য' : 'প্রত্যয়ন-প্রাপকের মৌলিক তথ্য (Person Block)' }}
    </h3>

    <div class="att-grid att-grid-3">
        <div class="att-field">
            <label>{{ $isDeceased ? 'মৃত ব্যক্তির নাম' : 'পূর্ণ নাম' }} <span style="color:#dc2626">*</span></label>
            <input type="text" name="applicant_name" class="att-input" required
                value="{{ old('applicant_name', $app?->applicant_name) }}"
                placeholder="{{ $isDeceased ? 'মৃত ব্যক্তির নাম লিখুন' : 'নাম লিখুন' }}">
        </div>

        <div class="att-field">
            <label>আবেদনকারীর মোবাইল নম্বর {!! !empty($requireMobile) ? '<span style="color:#dc2626">*</span>' : '' !!}</label>
            <input type="text" name="mobile" class="att-input" {{ !empty($requireMobile) ? 'required' : '' }}
                value="{{ old('mobile', $app?->mobile) }}" placeholder="01XXXXXXXXX">
        </div>

        @if (in_array('id_no', $activePersonFields))
            <div class="att-field">
                <label>পরিচয়পত্রের ধরন ও নম্বর</label>
                <div style="display:flex;gap:6px;">
                    <select name="id_type" class="att-select" style="width:42%;">
                        @php $curIdType = old('id_type', $app?->id_type ?? ($isDeceased ? 'death_reg' : 'nid')); @endphp
                        <option value="nid" {{ $curIdType === 'nid' ? 'selected' : '' }}>এনআইডি (NID)</option>
                        <option value="birth_reg" {{ $curIdType === 'birth_reg' ? 'selected' : '' }}>জন্ম নিবন্ধন</option>
                        <option value="death_reg" {{ $curIdType === 'death_reg' ? 'selected' : '' }}>মৃত্যু নিবন্ধন</option>
                    </select>
                    <input type="text" name="id_no" class="att-input" style="width:58%;"
                        value="{{ old('id_no', $app?->id_no) }}" placeholder="নম্বর লিখুন">
                </div>
            </div>
        @endif

        @php
            $hasFatherOrSpouse = in_array('father_name', $activePersonFields)
                || in_array('spouse_name', $activePersonFields)
                || $isDeceased
                || (($type->slug ?? '') === 'warish-sonod')
                || (($type->id ?? 0) == 34);

            $curFather = old('father_name', $app?->father_name);
            $curSpouse = old('spouse_name', $app?->spouse_name);
            $savedRelation = old('data.guardian_relation', $existingData['guardian_relation'] ?? null);

            if (!$savedRelation) {
                if (!empty($curFather) && !empty($curSpouse)) {
                    $savedRelation = 'both';
                } elseif (!empty($curSpouse) && empty($curFather)) {
                    $savedRelation = 'husband';
                } else {
                    $savedRelation = 'father';
                }
            }
        @endphp

        @if ($hasFatherOrSpouse)
            <div style="grid-column: 1 / -1; background: #ffffff; border: 1.5px solid #86efac; border-radius: 8px; padding: 12px 14px; margin: 4px 0 10px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                    <label style="font-weight:700; color:#166534; font-size:13.5px; margin:0; display:flex; align-items:center; gap:6px;">
                        <span>👥</span> অভিভাবক / সম্পর্কের ধরন নির্বাচন করুন:
                    </label>
                    <div style="display:inline-flex; background:#f1f5f9; padding:3px; border-radius:7px; gap:4px; border:1px solid #cbd5e1;">
                        <label class="guardian-rel-btn {{ $savedRelation === 'father' ? 'active' : '' }}" style="display:inline-flex; align-items:center; gap:5px; cursor:pointer; padding:5px 12px; border-radius:5px; font-size:13px; font-weight:600; user-select:none; transition:all .15s; {{ $savedRelation === 'father' ? 'background:#0f6b3a;color:#ffffff;' : 'background:transparent;color:#334155;' }}">
                            <input type="radio" name="data[guardian_relation]" value="father" {{ $savedRelation === 'father' ? 'checked' : '' }} onchange="toggleGuardianRelation('father')" style="margin:0;">
                            <span>👨 পিতার নাম</span>
                        </label>
                        <label class="guardian-rel-btn {{ $savedRelation === 'husband' ? 'active' : '' }}" style="display:inline-flex; align-items:center; gap:5px; cursor:pointer; padding:5px 12px; border-radius:5px; font-size:13px; font-weight:600; user-select:none; transition:all .15s; {{ $savedRelation === 'husband' ? 'background:#0f6b3a;color:#ffffff;' : 'background:transparent;color:#334155;' }}">
                            <input type="radio" name="data[guardian_relation]" value="husband" {{ $savedRelation === 'husband' ? 'checked' : '' }} onchange="toggleGuardianRelation('husband')" style="margin:0;">
                            <span>💍 স্বামীর নাম</span>
                        </label>
                        <label class="guardian-rel-btn {{ $savedRelation === 'both' ? 'active' : '' }}" style="display:inline-flex; align-items:center; gap:5px; cursor:pointer; padding:5px 12px; border-radius:5px; font-size:13px; font-weight:600; user-select:none; transition:all .15s; {{ $savedRelation === 'both' ? 'background:#0f6b3a;color:#ffffff;' : 'background:transparent;color:#334155;' }}">
                            <input type="radio" name="data[guardian_relation]" value="both" {{ $savedRelation === 'both' ? 'checked' : '' }} onchange="toggleGuardianRelation('both')" style="margin:0;">
                            <span>👨💍 উভয়ই (পিতা ও স্বামী)</span>
                        </label>
                    </div>
                </div>

                <div class="att-grid att-grid-2" style="margin-bottom:0; gap:12px;">
                    <div class="att-field" id="guardian_father_wrap" style="{{ in_array($savedRelation, ['father', 'both']) ? '' : 'display:none;' }}; {{ $savedRelation === 'father' ? 'grid-column: 1 / -1;' : '' }} margin-bottom:0;">
                        <label style="font-size:13px; font-weight:600; color:#334155;">পিতার নাম</label>
                        <input type="text" name="father_name" id="father_name_input" class="att-input"
                            value="{{ old('father_name', $app?->father_name) }}" placeholder="পিতার নাম লিখুন">
                    </div>

                    <div class="att-field" id="guardian_spouse_wrap" style="{{ in_array($savedRelation, ['husband', 'both']) ? '' : 'display:none;' }}; {{ $savedRelation === 'husband' ? 'grid-column: 1 / -1;' : '' }} margin-bottom:0;">
                        <label style="font-size:13px; font-weight:600; color:#334155;">স্বামীর নাম</label>
                        <input type="text" name="spouse_name" id="spouse_name_input" class="att-input"
                            value="{{ old('spouse_name', $app?->spouse_name) }}" placeholder="স্বামীর নাম লিখুন">
                    </div>
                </div>
            </div>
        @endif

        @if (in_array('mother_name', $activePersonFields))
            <div class="att-field">
                <label>মাতার নাম</label>
                <input type="text" name="mother_name" class="att-input"
                    value="{{ old('mother_name', $app?->mother_name) }}" placeholder="মাতার নাম">
            </div>
        @endif

        @if (in_array('ward_no', $activePersonFields))
            <div class="att-field">
                <label>{{ $holderLabel }} ওয়ার্ড নম্বর</label>
                <select name="ward_no" class="att-select">
                    <option value="">-- ওয়ার্ড নির্বাচন করুন --</option>
                    @foreach (['০১','০২','০৩','০৪','০৫','০৬','০৭','০৮','০৯'] as $w)
                        <option value="{{ $w }}" {{ old('ward_no', $app?->ward_no) === $w ? 'selected' : '' }}>ওয়ার্ড নং {{ $w }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @if (in_array('holding_no', $activePersonFields))
            <div class="att-field">
                <label>হোল্ডিং নম্বর</label>
                <input type="text" name="holding_no" class="att-input"
                    value="{{ old('holding_no', $app?->holding_no) }}" placeholder="যেমন: ০৪৬০-০০">
            </div>
        @endif

        @if (in_array('mohalla', $activePersonFields))
            <div class="att-field">
                <label>মহল্লা / গ্রাম</label>
                <input type="text" name="mohalla" class="att-input"
                    value="{{ old('mohalla', $app?->mohalla) }}" placeholder="মহল্লা বা গ্রামের নাম">
            </div>
        @endif

        @if (in_array('upazila', $activePersonFields))
            <div class="att-field">
                <label>উপজেলা</label>
                <input type="text" name="upazila" class="att-input"
                    value="{{ old('upazila', $app?->upazila ?? ($org['default_upazila'] ?? 'আলমডাঙ্গা')) }}">
            </div>
        @endif

        @if (in_array('district', $activePersonFields))
            <div class="att-field">
                <label>জেলা</label>
                <input type="text" name="district" class="att-input"
                    value="{{ old('district', $app?->district ?? ($org['default_district'] ?? 'চুয়াডাঙ্গা')) }}">
            </div>
        @endif
    </div>
</div>

@if (!empty($type->fields) && count($type->fields) > 0)
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-bottom:18px;">
        <h3 style="font-size:16px;font-weight:700;color:#0f6b3a;margin:0 0 12px 0;">
            📝 "{{ $type->name }}"-এর অতিরিক্ত তথ্যসমূহ
        </h3>

        <div class="att-grid att-grid-2">
            @foreach ($type->fields as $f)
                @php
                    $fKey   = $f['key'] ?? '';
                    $fLabel = $f['label'] ?? $fKey;
                    $fType  = $f['type'] ?? 'text';
                    $fReq   = !empty($f['required']);
                    $fVal   = $existingData[$fKey] ?? '';
                @endphp

                @if ($fType === 'repeater')
                    <div class="att-field" style="grid-column: 1 / -1;">
                        <label style="font-size:14.5px;color:#0f6b3a;">📋 {{ $fLabel }}</label>
                        @php
                            $cols = $f['columns'] ?? [];
                            $rows = is_array($fVal) && count($fVal) > 0 ? array_values($fVal) : [array_fill_keys(array_column($cols, 'key'), '')];
                        @endphp
                        <div style="overflow-x:auto;">
                            <table class="att-table" id="repeater-{{ $fKey }}" style="background:#fff;border:1px solid #cbd5e1;">
                                <thead>
                                    <tr>
                                        @foreach ($cols as $col)
                                            <th>{{ $col['label'] ?? $col['key'] }}</th>
                                        @endforeach
                                        <th style="width:70px;text-align:center;">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $rIdx => $row)
                                        <tr>
                                            @foreach ($cols as $col)
                                                @php $cKey = $col['key']; @endphp
                                                <td>
                                                    <input type="text" class="att-input"
                                                        name="data[{{ $fKey }}][{{ $rIdx }}][{{ $cKey }}]"
                                                        value="{{ is_array($row) ? ($row[$cKey] ?? '') : '' }}"
                                                        placeholder="{{ $col['label'] ?? $cKey }}">
                                                </td>
                                            @endforeach
                                            <td style="text-align:center;">
                                                <button type="button" class="att-btn att-btn-danger att-btn-sm" onclick="removeRepeaterRow(this)">✕</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top:8px;">
                            <button type="button" class="att-btn att-btn-outline att-btn-sm"
                                onclick='addRepeaterRow("{{ $fKey }}", @json($cols))'>
                                ➕ নতুন সারি যোগ করুন
                            </button>
                        </div>
                    </div>
                @elseif ($fType === 'textarea')
                    <div class="att-field" style="grid-column: 1 / -1;">
                        <label>{{ $fLabel }} {!! $fReq ? '<span style="color:#dc2626">*</span>' : '' !!}</label>
                        <textarea name="data[{{ $fKey }}]" rows="3" class="att-textarea exclude-tyne" {{ $fReq ? 'required' : '' }}>{{ is_scalar($fVal) ? $fVal : '' }}</textarea>
                    </div>
                @elseif ($fType === 'select')
                    <div class="att-field">
                        <label>{{ $fLabel }} {!! $fReq ? '<span style="color:#dc2626">*</span>' : '' !!}</label>
                        <select name="data[{{ $fKey }}]" class="att-select" {{ $fReq ? 'required' : '' }}>
                            <option value="">-- নির্বাচন করুন --</option>
                            @foreach ($f['options'] ?? [] as $opt)
                                <option value="{{ $opt }}" {{ (string) $fVal === (string) $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($fType === 'date')
                    <div class="att-field">
                        <label>{{ $fLabel }} {!! $fReq ? '<span style="color:#dc2626">*</span>' : '' !!}</label>
                        <input type="date" name="data[{{ $fKey }}]" class="att-input"
                            value="{{ is_scalar($fVal) ? $fVal : '' }}" {{ $fReq ? 'required' : '' }}>
                    </div>
                @elseif ($fType === 'amount_with_words')
                    <div class="att-field">
                        <label>{{ $fLabel }} (সংখ্যায়) {!! $fReq ? '<span style="color:#dc2626">*</span>' : '' !!}</label>
                        <input type="text" name="data[{{ $fKey }}]" class="att-input"
                            value="{{ is_scalar($fVal) ? $fVal : '' }}" placeholder="যেমন: 60000" {{ $fReq ? 'required' : '' }}>
                    </div>
                    <div class="att-field">
                        <label>{{ $fLabel }} (কথায় — ফাঁকা রাখলে স্বয়ংক্রিয়ভাবে বসবে)</label>
                        <input type="text" name="data[{{ $fKey }}_words]" class="att-input"
                            value="{{ $existingData[$fKey . '_words'] ?? '' }}" placeholder="যেমন: ষাট হাজার">
                    </div>
                @else
                    <div class="att-field">
                        <label>{{ $fLabel }} {!! $fReq ? '<span style="color:#dc2626">*</span>' : '' !!}</label>
                        <input type="{{ $fType === 'number' ? 'number' : 'text' }}" name="data[{{ $fKey }}]"
                            class="att-input" value="{{ is_scalar($fVal) ? $fVal : '' }}" {{ $fReq ? 'required' : '' }}>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif

@if (empty($requireMobile))
    @php
        $isEnglish = ($type->language ?? 'bn') === 'en';
        $defaultLead = $isEnglish
            ? 'This is to certify that,'
            : ($isDeceased ? 'এই মর্মে প্রত্যয়ন পত্র প্রদান করা যাচ্ছে যে,' : 'এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে,');
        $presetMap = \Municipal\Attestation\Models\AttestationSignatory::whereNotNull('preset_key')->get()->keyBy('preset_key');
        $idMap     = \Municipal\Attestation\Models\AttestationSignatory::all()->keyBy('id');
        $sigSlots  = $type->signatories ?? [['preset_key' => $isEnglish ? 'EN_A' : 'A']];
    @endphp
    <input type="hidden" name="data[_override_html]" id="override_html_input" value="{{ $existingData['_override_html'] ?? '' }}">

    <details style="background:#f4fbf7;border:1px solid #cce3d6;border-radius:8px;padding:12px 14px;margin-bottom:18px;">
        <summary style="cursor:pointer;font-weight:700;color:#0f6b3a;font-size:14.5px;user-select:none;">
            📝 শিরোনাম, স্থির লেখা ও স্বাক্ষর এডিট করুন (প্রয়োজনে পরিবর্তন করুন)
        </summary>
        <div style="margin-top:12px;">
            <div class="att-grid att-grid-2">
                <div class="att-field">
                    <label>প্রিন্টের শিরোনাম (Title Override)</label>
                    <input type="text" name="data[_override_title]" class="att-input"
                        value="{{ $existingData['_override_title'] ?? '' }}"
                        placeholder="{{ $type->name }}">
                </div>
                <div class="att-field">
                    <label>শুরুর বাক্য (Lead Line Override)</label>
                    <input type="text" name="data[_override_lead]" class="att-input"
                        value="{{ $existingData['_override_lead'] ?? '' }}"
                        placeholder="{{ $defaultLead }}">
                </div>
            </div>

            <div class="att-field">
                <label>মূল বক্তব্যের টেমপ্লেট (Body Override — ফাঁকা রাখলে ডিফল্ট বসবে)</label>
                <textarea name="data[_override_body]" rows="2" class="att-textarea exclude-tyne"
                    placeholder="{{ $type->body_template }}">{{ $existingData['_override_body'] ?? '' }}</textarea>
            </div>

            <div class="att-field">
                <label>সমাপনী দোয়া / মঙ্গল কামনা লাইন (Closing Line Override)</label>
                <input type="text" name="data[_override_closing]" class="att-input"
                    value="{{ $existingData['_override_closing'] ?? '' }}"
                    placeholder="{{ $type->closing_line }}">
            </div>

            <div style="border-top:1px dashed #b9decb;padding-top:10px;margin-top:6px;">
                <strong style="font-size:13.5px;color:#0f5a3e;display:block;margin-bottom:8px;">✍️ স্বাক্ষরকারীগণের নাম ও পদবী (এই সনদের জন্য ওভাররাইড):</strong>
                <div class="att-grid att-grid-3">
                    @foreach ($sigSlots as $sIdx => $slot)
                        @php
                            $sigModel = !empty($slot['signatory_id']) ? ($idMap[$slot['signatory_id']] ?? null) : (!empty($slot['preset_key']) ? ($presetMap[$slot['preset_key']] ?? null) : null);
                            $defName = $sigModel?->name ?? ($slot['name'] ?? '');
                            $defDesig = $sigModel?->designation ?? ($slot['designation'] ?? '');
                            $ovSig = $existingData['_override_signatories'][$sIdx] ?? [];
                        @endphp
                        <div style="background:#fff;border:1px solid #d1e7dd;border-radius:7px;padding:10px;">
                            <div style="font-size:12.5px;font-weight:700;color:#0f6b3a;margin-bottom:6px;">
                                স্লট #{{ $sIdx + 1 }} {{ !empty($slot['label']) ? "({$slot['label']})" : '' }}
                            </div>
                            <div class="att-field" style="margin-bottom:6px;">
                                <label style="font-size:12px;">কর্মকর্তার নাম</label>
                                <input type="text" name="data[_override_signatories][{{ $sIdx }}][name]" class="att-input"
                                    style="padding:6px 9px;font-size:13px;"
                                    value="{{ $ovSig['name'] ?? '' }}"
                                    placeholder="{{ $defName ?: 'নাম লিখুন' }}">
                            </div>
                            <div class="att-field" style="margin-bottom:0;">
                                <label style="font-size:12px;">পদবী</label>
                                <input type="text" name="data[_override_signatories][{{ $sIdx }}][designation]" class="att-input"
                                    style="padding:6px 9px;font-size:13px;"
                                    value="{{ $ovSig['designation'] ?? '' }}"
                                    placeholder="{{ $defDesig ?: 'পদবী লিখুন' }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </details>
@endif

<script>
    function toggleGuardianRelation(rel) {
        const fatherWrap = document.getElementById('guardian_father_wrap');
        const spouseWrap = document.getElementById('guardian_spouse_wrap');
        const btnLabels = document.querySelectorAll('.guardian-rel-btn');

        btnLabels.forEach(function (lbl) {
            const inp = lbl.querySelector('input');
            if (inp && inp.value === rel) {
                lbl.classList.add('active');
                lbl.style.background = '#0f6b3a';
                lbl.style.color = '#ffffff';
            } else {
                lbl.classList.remove('active');
                lbl.style.background = 'transparent';
                lbl.style.color = '#334155';
            }
        });

        if (rel === 'father') {
            if (fatherWrap) {
                fatherWrap.style.display = '';
                fatherWrap.style.gridColumn = '1 / -1';
            }
            if (spouseWrap) {
                spouseWrap.style.display = 'none';
            }
        } else if (rel === 'husband') {
            if (fatherWrap) {
                fatherWrap.style.display = 'none';
            }
            if (spouseWrap) {
                spouseWrap.style.display = '';
                spouseWrap.style.gridColumn = '1 / -1';
            }
        } else {
            if (fatherWrap) {
                fatherWrap.style.display = '';
                fatherWrap.style.gridColumn = 'auto';
            }
            if (spouseWrap) {
                spouseWrap.style.display = '';
                spouseWrap.style.gridColumn = 'auto';
            }
        }

        if (typeof window.triggerLiveAttestationPreview === 'function') {
            window.triggerLiveAttestationPreview();
        }
    }

    function addRepeaterRow(fieldKey, columns) {
        const table = document.getElementById('repeater-' + fieldKey);
        if (!table) return;
        const tbody = table.querySelector('tbody');
        const idx = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        columns.forEach(function (col) {
            const td = document.createElement('td');
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'att-input';
            input.name = 'data[' + fieldKey + '][' + idx + '][' + col.key + ']';
            input.placeholder = col.label || col.key;
            td.appendChild(input);
            tr.appendChild(td);
        });
        const actionTd = document.createElement('td');
        actionTd.style.textAlign = 'center';
        actionTd.innerHTML = '<button type="button" class="att-btn att-btn-danger att-btn-sm" onclick="removeRepeaterRow(this)">✕</button>';
        tr.appendChild(actionTd);
        tbody.appendChild(tr);
        if (typeof window.triggerLiveAttestationPreview === 'function') {
            window.triggerLiveAttestationPreview();
        }
    }

    function removeRepeaterRow(btn) {
        const tbody = btn.closest('tbody');
        if (tbody.querySelectorAll('tr').length <= 1) {
            btn.closest('tr').querySelectorAll('input').forEach(i => i.value = '');
        } else {
            btn.closest('tr').remove();
        }
        if (typeof window.triggerLiveAttestationPreview === 'function') {
            window.triggerLiveAttestationPreview();
        }
    }
</script>
