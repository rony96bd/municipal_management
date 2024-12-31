@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">@php
        echo $page_title;
    @endphp</h2>
    @include('dashboard.forms.create-notice')
@endsection
