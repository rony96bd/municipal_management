<style>
    /* Desktop Navbar Base & Divider Styling */
    .nav-section {
        background-color: var(--secondary-color);
        border-top: 1px solid rgba(255, 255, 255, 0.18);
        border-bottom: 2px solid var(--primary-color);
        box-shadow: 0 4px 14px rgba(0, 3, 37, 0.14);
        position: relative;
        z-index: 50;
    }

    .nav-section .site-navbar {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: stretch;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        border-radius: 0;
    }

    .nav-section nav {
        flex: 1;
    }

    .nav-section .main-menu {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: stretch;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    /* Top-Level Menu Items with Clear Vertical Dividers */
    .nav-section .main-menu > li.llisting {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 8px;
        padding: 15px 18px;
        position: relative;
        cursor: pointer;
        border-right: 1px solid rgba(255, 255, 255, 0.28);
        transition: background-color 0.22s ease, color 0.22s ease, box-shadow 0.22s ease;
    }

    .nav-section .main-menu > li.llisting:first-child {
        border-left: 1px solid rgba(255, 255, 255, 0.28);
    }

    .nav-section .main-menu > li.llisting > a,
    .nav-section .main-menu > li.llisting > p {
        color: var(--white-color);
        font-size: 16px;
        line-height: 1.4;
        white-space: nowrap;
        margin: 0;
        text-decoration: none;
    }

    .nav-section .main-menu > li.llisting:hover {
        background-color: var(--primary-color);
        color: var(--white-color);
        box-shadow: inset 0 -3px 0 rgba(255, 255, 255, 0.9);
    }

    .nav-section .main-menu > li.llisting > .nav-icon {
        width: 14px;
        height: 14px;
        transition: transform 0.25s ease;
        flex-shrink: 0;
    }

    .nav-section .main-menu > li.llisting:hover > .nav-icon {
        transform: rotate(180deg);
    }

    /* Dropdown Submenu with Horizontal Dividers */
    .nav-section .main-menu > li.llisting > ul.sub-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 240px;
        max-width: 340px;
        width: max-content;
        background-color: var(--primary-color);
        padding: 4px 0 !important;
        margin: 0;
        gap: 0 !important;
        border-radius: 0 0 8px 8px;
        border-top: 2px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 12px 28px rgba(0, 3, 37, 0.35);
        z-index: 100;
        display: none;
        flex-direction: column;
        list-style: none;
    }

    .nav-section .main-menu > li.llisting:hover > ul.sub-menu,
    .nav-section .main-menu > li.llisting > ul.sub-menu.active {
        display: flex;
    }

    .nav-section .main-menu > li.llisting > ul.sub-menu > li {
        width: 100%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        margin: 0;
        padding: 0;
    }

    .nav-section .main-menu > li.llisting > ul.sub-menu > li:last-child {
        border-bottom: none;
    }

    .nav-section .main-menu > li.llisting > ul.sub-menu > li > a.simple-submenu {
        display: block;
        width: 100%;
        padding: 11px 18px;
        color: var(--white-color);
        font-size: 15px;
        line-height: 1.45;
        text-decoration: none;
        transition: background-color 0.2s ease, padding-left 0.2s ease;
    }

    .nav-section .main-menu > li.llisting > ul.sub-menu > li > a.simple-submenu:hover {
        background-color: var(--secondary-color);
        padding-left: 24px;
        color: var(--white-color);
    }

    /* Mega Menu (Group Menu) Styling with Dividers */
    .nav-section .main-menu > li.llisting > div.mega-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 560px;
        max-width: 780px;
        background-color: var(--primary-color);
        padding: 18px !important;
        border-radius: 0 0 10px 10px;
        border-top: 2px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 14px 32px rgba(0, 3, 37, 0.4);
        z-index: 100;
        display: none;
        flex-direction: column;
        gap: 16px;
    }

    .nav-section .main-menu > li.llisting:hover > div.mega-menu,
    .nav-section .main-menu > li.llisting > div.mega-menu.active {
        display: flex;
    }

    .nav-section .mega-menu .single-megamenu-wrapper {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding-bottom: 12px;
    }

    .nav-section .mega-menu .single-megamenu-wrapper:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .nav-section .mega-menu .mega-menu-label {
        background-color: var(--secondary-color);
        color: var(--white-color);
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 5px;
        border-left: 4px solid var(--white-color);
        margin: 0;
    }

    .nav-section .mega-menu .mega-menu-items-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(180px, 1fr));
        column-gap: 16px;
        row-gap: 4px;
        padding: 6px 4px 0 4px;
    }

    .nav-section .mega-menu .mega-menu-items-grid > a.simple-submenu {
        display: block;
        padding: 9px 12px;
        color: var(--white-color);
        font-size: 15px;
        line-height: 1.4;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s ease, padding-left 0.2s ease;
    }

    .nav-section .mega-menu .mega-menu-items-grid > a.simple-submenu:hover {
        background-color: var(--secondary-color);
        padding-left: 18px;
        color: var(--white-color);
    }

    /* Search Button inside Desktop Navbar */
    .nav-section .search {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 18px;
        border-left: 1px solid rgba(255, 255, 255, 0.28);
        border-right: 1px solid rgba(255, 255, 255, 0.28);
        cursor: pointer;
        transition: background-color 0.22s ease;
        flex-shrink: 0;
    }

    .nav-section .search:hover {
        background-color: var(--primary-color);
    }

    /* Hide Desktop Navbar on Tablet/Mobile Viewports */
    @media (max-width: 1024px) {
        .nav-section {
            display: none !important;
        }
    }
</style>

<section class="nav-section section background-secondary position-relative">
    <div class="container site-navbar color-white padt-0 padb-0 z-index-3 m-display-none flex row jsb-ace">
        <nav>
            <ul class="main-menu flex row">
                @php
                    $top_menus = getTopMenus();
                @endphp
                @forelse ($top_menus as $top_menu)
                    {{-- Single Menu Box --}}
                    <li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
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

                        {{-- Submenu Work Start Here --}}
                        @if (!$top_menu->submenus->isEmpty() && $top_menu->groupmenus->isEmpty())
                            <img src="{{ asset('/images/assets/arrow-down.svg') }}" alt="arrow down"
                                class="nav-icon z-index-2 position-relative">
                            <ul class="sub-menu position-absolute left-0 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 flex column">
                                @foreach ($top_menu->submenus as $submenu)
                                    @php
                                        $target = $submenu->tab == 2 ? '_blank' : '_self';
                                    @endphp
                                    <li class="anchor color-link">
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
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Group Menu Work Start Here --}}
                        @if ($top_menu->submenus->isEmpty() && $top_menu->groupmenus->isNotEmpty())
                            <img src="{{ asset('/images/assets/arrow-down.svg') }}" alt="arrow down"
                                class="nav-icon z-index-2 position-relative">
                            <div class="mega-menu sub-menu position-absolute left-0 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1">
                                @foreach ($top_menu->groupmenus->filter(fn($groupmenu) => $groupmenu->submenus->isNotEmpty()) as $groupmenu)
                                    <div class="single-megamenu-wrapper flex column gap-10">
                                        <p class="mega-menu-label full-width">
                                            {{ $groupmenu->group_label }}
                                        </p>
                                        <div class="mega-menu-items-grid">
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
                    <li class="llisting">
                        <p class="color-link">কোন মেনু যুক্ত করা নেই</p>
                    </li>
                @endforelse
            </ul>
        </nav>
        <div class="search" title="অনুসন্ধান করুন">
            @include('icons.search')
        </div>
    </div>
</section>
