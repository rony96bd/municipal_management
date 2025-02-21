@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    <section class="section">
        <div class="container">
            <div class="flex column gap-20">
                <h2 class="text-center">বিজ্ঞপ্তি</h2>
                <div class="flex column gap-20">
                    <div class="flex column gap-20">
                        <h3>বিষয়: {{ $notice->topic }}</h3>
                        <p>{!! $notice->description !!}</p>
                    </div>
                </div>
            </div>
    </section>
@endsection
