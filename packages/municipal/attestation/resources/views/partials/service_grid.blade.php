@php
    $logoUrl    = \Municipal\Attestation\Support\LogoHelper::url();
    $routeMode  = $routeMode ?? 'public'; // 'public' or 'admin'
    $activeId   = $activeTypeId ?? null;
    $bnCount    = $types->filter(fn($t) => ($t->language ?? 'bn') === 'bn')->count();
    $enCount    = $types->filter(fn($t) => ($t->language ?? 'bn') === 'en')->count();
    $totalCount = $types->count();
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">

<style>
    .sonod-panel {
        background: #ffffff;
        border: 1px solid #e1e4e8;
        border-left: 4px solid #c8312f;
        border-radius: 8px;
        padding: 18px 20px 22px;
        box-shadow: 0 2px 10px rgba(0,0,0,.04);
        margin-bottom: 22px;
        font-family: 'Tiro Bangla', serif;
    }
    .sonod-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e1e4e8;
        flex-wrap: wrap;
    }
    .sonod-panel-head h2 {
        font-size: 19px;
        font-weight: 700;
        color: #2b2b2b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sonod-panel-head h2 img {
        width: 28px;
        height: 28px;
        object-fit: contain;
        border-radius: 50%;
    }
    .sonod-head-tools {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        flex: 1;
        justify-content: flex-end;
    }
    .sonod-tabs {
        display: inline-flex;
        border: 1px solid #cfd6dd;
        border-radius: 6px;
        overflow: hidden;
        background: #f8fafc;
    }
    .sonod-tabs button {
        border: 0;
        background: transparent;
        padding: 7px 13px;
        font: 600 13px 'Tiro Bangla', serif;
        color: #475569;
        cursor: pointer;
        transition: all .15s;
    }
    .sonod-tabs button.active {
        background: #0f7a55;
        color: #ffffff;
    }
    .sonod-search {
        flex: 0 1 320px;
        min-width: 210px;
        padding: 8px 13px;
        border: 1px solid #cfd6dd;
        border-radius: 6px;
        font: 14px 'Tiro Bangla', serif;
        outline: none;
        background: #ffffff;
    }
    .sonod-search:focus {
        border-color: #0f7a55;
        box-shadow: 0 0 0 3px rgba(15,122,85,.12);
    }
    .sonod-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px 12px;
        padding: 20px 4px 6px;
    }
    @media (max-width: 1024px) {
        .sonod-grid { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 768px) {
        .sonod-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 520px) {
        .sonod-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .sonod-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        cursor: pointer;
        padding: 10px 6px;
        border-radius: 8px;
        transition: transform .15s, background .15s, box-shadow .15s;
        user-select: none;
        text-decoration: none;
        color: #1f2937;
        border: 1px solid transparent;
    }
    .sonod-item:hover {
        background: #f3faf6;
        transform: translateY(-2px);
        border-color: #bbf7d0;
        color: #0f7a55;
    }
    .sonod-item.active-item {
        background: #ecfdf5;
        border-color: #0f7a55;
        box-shadow: 0 0 0 2px rgba(15,122,85,.2);
    }
    .sonod-badge {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 3px solid #c8312f;
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(200,49,47,.18);
        position: relative;
    }
    .sonod-item:hover .sonod-badge {
        box-shadow: 0 4px 12px rgba(15,122,85,.28);
        border-color: #0f7a55;
    }
    .sonod-badge-in {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #1da876, #0f7a55);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 27px;
        position: relative;
        overflow: hidden;
    }
    .sonod-badge-in .logo-bg {
        position: absolute;
        inset: 4px;
        background: url('{{ $logoUrl }}') center/contain no-repeat;
        opacity: 0.22;
        pointer-events: none;
    }
    .sonod-badge-in .ico-fg {
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,.35));
    }
    .sonod-logo-mini {
        position: absolute;
        top: -3px;
        left: -3px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #ffffff;
        border: 1.5px solid #c8312f;
        padding: 1px;
        object-fit: contain;
        z-index: 3;
    }
    .sonod-ready-dot {
        position: absolute;
        right: -1px;
        bottom: -1px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: #f5b400;
        border: 2px solid #ffffff;
        z-index: 3;
    }
    .sonod-lang-pill {
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        background: #1e40af;
        color: #ffffff;
        font-size: 9.5px;
        font-weight: 700;
        padding: 1px 6px;
        border-radius: 999px;
        letter-spacing: 0.4px;
        z-index: 4;
    }
    .sonod-label {
        margin-top: 9px;
        font-size: 13.5px;
        line-height: 1.35;
        color: #1f2937;
        font-weight: 600;
        max-width: 155px;
    }
    .sonod-sublabel {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }
    .sonod-empty {
        grid-column: 1 / -1;
        text-align: center;
        color: #64748b;
        padding: 32px 12px;
        font-size: 14.5px;
    }
</style>

<div class="sonod-panel" id="sonodServicePanel">
    <div class="sonod-panel-head">
        <h2>
            <img src="{{ $logoUrl }}" alt="logo">
            <span>সনদের সেবাসমূহ</span>
            <span id="sonodVisibleCount" style="font-size:13.5px;color:#0f7a55;font-weight:600;">
                ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($totalCount) }} টি)
            </span>
        </h2>

        <div class="sonod-head-tools">
            <div class="sonod-tabs" id="sonodLangTabs">
                <button type="button" data-lang="all" class="active">
                    সব সেবা ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($totalCount) }})
                </button>
                <button type="button" data-lang="bn">
                    বাংলা প্রত্যয়ন ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($bnCount) }})
                </button>
                <button type="button" data-lang="en">
                    🌐 English সনদ ({{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits($enCount) }})
                </button>
            </div>
            <input type="search" id="sonodSearchInput" class="sonod-search" placeholder="🔍 সেবাসমূহ খুঁজতে টাইপ করুন (বাংলা / English)...">
        </div>
    </div>

    <div class="sonod-grid" id="sonodGridContainer">
        @foreach ($types as $t)
            @php
                $href = $routeMode === 'admin'
                    ? route('attestation.certificates.create', ['type_id' => $t->id])
                    : route('attestation.apply.show', $t->slug);
                $lang = $t->language ?? 'bn';
                $icon = $t->icon ?? '📜';
                $searchStr = mb_strtolower($t->name . ' ' . $t->memo_name . ' ' . ($t->description ?? '') . ' ' . $t->slug);
            @endphp
            <a href="{{ $href }}"
               class="sonod-item {{ $activeId === $t->id ? 'active-item' : '' }}"
               data-lang="{{ $lang }}"
               data-search="{{ $searchStr }}">
                <div class="sonod-badge">
                    <img src="{{ $logoUrl }}" alt="" class="sonod-logo-mini" title="{{ config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা') }}">
                    <div class="sonod-badge-in">
                        <span class="logo-bg"></span>
                        <span class="ico-fg">{{ $icon }}</span>
                    </div>
                    <span class="sonod-ready-dot" title="সক্রিয় সেবা"></span>
                    @if ($lang === 'en')
                        <span class="sonod-lang-pill">EN</span>
                    @endif
                </div>
                <div class="sonod-label">{{ $t->name }}</div>
                @if (!empty($t->description))
                    <div class="sonod-sublabel">{{ $t->description }}</div>
                @elseif ((float)$t->fee > 0)
                    <div class="sonod-sublabel">ফি: {{ \Municipal\Attestation\Support\BengaliHelper::toBengaliDigits(number_format((float)$t->fee)) }} ৳</div>
                @endif
            </a>
        @endforeach

        <div class="sonod-empty" id="sonodEmptyMsg" style="display:none;">
            কোনো সনদ বা প্রত্যয়ন সেবা খুঁজে পাওয়া যায়নি।
        </div>
    </div>
</div>

<script>
    (function () {
        const panel = document.getElementById('sonodServicePanel');
        if (!panel) return;
        const searchInput = document.getElementById('sonodSearchInput');
        const tabBtns = panel.querySelectorAll('#sonodLangTabs button');
        const items = panel.querySelectorAll('.sonod-item');
        const emptyMsg = document.getElementById('sonodEmptyMsg');
        const countEl = document.getElementById('sonodVisibleCount');
        let currentLang = 'all';

        const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        const toBn = n => String(n).replace(/\d/g, d => bnDigits[d]);

        function filterGrid() {
            const q = (searchInput.value || '').trim().toLowerCase();
            let visible = 0;
            items.forEach(item => {
                const itemLang = item.getAttribute('data-lang') || 'bn';
                const itemSearch = item.getAttribute('data-search') || '';
                const langMatch = (currentLang === 'all') || (itemLang === currentLang);
                const textMatch = !q || itemSearch.includes(q);
                if (langMatch && textMatch) {
                    item.style.display = '';
                    visible++;
                } else {
                    item.style.display = 'none';
                }
            });
            if (emptyMsg) {
                emptyMsg.style.display = visible === 0 ? 'block' : 'none';
            }
            if (countEl) {
                countEl.textContent = '(' + toBn(visible) + ' টি)';
            }
        }

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                tabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentLang = this.getAttribute('data-lang') || 'all';
                filterGrid();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', filterGrid);
        }
    })();
</script>
