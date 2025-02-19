@extends('front-views.templates.othe-page-header')
@section('page-body')
    <section class="section">
        <div class="container grid grid-col-5 m-grid-col-1 gap-20">
            @forelse ($stuffs as $stuff)
                <a href="{{ url('/') }}/stuff/{{ $stuff->page_url }}"
                    class="flex column gap-0 overflow-hidden bradius-10px border-solid border-1px border-gray">
                    <img src="{{ $stuff->image }}" alt="{{ $stuff->stuff_name }}"
                        class="img full-width official-repeated-image">
                    <div class="flex column padar-20 background-gray flex-auto full-width jfs-ais gap-0">
                        @if (!empty($stuff->stuff_name))
                            <h3 class="text-center">{{ $stuff->stuff_name }}</h3>
                        @endif

                        @if (!empty($stuff->designation))
                            <p class="text-center mart-10">{{ $stuff->designation }}</p>
                        @endif

                        @if (!empty($stuff->mobile))
                            <p class="text-center">মোবাইল: {{ englishToBanglaNumber($stuff->mobile) }}</p>
                        @endif
                    </div>

                </a>
            @empty
            @endforelse
        </div>
    </section>
@endsection
