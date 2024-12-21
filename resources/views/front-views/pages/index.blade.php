@extends('front-views.templates.main')
@section('page-body')
    <section class="section">
        <div class="container flex row gap-30 jsb-ais">
            <div class="pag-main-area flex column gap-20 flex-auto">
                @include('front-views.components.notice-box')
            </div>
            @include('front-views.components.sidebar')
    </section>
@endsection
