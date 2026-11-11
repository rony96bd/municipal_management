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

        @if (in_array('father_name', $activePersonFields))
            <div class="att-field">
                <label>পিতার নাম</label>
                <input type="text" name="father_name" class="att-input"
                    value="{{ old('father_name', $app?->father_name) }}" placeholder="পিতার নাম">
            </div>
        @endif

        @if (in_array('mother_name', $activePersonFields))
            <div class="att-field">
                <label>মাতার নাম</label>
                <input type="text" name="mother_name" class="att-input"
                    value="{{ old('mother_name', $app?->mother_name) }}" placeholder="মাতার নাম">
            </div>
        @endif

        @if (in_array('spouse_name', $activePersonFields))
            <div class="att-field">
                <label>স্বামী / স্ত্রীর নাম (প্রযোজ্য হলে)</label>
                <input type="text" name="spouse_name" class="att-input"
                    value="{{ old('spouse_name', $app?->spouse_name) }}" placeholder="স্বামী বা স্ত্রীর নাম">
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

<script>
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
    }

    function removeRepeaterRow(btn) {
        const tbody = btn.closest('tbody');
        if (tbody.querySelectorAll('tr').length <= 1) {
            btn.closest('tr').querySelectorAll('input').forEach(i => i.value = '');
            return;
        }
        btn.closest('tr').remove();
    }
</script>
