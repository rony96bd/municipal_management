@extends('front-views.templates.othe-page-header')
@section('page-body')
    <section class="section background-secondary">
        <div class="container">
        </div>
    </section>
    {{-- section --}}
    <section class="section">
        <div class="container flex column jfs-ais">
            @if (!empty($officer->offificial_name))
                <h3 class="text-center">{{ $officer->offificial_name }}</h3>
            @endif
        </div>
    </section>
@endsection
