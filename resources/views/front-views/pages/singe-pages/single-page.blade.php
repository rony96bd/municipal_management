@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    @if (!empty($page->page_name))
        <section class="section">
            <p><h2 class="section-title">{{ $page_title }}</h2></p>
    @endif
    @if (!empty($page->page_data))
            <p>{!! $page->page_data !!}</p>
            <p><iframe src="{{ url($page->file_path) }}" width="100%" height="600px"></iframe></p>
    @endif
</section>
@endsection
