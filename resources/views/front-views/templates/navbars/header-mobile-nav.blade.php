@if(request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i', request()->header('User-Agent')))
    <div class="mobile-navbar m-background-secondary m-padar-20 m-position-relative m-z-index-3 m-full-width m-flex m-row m-gap-30 m-color-white m-jsb-ace">
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
                <li class="llisting mob-menu-item flex column width-max-content full-width">
                    <div class="nav-toggle flex row full-width jsb-ace">
                        <a class="anchor color-link z-index-2 position-relative">প্রথম পাতা</a>
                        {{-- If there is any submenu show these --}}
                        <img src="{{asset('images/assets/arrow-down.svg')}}" alt="arrow down" class="nav-icon z-index-2 position-relative">
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
                {{-- Single Box End --}}
            </ul>
        </div>
    </nav>
@endif
