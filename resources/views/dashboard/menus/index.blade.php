@extends('dashboard.templates.main')
@section('dash-body')
    <div class="flex grid grid-col-2 m-grid-col-1 full-width gap-100">
        <div class="flex full-width justify-content-end flex column gap-20 bradius-3px">
            <h2 class="fs-h2">মেনুতে যুক্ত করতে পারবেন যে সমস্ত তথ্য</h2>
            <div class="grid grid-col-3 m-grid-col-1 gap-10">
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.static-pages')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.page')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.officials')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.representatives')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.stuffs')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.notice')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.news')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.service')
                </div>
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.top-menu-forms.custom-link')
                </div>
            </div>
        </div>
        @include('dashboard.menus.menu-prev')
    </div>
@endsection
