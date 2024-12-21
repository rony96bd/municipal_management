</main>
<footer class="footer-section section background-primary position-relative z-index-1 color-white">
    <div class="container">
        <div class="full-width flex row jsb-ace">
            <p>Developed & Maintained by: <a href="https://forayeji.com" target="_blank" class="color-success">Forayeji
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
</div>
@include('css-js-loaders.load-js')
<div class="search-form-box position-fixed top-0 left-0
        full-width full-height z-index-10 flex row center">
    @include('forms.search')
</div>
</body>

</html>
