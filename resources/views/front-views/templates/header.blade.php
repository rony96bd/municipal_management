<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @include('css-js-loaders.load-css')

    <title>
        @if (empty($page_title))
            পৌরসভা ম্যানেজমেন্ট সিস্টেম - ফরায়েজী ক্রিয়েটিভ এজেন্সি
        @else
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা
        @endif
    </title>
</head>

<body>
    <div class="marauto full-width">
        <header class="section primary-header jfe-ace z-index-1">
            {{-- main Containner --}}
            <div class="container color-white ">
                <div class="flex row gap-20 jfs-ace">
                    <a href="{{ route('homepage') }}" class="anchor transition-duration-0-5s transition-ease-in-out transition-property-all"><img src="{{ asset('images/assets/logo.png') }}" alt="আলমডাঙ্গা পৌরসভা" class="img site-logo bradius-100-per"></a>
                    <div class="flex column">
                        <h1 class="heading fs-h1">আলমডাঙ্গা পৌরসভা </h1>
                        <p class="paragraph">আমাদের প্রতিজ্ঞা দেশকল্যাণ, উদ্ভাবন, জনসেবা, সততা, নিরপেক্ষ ও দারিদ্র মুক্ত
                            স্বনির্ভর বাংলাদেশ গড়েতোলা।</p>
                    </div>
                </div>
            </div>
            {{-- Background Slidder --}}
            @include('front-views.templates.background-slidder')
            {{-- Nav --}}
            @include('front-views.templates.navbars.header-nav')
        </header>
        <main class="site-main z-index-2 position-relative">


