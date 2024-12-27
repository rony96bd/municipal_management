<div class="dash-left-nav-box flex column padar-20 background-secondary gap-20 m-padar-10">
    <a href="{{ route('pages') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.dashboard-icons.page')</span>
        <span class="nav-title">পেজ</span>
    </a>
    <a href="{{ route('menus.index') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.dashboard-icons.menu')</span>
        <span class="nav-title">মেনু</span>
    </a>

    {{-- Site Settings --}}
    <a href="{{ route('site-setting') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace mart-auto">
        <span>@include('icons.dashboard-icons.settings')</span>
        <span class="nav-title">সেটিংস</span>
    </a>

    {{-- Collapse Menu --}}
    <div href="#" class="anchor collapse-menu sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.menu-collapes')</span>
        <span class="nav-title">Collapse</span>
    </div>
</div>
