<div class="dash-left-nav-box flex column padar-20 background-secondary gap-20">
    <a href="{{ route('pages') }}" class="anchor sidebar-nav flex column gap-5 color-white jfs-ace">
        <span>@include('icons.content')</span>
        <span class="nav-title">পেজ</span>
    </a>
    <a href="#" class="anchor sidebar-nav flex column gap-5 color-white jfs-ace">
        <span>@include('icons.content')</span>
        <span class="nav-title">Content</span>
    </a>
    <a href="#" class="anchor sidebar-nav flex column gap-5 color-white jfs-ace">
        <span>@include('icons.content')</span>
        <span class="nav-title">Menu</span>
    </a>
    {{-- Collapse Menu --}}
    <div href="#" class="anchor collapse-menu sidebar-nav flex row gap-5 color-white jfs-ace mart-auto">
        <span>@include('icons.menu-collapes')</span>
        <span class="nav-title">Collapse</span>
    </div>
</div>
