@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">@php
        echo $page_title;
    @endphp</h2>
    <div class="flex column gap-10">
        @include('dashboard.forms.service-configure')
    </div>
@endsection
