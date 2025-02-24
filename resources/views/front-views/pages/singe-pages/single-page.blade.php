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
                        @if ($page->file_path)
                            <p><iframe src="{{ url($page->file_path) }}" width="100%" height="600px"></iframe></p>
                        @else
                            <p>No file available to display.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
