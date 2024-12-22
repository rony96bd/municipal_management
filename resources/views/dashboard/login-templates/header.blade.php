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
            লগইন - পৌরসভা ম্যানেজমেন্ট সিস্টেম - ফরায়েজী ক্রিয়েটিভ এজেন্সি
        @else
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা
        @endif
    </title>
</head>

<body>
    <main class="login-body flex column center padar-20 gap-20"
        style="
    background-image: url({{ asset('/images/assets/login-background.jpg') }});">
