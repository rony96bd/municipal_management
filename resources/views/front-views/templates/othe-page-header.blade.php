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
            পৌরসভা ম্যানেজমেন্ট সিস্টেম - ফরায়েজী ক্রিয়েটিভ এজেন্সি
        @else
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা
        @endif
    </title>
</head>

<body>
    <div class="marauto full-width full-height flex column body-inner">
        <header class="section seondary-header background-primary z-index-1 flex column jcc-ace"
            style="background-image: linear-gradient(90deg,var(--primary-color) 40%,rgba(0,0,0,0)),url('{{ asset('/images/assets/hero-1.jpg') }}');">
            {{-- main Containner --}}
            <div class="container color-white position-relative z-index-3 text-left">
                <div class="flex row gap-20 jfs-ace m-column m-jst-ast">
                    <a href="{{ route('homepage') }}"
                        class="anchor transition-duration-0-5s transition-ease-in-out transition-property-all"><img
                            src="{{ asset('images/assets/logo.png') }}" alt="আলমডাঙ্গা পৌরসভা"
                            class="img site-logo bradius-100-per"></a>
                    <div class="flex column jcc-afs">
                        <h1 class="heading fs-h1">আলমডাঙ্গা পৌরসভা </h1>
                        <p class="paragraph">আমাদের প্রতিজ্ঞা দেশকল্যাণ, উদ্ভাবন, জনসেবা, সততা, নিরপেক্ষ ও দারিদ্র মুক্ত
                            স্বনির্ভর বাংলাদেশ গড়েতোলা।</p>
                    </div>
                </div>
            </div>

        </header>
        {{-- Nav --}}
        @include('front-views.templates.navbars.header-nav')
        {{-- Mobile Nav --}}
        @include('front-views.templates.navbars.header-mobile-nav')
        <main class="site-main z-index-2 position-relative flex-auto">

            @yield('page-body')
            @empty($__env->yieldContent('page-body'))
                <div class="full-width full-height flex jcc-ace row padar-20 background-gray"
                    style="min-height: calc(100vh - 458px);">
                    <p class="color-danger fs-20-28">পাতায় কোন তথ্য নেয়</p>
                </div>
            @endempty
            @include('front-views.templates.footer')
