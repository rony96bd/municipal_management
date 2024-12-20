<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('developers.png') }}" type="image/x-icon">
    @include('css-js-loaders.load-css')

    <title>
        @if (empty($page_title))
            ড্যাশবোর্ড - পৌরসভা ম্যানেজমেন্ট সিস্টেম - ফরায়েজী ক্রিয়েটিভ এজেন্সি
        @else
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা
        @endif
    </title>
</head>

<body>
    <main class="dashboard-body flex column gap-0">
        {{-- Dashboard Top Nav --}}
        @include('dashboard.templates.top-nav')
        {{-- Dashboard Left Nav and Main Box --}}
        <div class="flex row jst-ast dashmain-wrapper flex-auto">
            {{-- Sidebar Nav --}}
            @include('dashboard.templates.sidebar-nav')
            {{-- Dashboard Dom Conent Area --}}
            <div class="dash-main-area padar-20 flex-auto">
                {{-- All Content of Dashboard will be shownhere --}}
