@if (request()->header('User-Agent') &&
        !preg_match(
            '/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i',
            request()->header('User-Agent')))
    <section class="nav-section section background-secondary position-relative z-index-1">
        <div
            class="container site-navbar bradius-12px color-white padt-0 padb-0 z-index-3 m-display-none flex row jsb-ace">
            <nav class="padt-20 padb-20">
                <ul class="main-menu flex row gap-20">
                    @php
                        $top_menus = getTopMenus();
                    @endphp
                    @forelse ($top_menus as $top_menu)
                        {{-- Single Menu Box --}}
                        <li
                            class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                            @if ($top_menu->forigen)
                                @switch($top_menu->forigen_type)
                                    @case(App\Models\officials\officials::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->offificial_name }} - <strong>(কর্মকর্তা)</strong>
                                        </a>
                                    @break

                                    @case(App\Models\representatives\representatives::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->name }} - <strong>(জনপ্রতিনিধী)</strong>
                                        </a>
                                    @break

                                    @case(App\Models\stuff\Stuff::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->stuff_name }} - <strong>(কর্মচারী)</strong>
                                        </a>
                                    @break

                                    @case(App\Models\page\createpage::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->page_name }} - <strong>(পেজ)</strong>
                                        </a>
                                    @break

                                    @case(App\Models\news\NewsModel::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->topic }} - <strong>(সংবাদ)</strong>
                                        </a>
                                    @break

                                    @case(App\Models\notice\NoticeModel::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->topic }} - <strong>(নোটিশ)</strong>
                                        </a>
                                    @break

                                    @case(App\Models\Service\SingleService::class)
                                        <a href="{{ $top_menu->forigen->page_url }}"
                                            class="anchor color-link z-index-2 position-relative">
                                            {{ $top_menu->forigen->service_item_name }} - <strong>(সেবা)</strong>
                                        </a>
                                    @break
                                @endswitch
                            @endif
                            @if ($top_menu->link_url && $top_menu->link_text)
                                @php
                                    // Check if the link_url is a full URL (e.g., google.com, https://google.com, etc.)
                                    $isFullUrl = filter_var($top_menu->link_url, FILTER_VALIDATE_URL);

                                    if (!$isFullUrl && !preg_match('~^(?:f|ht)tps?://~i', $top_menu->link_url)) {
                                        $linkUrl = 'http://' . $top_menu->link_url;
                                    } else {
                                        $linkUrl = $top_menu->link_url;
                                    }

                                    $target = $top_menu->tab == 2 ? '_blank' : '_self';
                                @endphp

                                @if ($isFullUrl || preg_match('~^(?:f|ht)tps?://~i', $linkUrl))
                                    <!-- If it's a full URL (with or without the scheme), display the link -->
                                    <a href="{{ $linkUrl }}" target="{{ $target }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->link_text }}
                                    </a>
                                @else
                                    <!-- If it's a relative URL, prepend the base URL -->
                                    <a href="{{ url($top_menu->link_url) }}" target="{{ $target }}"
                                        class="anchor color-link z-index-2 position-relative">
                                        {{ $top_menu->link_text }}
                                    </a>
                                @endif
                            @elseif (!$top_menu->link_url && $top_menu->link_text)
                                <p class="color-link z-index-2 position-relative">
                                    {{ $top_menu->link_text }}
                                </p>
                            @endif


                            {{-- Submenu Work Start Here --}}
                            @if (!$top_menu->submenus->isEmpty() && $top_menu->groupmenus->isEmpty())
                                <img src="{{ asset('/images/assets/arrow-down.svg') }}" alt="arrow down"
                                    class="nav-icon z-index-2 position-relative">
                                <ul
                                    class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-20 gap-10 flex column">
                                    @foreach ($top_menu->submenus as $submenu)
                                        @php
                                            $target = $submenu->tab == 2 ? '_blank' : '_self';
                                        @endphp
                                        <li class="anchor color-link">
                                            @if ($submenu->forigen)
                                                @switch($submenu->forigen_type)
                                                    @case(App\Models\officials\officials::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->offificial_name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\representatives\representatives::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\stuff\Stuff::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->stuff_name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\page\createpage::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->page_name }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\news\NewsModel::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->topic }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\notice\NoticeModel::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->topic }}
                                                        </a>
                                                    @break

                                                    @case(App\Models\Service\SingleService::class)
                                                        <a href="{{ $submenu->forigen->page_url }}"
                                                            class="anchor simple-submenu">
                                                            {{ $submenu->forigen->service_item_name }}
                                                        </a>
                                                    @break

                                                    @default
                                                @endswitch
                                            @else
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
                                <div
                                    class="mega-menu gap-20 sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-20">
                                    @foreach ($top_menu->groupmenus->filter(fn($groupmenu) => $groupmenu->submenus->isNotEmpty()) as $groupmenu)
                                        <div class="single-megamenu-wrapper flex column gap-10">
                                            <p
                                                class="mega-menu-label full-width padl-20 padr-20 padt-10 padb-5 bradius-3px">
                                                {{ $groupmenu->group_label }}
                                            </p>
                                            <div class="padl-10 padr-10 padb-10 grid grid-col-2 rg-10 colg-20">
                                                @foreach ($groupmenu->submenus as $singlegroupmenuitem)
                                                    @php
                                                        $target = $singlegroupmenuitem->tab == 2 ? '_blank' : '_self';
                                                    @endphp
                                                    @switch($singlegroupmenuitem->forigen_type)
                                                        @case(App\Models\officials\officials::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->offificial_name }}
                                                            </a>
                                                        @break

                                                        @case(App\Models\representatives\representatives::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->name }}
                                                            </a>
                                                        @break

                                                        @case(App\Models\stuff\Stuff::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->stuff_name }}
                                                            </a>
                                                        @break

                                                        @case(App\Models\page\createpage::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->page_name }}
                                                            </a>
                                                        @break

                                                        @case(App\Models\news\NewsModel::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->topic }}
                                                            </a>
                                                        @break

                                                        @case(App\Models\notice\NoticeModel::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->topic }}
                                                            </a>
                                                        @break

                                                        @case(App\Models\Service\SingleService::class)
                                                            <a href="{{ $singlegroupmenuitem->forigen->page_url }}"
                                                                class="anchor simple-submenu">
                                                                {{ $singlegroupmenuitem->forigen->service_item_name }}
                                                            </a>
                                                        @break

                                                        @default
                                                    @endswitch
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
                            কোন মেনু যুক্ত করা নেয়
                        @endforelse
                        {{-- <li
                        class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                        <a href="/about-us" class=" anchor color-link z-index-2 position-relative">
                            পৌরসভা সম্পর্কিত
                        </a>
                        <img src="https://alamdangapouroshava.org/images/assets/arrow-down.svg" alt="arrow down"
                            class="nav-icon z-index-2 position-relative">
                        <ul
                            class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
                            <li class="anchor color-link">
                                <a href="/at-a-glance" class="">
                                    এক নজরে পৌরসভা
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                        <a href="/about-us" class=" anchor color-link z-index-2 position-relative">
                            সেবা সমূহ
                        </a>
                        <img src="https://alamdangapouroshava.org/images/assets/arrow-down.svg" alt="arrow down"
                            class="nav-icon z-index-2 position-relative">
                        <ul
                            class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
                            <li class="anchor color-link">
                                <a href="/at-a-glance" class="">
                                    হোল্ডিং ট্যাক্স
                                </a>
                            </li>
                            <li class="anchor color-link">
                                <a href="/at-a-glance" class="">
                                    ওয়াটার সাপ্লাই
                                </a>
                            </li>
                            <li class="anchor color-link">
                                <a href="/at-a-glance" class="">
                                    ট্রেড লাইসেন্স
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                        <a href="/about-us" class=" anchor color-link z-index-2 position-relative">
                            জনবল
                        </a>
                        <img src="https://alamdangapouroshava.org/images/assets/arrow-down.svg" alt="arrow down"
                            class="nav-icon z-index-2 position-relative">
                        <ul
                            class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
                            <li class="anchor color-link">
                                <a href="/at-a-glance" class="">
                                    কর্মকর্তা
                                </a>
                            </li>
                            <li class="anchor color-link">
                                <a href="/at-a-glance" class="">
                                    কর্মচারী
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                        <a href="/about-us" class=" anchor color-link z-index-2 position-relative">
                            প্রকল্পসমূহ
                        </a>
                    </li>
                    <li
                        class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                        <a href="/about-us" class=" anchor color-link z-index-2 position-relative">
                            কমিটিসমূহ
                        </a>
                    </li>
                    <li
                        class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                        <a href="/about-us" class=" anchor color-link z-index-2 position-relative">
                            গ্যালারী
                        </a>
                    </li> --}}
                        {{-- Single Box End --}}
                    </ul>
                </nav>
                <div class="search">
                    @include('icons.search')
                </div>
            </div>
        </section>
    @endif
