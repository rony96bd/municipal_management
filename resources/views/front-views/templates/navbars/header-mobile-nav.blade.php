<style>
    /* Mobile Navbar & Accordion Menu with Clear Dividers */
    .mobile-nav-wrapper {
        display: none;
        width: 100%;
        position: relative;
        z-index: 60;
    }

    @media (max-width: 1024px) {
        .mobile-nav-wrapper {
            display: block;
        }
    }

    .mobile-navbar {
        background-color: var(--secondary-color);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        border-bottom: 2px solid var(--primary-color);
        box-shadow: 0 4px 12px rgba(0, 3, 37, 0.15);
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: stretch;
        width: 100%;
        color: var(--white-color);
    }

    .mobile-menu-trigger {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 12px;
        padding: 13px 18px;
        cursor: pointer;
        user-select: none;
        flex: 1;
        transition: background-color 0.2s ease;
    }

    .mobile-menu-trigger:hover,
    .mobile-menu-trigger.active {
        background-color: var(--primary-color);
    }

    .mobile-menu-trigger .paragraph {
        margin: 0;
        font-size: 17px;
        font-weight: 600;
        color: var(--white-color);
        letter-spacing: 0.3px;
    }

    .mobile-burger {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        width: 24px;
        height: 20px;
        cursor: pointer;
    }

    .mobile-burger .burger-trigger {
        display: block;
        width: 100%;
        height: 2.5px;
        background-color: var(--white-color);
        border-radius: 4px;
        transition: transform 0.25s ease, opacity 0.25s ease;
    }

    .mobile-burger.active .burger-trigger:nth-child(1) {
        transform: translateY(7.5px) rotate(45deg);
    }

    .mobile-burger.active .burger-trigger:nth-child(2) {
        opacity: 0;
    }

    .mobile-burger.active .burger-trigger:nth-child(3) {
        transform: translateY(-7.5px) rotate(-45deg);
    }

    /* Mobile Search Icon with Vertical Divider */
    .mobile-navbar .mobile-search-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 18px;
        border-left: 1px solid rgba(255, 255, 255, 0.28);
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .mobile-navbar .mobile-search-btn:hover {
        background-color: var(--primary-color);
    }

    /* Mobile Dropdown Nav Container */
    .mobile-nav {
        background-color: var(--primary-color);
        width: 100%;
        display: none;
        box-shadow: 0 12px 28px rgba(0, 3, 37, 0.38);
        border-bottom: 3px solid var(--secondary-color);
    }

    .mobile-nav .main-menu {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        gap: 0 !important;
    }

    /* Clear Horizontal Dividers Between Mobile Menu Items */
    .mobile-nav .mob-menu-item {
        width: 100% !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.16);
        margin: 0;
        padding: 0;
    }

    .mobile-nav .mob-menu-item:last-child {
        border-bottom: none;
    }

    .mobile-nav .nav-toggle {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 13px 18px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .mobile-nav .nav-toggle:hover,
    .mobile-nav .mob-menu-item.open > .nav-toggle {
        background-color: rgba(51, 97, 217, 0.32);
    }

    .mobile-nav .nav-toggle > a,
    .mobile-nav .nav-toggle > p {
        color: var(--white-color);
        font-size: 16px;
        line-height: 1.45;
        margin: 0;
        text-decoration: none;
        flex: 1;
    }

    .mobile-nav .nav-toggle > .nav-icon {
        width: 15px;
        height: 15px;
        transition: transform 0.25s ease;
        flex-shrink: 0;
        margin-left: 10px;
    }

    .mobile-nav .mob-menu-item.open > .nav-toggle > .nav-icon {
        transform: rotate(180deg);
    }

    /* Mobile Submenu & Group Menu Accordion with Dividers */
    .mobile-nav .mob-sub-wrapper {
        display: none;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.04);
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        border-left: 3px solid var(--secondary-color);
    }

    .mobile-nav .mob-sub-menu {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin: 0;
        padding: 0 !important;
        gap: 0 !important;
        list-style: none;
    }

    .mobile-nav .mob-sub-menu > a.simple-submenu {
        display: block;
        width: 100%;
        padding: 11px 18px 11px 28px;
        color: rgba(255, 255, 255, 0.92);
        font-size: 15px;
        line-height: 1.45;
        text-decoration: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.11);
        transition: background-color 0.2s ease, padding-left 0.2s ease;
    }

    .mobile-nav .mob-sub-menu > a.simple-submenu:last-child {
        border-bottom: none;
    }

    .mobile-nav .mob-sub-menu > a.simple-submenu:hover {
        background-color: var(--secondary-color);
        color: var(--white-color);
        padding-left: 34px;
    }

    .mobile-nav .mob-group-section {
        border-bottom: 1px solid rgba(255, 255, 255, 0.16);
    }

    .mobile-nav .mob-group-section:last-child {
        border-bottom: none;
    }

    .mobile-nav .mob-group-label {
        background-color: rgba(51, 97, 217, 0.38);
        color: var(--white-color);
        font-size: 14px;
        font-weight: 600;
        padding: 8px 18px 8px 24px;
        margin: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
    }
</style>

<div class="mobile-nav-wrapper">
    <div class="mobile-navbar">
        <div class="mobile-menu-trigger">
            <div class="mobile-burger">
                <span class="burger-trigger"></span>
                <span class="burger-trigger"></span>
                <span class="burger-trigger"></span>
            </div>
            <p class="paragraph">মেনু</p>
        </div>
        <div class="search mobile-search-btn" title="অনুসন্ধান করুন">
            @include('icons.search')
        </div>
    </div>

    <nav class="mobile-nav fs-16-20 full-width">
        <ul class="main-menu flex column full-width">
            @php
                $top_menus = getTopMenus();
            @endphp
            @forelse ($top_menus as $top_menu)
                @php
                    $hasSubmenus = !$top_menu->submenus->isEmpty() && $top_menu->groupmenus->isEmpty();
                    $hasGroupMenus = $top_menu->submenus->isEmpty() && $top_menu->groupmenus->isNotEmpty();
                @endphp
                <li class="llisting mob-menu-item flex column full-width">
                    <div class="nav-toggle flex row full-width jsb-ace">
                        @if ($top_menu->forigen)
                            @switch($top_menu->forigen_type)
                                @case(App\Models\officials\officials::class)
                                    <a href="{{ url('/officials' . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->offificial_name }}
                                    </a>
                                @break

                                @case(App\Models\representatives\representatives::class)
                                    <a href="{{ url('/representative' . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->name }}
                                    </a>
                                @break

                                @case(App\Models\stuff\Stuff::class)
                                    <a href="{{ url('/stuff' . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->stuff_name }}
                                    </a>
                                @break

                                @case(App\Models\page\createpage::class)
                                    <a href="{{ url('/page' . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->page_name }}
                                    </a>
                                @break

                                @case(App\Models\news\NewsModel::class)
                                    <a href="{{ url('/news' . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->topic }}
                                    </a>
                                @break

                                @case(App\Models\notice\NoticeModel::class)
                                    <a href="{{ url('/notice' . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->topic }}
                                    </a>
                                @break

                                @case(App\Models\Service\SingleService::class)
                                    <a href="{{ url('/service' . '/' . optional($top_menu->forigen->service)->page_url . '/' . $top_menu->forigen->page_url) }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->forigen->service_item_name }}
                                    </a>
                                @break
                            @endswitch
                        @endif
                        @if ($top_menu->link_url && $top_menu->link_text)
                            @php
                                $target = $top_menu->tab == 2 ? '_blank' : '_self';
                            @endphp
                            <a href="{{ $top_menu->link_url }}"
                                class="anchor color-link z-index-2 position-relative" target="{{ $target }}">
                                {{ $top_menu->link_text }}
                            </a>
                        @elseif (!$top_menu->link_url && $top_menu->link_text)
                            <p class="color-link z-index-2 position-relative">
                                {{ $top_menu->link_text }}
                            </p>
                        @endif

                        @if ($hasSubmenus || $hasGroupMenus)
                            <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
                                class="nav-icon z-index-2 position-relative">
                        @endif
                    </div>

                    {{-- Regular Submenus on Mobile --}}
                    @if ($hasSubmenus)
                        <div class="mob-sub-wrapper">
                            <div class="mob-sub-menu flex column full-width">
                                @foreach ($top_menu->submenus as $submenu)
                                    @php
                                        $target = $submenu->tab == 2 ? '_blank' : '_self';
                                    @endphp
                                    @if ($submenu->forigen)
                                        @switch($submenu->forigen_type)
                                            @case(App\Models\officials\officials::class)
                                                <a href="{{ url('/officials' . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->offificial_name }}
                                                </a>
                                            @break

                                            @case(App\Models\representatives\representatives::class)
                                                <a href="{{ url('/representative' . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->name }}
                                                </a>
                                            @break

                                            @case(App\Models\stuff\Stuff::class)
                                                <a href="{{ url('/stuff' . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->stuff_name }}
                                                </a>
                                            @break

                                            @case(App\Models\page\createpage::class)
                                                <a href="{{ url('/page' . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->page_name }}
                                                </a>
                                            @break

                                            @case(App\Models\news\NewsModel::class)
                                                <a href="{{ url('/news' . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->topic }}
                                                </a>
                                            @break

                                            @case(App\Models\notice\NoticeModel::class)
                                                <a href="{{ url('/notice' . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->topic }}
                                                </a>
                                            @break

                                            @case(App\Models\Service\SingleService::class)
                                                <a href="{{ url('/service' . '/' . optional($submenu->forigen->service)->page_url . '/' . $submenu->forigen->page_url) }}"
                                                    class="anchor simple-submenu">
                                                    {{ $submenu->forigen->service_item_name }}
                                                </a>
                                            @break

                                            @default
                                        @endswitch
                                    @endif
                                    @if ($submenu->link_text)
                                        <a href="{{ $submenu->link_url }}" class="anchor simple-submenu"
                                            target="{{ $target }}">
                                            {{ $submenu->link_text }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Group Menus (Mega Menu) on Mobile --}}
                    @if ($hasGroupMenus)
                        <div class="mob-sub-wrapper">
                            @foreach ($top_menu->groupmenus->filter(fn($groupmenu) => $groupmenu->submenus->isNotEmpty()) as $groupmenu)
                                <div class="mob-group-section">
                                    <p class="mob-group-label">{{ $groupmenu->group_label }}</p>
                                    <div class="mob-sub-menu flex column full-width">
                                        @foreach ($groupmenu->submenus as $singlegroupmenuitem)
                                            @php
                                                $target = $singlegroupmenuitem->tab == 2 ? '_blank' : '_self';
                                            @endphp
                                            @if ($singlegroupmenuitem->forigen)
                                                @switch($singlegroupmenuitem->forigen_type)
                                                    @case(App\Models\officials\officials::class)
                                                        <a href="{{ url('/officials' . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->offificial_name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\representatives\representatives::class)
                                                        <a href="{{ url('/representative' . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\stuff\Stuff::class)
                                                        <a href="{{ url('/stuff' . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->stuff_name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\page\createpage::class)
                                                        <a href="{{ url('/page' . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->page_name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\news\NewsModel::class)
                                                        <a href="{{ url('/news' . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->topic }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\notice\NoticeModel::class)
                                                        <a href="{{ url('/notice' . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->topic }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\Service\SingleService::class)
                                                        <a href="{{ url('/service' . '/' . optional($singlegroupmenuitem->forigen->service)->page_url . '/' . $singlegroupmenuitem->forigen->page_url) }}"
                                                            class="anchor simple-submenu">
                                                            {{ $singlegroupmenuitem->forigen->service_item_name }}
                                                        </a>
                                                    @break

                                                    @default
                                                @endswitch
                                            @endif
                                            @if ($singlegroupmenuitem->link_text)
                                                <a href="{{ $singlegroupmenuitem->link_url }}"
                                                    class="anchor simple-submenu" target="{{ $target }}">
                                                    {{ $singlegroupmenuitem->link_text }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </li>
            @empty
                <li class="llisting mob-menu-item">
                    <div class="nav-toggle">
                        <p class="color-link">কোন মেনু যুক্ত করা নেই</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </nav>
</div>
