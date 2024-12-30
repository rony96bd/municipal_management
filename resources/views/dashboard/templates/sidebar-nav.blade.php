<div class="dash-left-nav-box flex column padar-20 background-secondary gap-20 m-padar-10">
    <a href="{{ route('dashboard') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.dashboard')</span>
        <span class="nav-title">ড্যাশবোর্ড</span>
    </a>
    <a href="{{ route('pages') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.dashboard-icons.page')</span>
        <span class="nav-title">পেজ</span>
    </a>
    <a href="{{ route('menus.index') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.dashboard-icons.menu')</span>
        <span class="nav-title">মেনু</span>
    </a>
    <a href="#" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace">
        <span>@include('icons.users')</span>
        <span class="nav-title">ইউজার</span>
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
    <p class="color-white text-center" style="font-size: 12px">P.M.S<br>V:
        1.0.0</p>
</div>
