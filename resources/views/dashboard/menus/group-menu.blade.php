@extends('dashboard.templates.main')
@section('dash-body')
    <div class="flex grid grid-col-2 m-grid-col-1 full-width gap-100">
        <div class="flex full-width justify-content-end flex column gap-20 bradius-3px">
            <h2 class="fs-h2">সাবমেনু গ্রুপ যুক্ত করুন</h2>
            <div class="grid grid-col-3 m-grid-col-1 gap-10">
                <div class="sidebar-selector-wrapper padar-20 bradius-6px background-gray">
                    @include('dashboard.forms.group-menu.group')
                </div>
            </div>
        </div>
        @include('dashboard.menus.group-menu-prev')
    </div>
@endsection
