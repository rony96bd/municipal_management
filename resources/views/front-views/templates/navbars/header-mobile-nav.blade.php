@if (request()->header('User-Agent') &&
        preg_match(
            '/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i',
            request()->header('User-Agent')))
    <div
        class="mobile-navbar m-background-secondary m-padar-20 m-position-relative m-z-index-3 m-full-width m-flex m-row m-gap-30 m-color-white m-jsb-ace">
        <p class="paragraph">মেনু</p>
        <div class="mobile-burger m-position-relative m-flex m-column m-gap-10">
            <span class="burger-trigger m-background-white m-bradius-10px"></span>
            <span class="burger-trigger m-background-white m-bradius-10px"></span>
            <span class="burger-trigger m-background-white m-bradius-10px"></span>
        </div>
    </div>
    <nav class="mobile-nav fs-16-20 background-secondary full-width display-none">
        <div class="m-padar-20 full-width">
            <ul class="main-menu flex column gap-20 full-width">
                {{-- Single Menu Box --}}
                @php
                    $top_menus = getTopMenus();
                @endphp
                @forelse ($top_menus as $top_menu)
                    <li class="llisting mob-menu-item flex column width-max-content full-width">
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
                            {{-- If there is any submenu show these --}}
                            @if (!$top_menu->submenus->isEmpty() && $top_menu->groupmenus->isEmpty())
                            <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
                                class="nav-icon z-index-2 position-relative">
                            @endif
                            {{-- If there is any submenu show these End --}}
                        </div>
                        <div class="mob-sub-wrapper display-none">
                            <ul class="mob-sub-menu padar-10 gap-10 flex column full-width">
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                            </ul>
                        </div>
                        {{-- If there is any submenu show these End --}}
                    </li>
                @empty
                    <li>কোন মেনু যুক্ত করা নেই</li>
                @endforelse
                    {{-- Single Box End --}}
                </ul>
            </div>
        </nav>
    @endif
