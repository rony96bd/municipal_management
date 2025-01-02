<div id="sidebar-list" class="sortable-list flex column mart-20 bradius-6px padar-20 background-gray gap-5">
    @forelse ($sidebars as $sidebar)
        @if ($sidebar && $sidebar->forigen)
            @if ($sidebar->forigen_type === App\Models\officials\officials::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <img class="bradius-6px" src="{{ url($sidebar->forigen->image ?? 'default-image.jpg') }}"
                        alt="{{ $sidebar->forigen->offificial_name ?? 'No Official Name' }}">
                    <div class="flex column center padar-10">
                        <h3 class="fs-18-22">{{ $sidebar->forigen->offificial_name ?? 'No Official Name' }}</h3>
                        <p>{{ $sidebar->forigen->designation ?? 'No Designation' }}</p>
                    </div>
                </div>
            @elseif ($sidebar->forigen_type === App\Models\representatives\representatives::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <img class="bradius-6px" src="{{ url($sidebar->forigen->image ?? 'default-image.jpg') }}"
                        alt="{{ $sidebar->forigen->name ?? 'No Name' }}">
                    <div class="flex column center padar-10">
                        <h3 class="fs-18-22">{{ $sidebar->forigen->name ?? 'No Name' }}</h3>
                        <p>
                            @if ($sidebar->forigen->designation == '1')
                                চেয়ারম্যান
                            @elseif ($sidebar->forigen->designation == '2')
                                মেম্বার
                            @elseif ($sidebar->forigen->designation == '3')
                                মেম্বার (মহিলা)
                            @endif
                        </p>
                    </div>
                </div>
            @elseif ($sidebar->forigen_type === App\Models\stuff\Stuff::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <img class="bradius-6px" src="{{ url($sidebar->forigen->image ?? 'default-image.jpg') }}"
                        alt="{{ $sidebar->forigen->name ?? 'No Name' }}">
                    <div class="flex column center padar-10">
                        <h3 class="fs-18-22">{{ $sidebar->forigen->stuff_name ?? 'No Name' }}</h3>
                        <p>
                            {{ $sidebar->forigen->designation ?? 'No Designation' }}
                        </p>
                    </div>
                </div>
            @elseif ($sidebar->forigen_type === App\Models\page\createpage::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <a href="{{ url('/page' . '/' . $sidebar->forigen->page_url) }}"
                        class="sidebar-list-link color-primary flex padl-30 padr-20 padt-10 padb-10 position-relative fs-base"
                        target="_blank">
                        {{ $sidebar->forigen->page_name ?? 'No Page Name' }}
                    </a>
                </div>
            @elseif ($sidebar->forigen_type === App\Models\notice\NoticeModel::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <a href="{{ url('/notice' . '/' . $sidebar->forigen->page_url) }}"
                        class="sidebar-list-link color-primary flex padl-30 padr-20 padt-10 padb-10 position-relative fs-base"
                        target="_blank">
                        {{ $sidebar->forigen->topic ?? 'No Page Name' }}
                    </a>
                </div>
            @elseif ($sidebar->forigen_type === App\Models\news\NewsModel::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <a href="{{ url('/news' . '/' . $sidebar->forigen->page_url) }}"
                        class="sidebar-list-link color-primary flex padl-30 padr-20 padt-10 padb-10 position-relative fs-base"
                        target="_blank">
                        {{ $sidebar->forigen->topic ?? 'No Page Name' }}
                    </a>
                </div>
            @elseif ($sidebar->forigen_type === App\Models\Service\SingleService::class)
                <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                    <a href="{{ url('/service' . '/' . $sidebar->forigen->page_url) }}"
                        class="sidebar-list-link color-primary flex padl-30 padr-20 padt-10 padb-10 position-relative fs-base"
                        target="_blank">
                        {{ $sidebar->forigen->service_item_name ?? 'No Page Name' }}
                    </a>
                </div>
            @endif
        @endif
        @if ($sidebar->link_text)
            <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                <a href="{{ $sidebar->link_url }}"
                    class="sidebar-list-link color-primary flex padl-30 padr-20 padt-10 padb-10 position-relative fs-base"
                    target="@if ($sidebar->tab == 1) _self @elseif ($sidebar->tab == 2)_blank @else _self @endif">
                    {{ $sidebar->link_text }}
                </a>
            </div>
        @endif
        @if ($sidebar->image)
            <div class="page-repeater bradius-6px cursor-drag" style="border:none" data-id="{{ $sidebar->id }}">
                <img class="bradius-6px" src="{{ url($sidebar->image ?? 'default-image.jpg') }}"
                    alt="Sidebar Image {{ $sidebar->id }}">
            </div>
        @endif
        @if ($sidebar->gap)
            <div class="page-repeater bradius-6px cursor-drag sidebar-gap padar-20 flex row center"
                data-id="{{ $sidebar->id }}">
                <p>গ্যাপ</p>
            </div>
        @endif
        @if ($sidebar->sidebar_title)
            <div class="page-repeater sidebar-title-area flex row gap-10 jst-ace full-width padar-10 position-relative marb-10 cursor-drag"
                data-id="{{ $sidebar->id }}">
                @include('icons.frontend-icons.recent-posts')
                <h3 class="sidebar-title font-weight-medium">{{ $sidebar->sidebar_title }}</h3>
            </div>
        @endif
    @empty
        <p>কোন সাইডবার নাই</p>
    @endforelse
</div>
