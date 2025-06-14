@if ($news->isNotEmpty())
    <style>
        .news-item:nth-child(1) {
            background-color: #1A237E;
            /* Deep Blue */
            color: white;
        }

        .news-item:nth-child(2) {
            background-color: #D32F2F;
            /* Deep Red */
            color: white;
        }

        .news-item:nth-child(3) {
            background-color: #0288D1;
            /* Deep Blue */
            color: white;
        }

        .news-item:nth-child(4) {
            background-color: #388E3C;
            /* Deep Green */
            color: white;
        }

        .news-item:nth-child(5) {
            background-color: #F57C00;
            /* Deep Orange */
            color: white;
        }

        .news-item:nth-child(6) {
            background-color: #8E24AA;
            /* Deep Purple */
            color: white;
        }

        /* Repeat for more items or randomize */
    </style>

    @php
        $colors = ['#1A237E', '#D32F2F', '#0288D1', '#388E3C', '#F57C00', '#8E24AA']; // Deep colors
    @endphp

    <div class="flex column overflow-hidden bradius-6px background-gray">
        <div
            class="section-title flex row gap-10 jsb-ace padl-30 padr-30 padt-10 padb-10 background-secondary color-white m-padl-10 m-padr-10 m-padr-10">
            <h3 class="font-weight-medium fs-20-28">নিউজ</h3>
            <a href="#">সকল নিউজ দেখুন</a>
        </div>

        <div class="main-slidder-box padar-20 m-padar-10 overflow-hidden">
            {{-- Single Service --}}
            <div class="slidder-wrapper-container padt-10 padb-10">
                <div class="slidder-wrapper flex row gap-5 no-wrap">
                    @forelse ($news as $index => $singnews)
                        <a href="{{ url('/news') . '/' . $singnews->page_url }}"
                            class="single-slidder-item anchor news-item flex row gap-5 center" style="color: {{ $colors[$index % count($colors)] }};">
                            {{ $singnews->topic }}
                        </a>
                    @empty
                        <p>কোন নিউজ যুক্ত করা নেয়</p>
                    @endforelse

                    {{-- Duplicate news items for seamless loop --}}
                    @forelse ($news as $index => $singnews)
                        <a href="{{ url('/news') . '/' . $singnews->page_url }}"
                            class="single-slidder-item anchor news-item flex row gap-5 center" style="color: {{ $colors[$index % count($colors)] }};">
                            {{ $singnews->topic }}
                        </a>
                    @empty
                        <p>কোন নিউজ যুক্ত করা নেয়</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endif
