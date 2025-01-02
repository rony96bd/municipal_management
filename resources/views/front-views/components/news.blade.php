@if ($news->isNotEmpty())
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
                    @forelse ($news as $singnews)
                        <a href="{{ url('/news') . '/' . $singnews->page_url }}"
                            class="single-slidder-item anchor news-item flex row gap-5 center">
                            {{ $singnews->topic }}
                        </a>
                    @empty
                        <p>কোন নিউজ যুক্ত করা নেয়</p>
                    @endforelse

                    {{-- Duplicate news items for seamless loop --}}
                    @forelse ($news as $singnews)
                        <a href="{{ url('/news') . '/' . $singnews->page_url }}"
                            class="single-slidder-item anchor news-item flex row gap-5 center">
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
