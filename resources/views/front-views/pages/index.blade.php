@extends('front-views.templates.main')
@section('page-body')
    <section class="section">
        <div class="container flex row m-column gap-30 jsb-ais">
            <div class="pag-main-area flex column gap-20 flex-auto">
                {{-- Notice Box --}}
                @include('front-views.components.notice-box')
                {{-- Services --}}
                @include('front-views.components.services')
                {{-- Administrator --}}
                @include('front-views.components.administrator')
                {{-- Administrator Committee --}}
                @include('front-views.components.admin-committee')
            </div>
            @include('front-views.components.sidebar')
    </section>
@endsection
