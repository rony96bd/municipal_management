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

<body class="background-primary color-white flex column center full-width full-height padb-100"
    style="height: 100vh; background-image: linear-gradient(90deg, rgb(0 3 37 / 50%) 00%, rgb(0 3 37 / 50%) 100%), url(https://municipal_management.test/images/assets/hero-1.jpg)">
    <div class="container color-white position-relative z-index-3 text-center">
        <div class="flex column gap-20 jcc-ace">
            <a href="{{ route('homepage') }}"
                class="anchor transition-duration-0-5s transition-ease-in-out transition-property-all"><img
                    src="{{ asset('images/assets/logo.png') }}" alt="আলমডাঙ্গা পৌরসভা"
                    class="img site-logo bradius-100-per"></a>
            <div class="flex column jcc-ace" style="max-width: calc(100% - 100px)">
                <h1 class="heading fs-24-32">আলমডাঙ্গা পৌরসভা </h1>
                <p class="paragraph">আমাদের প্রতিজ্ঞা দেশকল্যাণ, উদ্ভাবন, জনসেবা, সততা, নিরপেক্ষ ও দারিদ্র মুক্ত
                    স্বনির্ভর বাংলাদেশ গড়েতোলা।</p>
                <h1 class="heading fs-h1 mart-80">৪০৪ পৃষ্ঠা খুঁজে পাওয়া যায়নি</h1>
                <p class="paragraph">অনুগ্রহ করে পুনরায় চেষ্টা করুন অথবা পূর্বের পাতা/প্রথম পাতায় ফেরত যান</p>
                <div class="flex row gap-20">
                    <a href="{{ route('homepage') }}"
                        class="anchor flex center primary-button background-secondary color-white padl-20 padr-20 padt-10 padb-10 bradius-3px mart-20">প্রথম
                        পাতা</a>
                    <p class="anchor flex center primary-button background-secondary color-white padl-20 padr-20 padt-10 padb-10 bradius-3px mart-20"
                        onclick="history.back()">
                        পূর্বের পাতা
                    </p>
                </div>
            </div>
        </div>
    </div>
    <footer
        class="footer-section section background-primary position-absolute bottom-0 z-index-1 color-white full-width">
        <div class="container">
            <div class="full-width flex row jsb-ace m-column m-gap-10 m-text-center">
                <p>Developed & Maintained by: <a href="https://forayeji.com" target="_blank"
                        class="color-success">Forayeji
                        Creative
                        Agency</a></p>
                <p>
                    কপিরাইট &copy;
                    @php
                        $currentYear = date('Y');
                        $startYear = 2024;

                        // Use the helper function to convert to Bangla numbers
                        $banglaYearRange =
                            $currentYear > $startYear
                                ? convertToBanglaNumber($startYear) . ' - ' . convertToBanglaNumber($currentYear)
                                : convertToBanglaNumber($startYear);
                    @endphp

                    {{ $banglaYearRange }}

                    @if (empty($page_title))
                        ফরায়েজী ক্রিয়েটিভ এজেন্সি
                    @else
                        আলমডাঙ্গা পৌরসভা
                    @endif
                </p>

            </div>
    </footer>
</body>

</html>
