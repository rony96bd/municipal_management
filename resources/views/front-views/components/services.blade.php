<div class="flex column overflow-hidden bradius-6px background-gray">
    <h3
        class="section-title padl-30 padr-30 padt-10 padb-10 background-secondary color-white font-weight-medium fs-20-28 m-padl-10 m-padr-10 m-padr-10">
        সেবা সমূহ
    </h3>

    <div class="grid grid-col-2 m-grid-col-1 gap-20 m-gap-10 padar-20 m-padar-10">
        {{-- Single Service --}}
        @forelse ($services as $service)
            <div class="flex column gap-10 background-white padar-20 bradius-6px">
                <h3 class="color-primary fs-18-22 color-primary">{{ $service->service_name }}</h3>
                <div class="flex row gap-10 m-gap-10 jfs-ace">
                    @include('icons.frontend-icons.service-icons.holding-tax')
                    <div class="flex column gap-5 jcc-ais flex-auto">
                        @forelse ($service->singleServices as $singleservice)
                            <a href="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}" class="anchor service-anchor position-relative color-primary font-weight-bold fs-base color-primary padl-20"><strong>{{ $singleservice->service_item_name }}</strong></a>
                        @empty
                            <p class="padar-20 text-center full-width color-warning">‘{{ $service->service_name }}’ এর অধীনে কোন সেবা যুক্ত করা নেয়</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <p class="padar-20 text-center full-width">কোন সেবা যুক্ত করা নেয়</p>
        @endforelse
    </div>
</div>
