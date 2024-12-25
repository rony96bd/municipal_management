@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">@php
        echo $page_title;
    @endphp</h2>
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    @include('dashboard.forms.add-stuff')
@endsection
