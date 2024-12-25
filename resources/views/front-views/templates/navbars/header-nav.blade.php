@if (request()->header('User-Agent') &&
        !preg_match(
            '/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i',
            request()->header('User-Agent')))
    <section class="nav-section section background-secondary position-relative z-index-1">
        <div
            class="container site-navbar bradius-12px color-white padt-0 padb-0 z-index-3 m-display-none flex row jsb-ace">
            <nav class="padt-20 padb-20">
                <ul class="main-menu flex row gap-20">
                    {{-- Single Menu Box --}}
                    <x-frontend-menu-bar />
                    {{-- Single Box End --}}
                </ul>
            </nav>
            <div class="search">
                @include('icons.search')
            </div>
        </div>
    </section>
@endif
