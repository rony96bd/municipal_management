@php
    $coreSlots = \Municipal\Attestation\Support\AttachmentHelper::coreSlots();
    $attCategories = \Municipal\Attestation\Support\AttachmentHelper::categories();
    $existingAttachments = is_array($application?->attachments ?? null) ? $application->attachments : [];
@endphp

<div style="background:#f8fdfb;border:1.5px dashed #1a8a63;border-radius:8px;padding:16px;margin-bottom:18px;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
        <h3 style="font-size:15.5px;font-weight:700;color:#0f6b3a;margin:0;">
            📎 প্রমাণক সংযুক্তি <span style="font-size:12.5px;font-weight:500;color:#64748b;">(প্রিন্টে আসবে না — শুধু আবেদনের রেকর্ডে সংরক্ষিত থাকবে)</span>
        </h3>
        <span style="font-size:12px;color:#0f6b3a;background:#dcfce7;padding:3px 10px;border-radius:999px;font-weight:600;">
            PDF / JPG / PNG সমর্থিত
        </span>
    </div>

    @if (count($existingAttachments) > 0)
        <div style="background:#ffffff;border:1px solid #bbf7d0;border-radius:7px;padding:10px 12px;margin-bottom:14px;">
            <div style="font-size:13px;font-weight:700;color:#166534;margin-bottom:8px;">
                📂 ইতিমধ্যে সংযুক্ত প্রমাণক ফাইলসমূহ ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(count($existingAttachments)) }} টি):
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @foreach ($existingAttachments as $idx => $att)
                    <div style="display:inline-flex;align-items:center;gap:8px;background:#f0fdf4;border:1px solid #86efac;padding:6px 10px;border-radius:6px;font-size:13px;">
                        <span>{{ str_contains($att['mime'] ?? '', 'pdf') ? '📄' : '🖼️' }}</span>
                        <div>
                            <strong style="color:#0f6b3a;">{{ $att['label'] ?? 'প্রমাণক' }}:</strong>
                            <a href="{{ asset($att['path'] ?? '') }}" target="_blank" style="color:#1e40af;text-decoration:underline;font-weight:600;">
                                {{ $att['name'] ?? 'ফাইল দেখুন' }} ↗
                            </a>
                        </div>
                        <label style="display:inline-flex;align-items:center;gap:3px;color:#dc2626;font-size:12px;cursor:pointer;margin-left:4px;" title="মুছে ফেলতে টিক দিন">
                            <input type="checkbox" name="delete_attachments[]" value="{{ $idx }}"> মুছুন
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="att-grid att-grid-2" style="margin-bottom:12px;">
        @foreach ($coreSlots as $slotKey => $slotLabel)
            <div class="att-field" style="margin-bottom:4px;background:#fff;padding:10px 12px;border-radius:7px;border:1px solid #d1e7dd;">
                <label style="font-size:13px;color:#0f5a3e;">📎 {{ $slotLabel }}</label>
                <input type="file" name="core_attachments[{{ $slotKey }}]" accept=".pdf,image/*" class="att-input" style="padding:5px;font-size:12.5px;">
            </div>
        @endforeach
    </div>

    <div style="border-top:1px dashed #b9decb;padding-top:10px;">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:8px;">
            <strong style="font-size:13.5px;color:#0f5a3e;">➕ অন্যান্য প্রমাণক কাগজ সংযুক্তি (ক্যাটাগরি অনুযায়ী):</strong>
            <button type="button" class="att-btn att-btn-outline att-btn-sm" onclick="addExtraAttachmentRow()" style="border-color:#0f6b3a;color:#0f6b3a;">
                + আরেকটি প্রমাণক কাগজ যোগ করুন
            </button>
        </div>

        <div id="extra-attachments-container">
            <div class="extra-att-row" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:8px;align-items:center;margin-bottom:8px;background:#fff;padding:8px 10px;border-radius:7px;border:1px solid #d1e7dd;">
                <select name="extra_attachments_label[]" class="att-select" style="font-size:13px;padding:7px 9px;">
                    <option value="">— কাগজের ধরন নির্বাচন করুন —</option>
                    @foreach ($attCategories as $catName => $items)
                        <optgroup label="{{ $catName }}">
                            @foreach ($items as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <input type="text" name="extra_attachments_custom[]" class="att-input" style="font-size:13px;padding:7px 9px;" placeholder="অথবা কাগজের নাম লিখুন (যেমন: ওয়ারিশ সনদ)">
                <input type="file" name="extra_attachments_file[]" accept=".pdf,image/*" class="att-input" style="font-size:12.5px;padding:5px;">
                <button type="button" class="att-btn att-btn-danger att-btn-sm" onclick="removeExtraAttachmentRow(this)">✕</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/client-image-optimizer.js') }}"></script>
<script>
    function addExtraAttachmentRow() {
        const container = document.getElementById('extra-attachments-container');
        if (!container) return;
        const firstRow = container.querySelector('.extra-att-row');
        if (!firstRow) return;
        const clone = firstRow.cloneNode(true);
        clone.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(clone);
    }

    function removeExtraAttachmentRow(btn) {
        const container = document.getElementById('extra-attachments-container');
        if (!container) return;
        const rows = container.querySelectorAll('.extra-att-row');
        if (rows.length <= 1) {
            btn.closest('.extra-att-row').querySelectorAll('input, select').forEach(el => el.value = '');
            return;
        }
        btn.closest('.extra-att-row').remove();
    }
</script>
