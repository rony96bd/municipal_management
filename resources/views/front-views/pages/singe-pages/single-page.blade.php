@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    @if (!empty($page->page_name))
        <section class="section">
            <div class="container">
                <h2 class="section-title">{{ $page_title }}</h2>
            </div>
    @endif
    @if (!empty($page->page_data))
            <div class="container">
                {!! $page->page_data !!}
            </div>
            <div><iframe src="{{ url($page->file_path) }}" width="100%" height="600px"></iframe></div>
    @endif
</section>
@endsection
