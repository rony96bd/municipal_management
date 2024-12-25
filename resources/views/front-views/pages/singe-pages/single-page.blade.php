@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    @if (!empty($page->page_data))
        <section class="section">
            <div class="container">
                {!! $page->page_data !!}
            </div>
        </section>
    @endif
@endsection
