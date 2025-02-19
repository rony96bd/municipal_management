@if (request()->header('User-Agent') &&
        !preg_match(
            '/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i',
            request()->header('User-Agent')))
    <style>
        .main-menu li:hover {
            background-color: #000325;
            /* Change this to your desired hover color */
            color: #ffffff;
            /* Change text color on hover if needed */
        }

        /* Optional: Specific hover effect for <li> with certain classes */
        .llisting.includs-submenu:hover {
            background-color: #000325;
            /* Change this to your desired hover color */
            color: #ffffff;
            /* Change text color on hover if needed */
        }

        .llisting.includs-submenu {
            padding-right: 20px;
            padding-left: 20px;
        }
    </style>
    <section class="nav-section section background-secondary position-relative z-index-1">
        <div
            class="container site-navbar bradius-12px color-white padt-0 padb-0 z-index-3 m-display-none flex row jsb-ace">
            <nav>
                <ul class="main-menu flex row">
                    @php
                        $top_menus = getTopMenus();
                    @endphp
                    @forelse ($top_menus as $top_menu)
                        {{-- Single Menu Box --}}
                        <li
                            class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition padt-20 padb-20">
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
                            <li>কোন মেনু যুক্ত করা নেই</li>
                        @endforelse
                    </ul>
                </nav>
                <div class="search">
                    @include('icons.search')
                </div>
            </div>
        </section>
    @endif
