@if(request()->header('User-Agent') && !preg_match('/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i', request()->header('User-Agent')))
<section class="nav-section section background-secondary position-relative z-index-1">
    <div class="container site-navbar bradius-12px color-white padt-0 padb-0 z-index-3 m-display-none">
        <nav class="padl-40 padr-40 padt-20 padb-20">
            <ul class="main-menu flex row gap-20">
                {{-- Single Menu Box --}}
                <li class="llisting includs-submenu flex row center width-max-content position-relative transition-ease transition">
                    <a class="anchor color-link z-index-2 position-relative">প্রথম পাতা</a>
                    {{-- If there is any submenu show these --}}
                    <img src="{{asset('images/assets/arrow-down.svg')}}" alt="arrow down" class="nav-icon z-index-2 position-relative">
                    <ul class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
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
                    <img src="{{asset('images/assets/arrow-down.svg')}}" alt="arrow down" class="nav-icon z-index-2 position-relative">
                    <ul class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
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
                    <img src="{{asset('images/assets/arrow-down.svg')}}" alt="arrow down" class="nav-icon z-index-2 position-relative">
                    <ul class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
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
                    <img src="{{asset('images/assets/arrow-down.svg')}}" alt="arrow down" class="nav-icon z-index-2 position-relative">
                    <ul class="sub-menu position-absolute left-0 top-0 padt-50 transition-ease-in-out transition-duration-0-25s transition-property-all z-index-1 padl-20 padr-20 padb-10 gap-10 flex column">
                        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                        <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                    </ul>
                    {{-- If there is any submenu show these End --}}
                </li>
            {{-- Single Box End --}}
            </ul>
        </nav>
    </div>
</section>
@endif
