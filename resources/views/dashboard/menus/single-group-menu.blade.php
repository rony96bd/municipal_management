@extends('dashboard.templates.main')
@section('dash-body')
    <div class="flex grid grid-col-2 m-grid-col-1 full-width gap-100">
        <div class="flex full-width justify-content-end flex column gap-20 bradius-3px">
            <h2 class="fs-h2">সাবমেনুতে যুক্ত করতে পারবেন যে সমস্ত তথ্য</h2>
            <div class="grid grid-col-3 m-grid-col-1 gap-10">
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.static-pages')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.page')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.officials')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.representatives')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.stuffs')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.notice')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.news')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.service')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.single-group-menus.custom-link')
                </div>
            </div>
        </div>
        @include('dashboard.menus.single-group-menu-prev')
    </div>
@endsection
