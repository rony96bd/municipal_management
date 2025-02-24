@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}

    <section class="section">
        <div class="container">
            <div class="flex column gap-20">
                <h2 class="text-center">{{ $page->page_name }}</h2>
                <div class="flex column gap-20">
                    <div class="flex column gap-20">
                        <p>{!! $page->page_data !!}</p>
                        <p><iframe src="{{ url($page->file_path) }}" width="100%" height="600px"></iframe></p>
                    </div>
                </div>
            </div>
    </section>
@endsection
