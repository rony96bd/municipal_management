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
        <div class="flex column gap-20 jcc-ace">
            <a href="{{ route('homepage') }}"
                class="anchor transition-duration-0-5s transition-ease-in-out transition-property-all"><img
                    src="{{ asset('images/assets/logo.png') }}" alt="আলমডাঙ্গা পৌরসভা"
                    class="img site-logo bradius-100-per"></a>
            <div class="flex column jcc-ace" style="max-width: 400px">
                <h1 class="heading fs-h1 text-center">আলমডাঙ্গা পৌরসভা </h1>
                <p class="paragraph text-center">আমাদের প্রতিজ্ঞা দেশকল্যাণ, উদ্ভাবন, জনসেবা, সততা, নিরপেক্ষ ও দারিদ্র
                    মুক্ত
                    স্বনির্ভর বাংলাদেশ গড়েতোলা।</p>
            </div>
        </div>
