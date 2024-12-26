@if ($items == null)
@else
    @foreach ($items as $item)
        @if ($item->type == 'divider')
            <li class="">{{ $item->divider_title }}</li>
        @else
            @if ($item->childs->isEmpty())
                <li
                    class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                    <a href="{{ $item->url }}"
                        class="{{ Request::is(ltrim($item->url, '/') . '*') ? 'mm-active' : '' }} anchor color-link z-index-2 position-relative">
                        {{ $item->title }}
                    </a>
                </li>
            @else
                <li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition"
                    @foreach ($item->childs as $child) @if (Request::is(ltrim($child->url, '/') . '*')) class="mm-active" @break @endif @endforeach>
                    <a href="{{ $item->url }}"
                        class="{{ Request::is(ltrim($item->url, '/') . '*') ? 'mm-active' : '' }} anchor color-link z-index-2 position-relative">
                        {{ $item->title }}
                    </a>
                    <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
                        class="nav-icon z-index-2 position-relative">
                    <ul
                        class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
                        @foreach ($item->childs as $child)
                            <li class="anchor color-link">
                                <a href="{{ $child->url }}"
                                    class="{{ Request::is(ltrim($child->url, '/') . '*') ? 'mm-active' : '' }}">
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endif
    @endforeach
@endif


<li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
    <a class="anchor color-link z-index-2 position-relative">প্রথম পাতা</a>
    <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
        class="nav-icon z-index-2 position-relative">
    <ul
        class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
    </ul>
</li>
{{-- Single Box End --}}
{{-- Single Menu Box --}}
<li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
    <a class="anchor color-link z-index-2 position-relative">প্রথম পাতা</a>
    {{-- If there is any submenu show these --}}
    <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
        class="nav-icon z-index-2 position-relative">
    <ul
        class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
    </ul>
    {{-- If there is any submenu show these End --}}
</li>
{{-- Single Box End --}}
{{-- Single Menu Box --}}
<li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
    <a class="anchor color-link z-index-2 position-relative">প্রথম পাতা</a>
    {{-- If there is any submenu show these --}}
    <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
        class="nav-icon z-index-2 position-relative">
    <ul
        class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
    </ul>
    {{-- If there is any submenu show these End --}}
</li>
{{-- Single Box End --}}
{{-- Single Menu Box --}}
<li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
    <a class="anchor color-link z-index-2 position-relative">প্রথম পাতা</a>
    {{-- If there is any submenu show these --}}
    <img src="{{ asset('images/assets/arrow-down.svg') }}" alt="arrow down"
        class="nav-icon z-index-2 position-relative">
    <ul
        class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
    </ul>
    {{-- If there is any submenu show these End --}}
</li>
