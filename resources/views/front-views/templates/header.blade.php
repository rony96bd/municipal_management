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
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা (প্রথম শ্রেণী)
        @endif
    </title>
</head>

<body>
    <div class="marauto full-width">
        <header class="section primary-header jfe-ace">
            {{-- main Containner --}}
            <div class="container color-white ">
                <div class="flex row gap-20 jfs-ace">
                    <img src="{{ asset('images/assets/logo.png') }}" alt="আলমডাঙ্গা পৌরসভা" class="img site-logo bradius-100-per">
                    <div class="flex column">
                        <h1 class="heading fs-h1">আলমডাঙ্গা পৌরসভা (প্রথম শ্রেণী)</h1>
                        <p class="paragraph">আমাদের প্রতিজ্ঞা দেশকল্যাণ, উদ্ভাবন, জনসেবা, সততা, নিরপেক্ষ ও দারিদ্র মুক্ত
                            স্বনির্ভর বাংলাদেশ গড়েতোলা।</p>
                    </div>
                </div>
            </div>
            {{-- Background Slidder --}}
            <div class="slider position-absolute top-0 left-0 full-width full-height">
                <div class="slides full-width full-height">
                    <div class="slide full-width full-height position-relative flex row jfe-aie padar-20 slider-active" style="background-image:url({{ asset('images/assets/hero-1.jpg') }})">
                        <p class="paragraph color-white">Slidder Text</p>
                    </div>
                    <div class="slide full-width full-height position-relative flex row jfe-aie padar-20" style="background-image:url({{ asset('images/assets/hero-1.jpg') }})">
                        <p class="paragraph color-white">Slidder Text</p>
                    </div>
                    <div class="slide full-width full-height position-relative flex row jfe-aie padar-20" style="background-image:url({{ asset('images/assets/hero-1.jpg') }})">
                        <p class="paragraph color-white">Slidder Text</p>
                    </div>
                    <div class="slide full-width full-height position-relative flex row jfe-aie padar-20" style="background-image:url({{ asset('images/assets/hero-1.jpg') }})">
                        <p class="paragraph color-white">Slidder Text</p>
                    </div>
                    <div class="slide full-width full-height position-relative flex row jfe-aie padar-20" style="background-image:url({{ asset('images/assets/hero-1.jpg') }})">
                        <p class="paragraph color-white">Slidder Text</p>
                    </div>
                </div>
            </div>
            <div class="container site-navbar bradius-12px color-white padt-0 padb-0">
                <nav class="padl-40 padr-40 padt-20 padb-20 background-primary">
                    <ul class="main-menu">
                        <li class="llisting includs-submenu flex row center width-max-content position-relative">
                            <a href="#" class="anchor color-link">প্রথম পাতা</a>
                            <img src="{{asset('images/assets/arrow-down.svg')}}" alt="arrow down" class="nav-icon">
                            <ul class="sub-menu position-absolute left-0 top-0 padt-40">
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                                <li><a href="#" class="anchor color-link">প্রথম পাতা</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
