<!DOCTYPE html>
<html lang="en">
@php
    $siteSettings = getSiteSettings();
@endphp

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
    <div class="marauto full-width">
        <header class="section primary-header z-index-1 flex column jcc-ace">
            {{-- main Containner --}}
            <div class="container color-white position-relative z-index-3 text-center">
                <div class="flex column gap-20 jcc-ace">
                    <a href="{{ route('homepage') }}"
                        class="anchor transition-duration-0-5s transition-ease-in-out transition-property-all"><img
                            src="
                             @if (!empty($siteSettings->site_logo)) {{ $siteSettings->site_logo }}
                            @else
                            {{ asset('images/assets/logo.png') }} @endif
                            "
                            alt="
                            @if (!empty($siteSettings->site_name)) {{ $siteSettings->site_name }}
                            @else
                                আলমডাঙ্গা পৌরসভা, চুয়াডাঙ্গা @endif
                            "
                            class="img site-logo bradius-100-per"></a>
                    <div class="flex column jcc-ace" style="max-width: calc(100% - 100px)">
                        <h1 class="heading fs-h1">
                            @if (!empty($siteSettings->site_name))
                                {{ $siteSettings->site_name }}
                            @else
                                পৌরসভা ম্যানেজমেন্ট সিস্টেম
                            @endif
                        </h1>
                        @if (!empty($siteSettings))
                            <p class="paragraph">
                                @if (!empty($siteSettings->meta_description))
                                    {{ $siteSettings->meta_description }}
                                @endif
                            </p>
                        @else
                            <p class="paragraph">
                                ফরায়েজী ক্রিয়েটিভ এজেন্সির তৈরিকৃত একটি পৌরসভা ম্যানেজমেন্ট সিস্টেম
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Background Slidder --}}
            @include('front-views.templates.background-slidder')

        </header>
        {{-- Nav --}}
        @include('front-views.templates.navbars.header-nav')
        {{-- Mobile Nav --}}
        @include('front-views.templates.navbars.header-mobile-nav')
        <main class="site-main z-index-2 position-relative">
