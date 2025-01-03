<div class="dash-left-nav-box flex column padar-20 background-secondary gap-20 m-padar-10">
    <a href="{{ route('dashboard') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace" title="ড্যাশবোর্ড">
        <span>@include('icons.dashboard')</span>
        <span class="nav-title">ড্যাশবোর্ড</span>
    </a>
    {{-- <a href="{{ route('pages') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace" title="পেজ">
        <span>@include('icons.dashboard-icons.page')</span>
        <span class="nav-title">পেজ</span>
    </a> --}}
    <a href="{{ route('menus') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace" title="মেনু">
        <span>@include('icons.dashboard-icons.menu')</span>
        <span class="nav-title">মেনু</span>
    </a>
    {{-- <a href="{{ route('notice') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace" title="নোটিশ">
        <span>@include('icons.notice')</span>
        <span class="nav-title">নোটিশ</span>
    </a>
    <a href="{{ route('news') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace" title="নিউজ">
        <span>@include('icons.news')</span>
        <span class="nav-title">নিউজ</span>
    </a> --}}
    <a href="{{ route('users-list') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace" title="ইউজার">
        <span>@include('icons.users')</span>
        <span class="nav-title">ইউজার</span>
    </a>

    {{-- Site Settings --}}
    <a href="{{ route('site-setting') }}" class="anchor sidebar-nav flex row gap-5 color-white jfs-ace mart-auto"
        title="সেটিংস">
        <span>@include('icons.dashboard-icons.settings')</span>
        <span class="nav-title">সেটিংস</span>
    </a>

    {{-- Collapse Menu --}}
    <div href="#" class="anchor collapse-menu sidebar-nav flex row gap-5 color-white jfs-ace" title="Collapse">
        <span>@include('icons.menu-collapes')</span>
        <span class="nav-title">Collapse</span>
    </div>
    <p class="color-white text-center" style="font-size: 12px">P.M.S<br>V:
        1.0.0</p>
</div>
