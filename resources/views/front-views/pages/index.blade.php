@extends('front-views.templates.main')
@section('page-body')
    <section class="section">
        <div class="container flex row gap-30 jsb-ais">
            <div class="pag-main-area flex column gap-20 flex-auto">

            </div>
            <div class="sidebar-box flex column background-white padar-20 gap-20 bradius-6px">
                {{-- Sidebar Image If needed --}}
                <img src="https://chuadangapouroshava.org/wp-content/uploads/2021/12/50-years-of-independence-of-bangladesh.png"
                    alt="Image Name" class="image sidebar-image">
                {{-- Single Sidebar Menu Repeat --}}
                <div class="sidebar-menu flex column gap-20">
                    <div class="single-sidebar flex column gap-20">
                        <div class="sidebar-title-area flex row gap-10 jst-ace full-width">
                            @include('icons.frontend-icons.recent-posts')
                            <h3 class="sidebar-title fs-24-32 font-weight-medium">সাম্প্রতিক পোস্ট</h3>
                        </div>
                        <ul class="sidebar-list flex column gap-10 full-width">
                            <li class="sidebar-list-item">
                                <a href="#" class="sidebar-list-link fs-16-20 color-primary">পোস্ট টাইটেল</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </section>
@endsection
