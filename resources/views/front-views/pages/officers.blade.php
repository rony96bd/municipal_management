@extends('front-views.templates.othe-page-header')
@section('page-body')
    <section class="section">
        <div class="container grid grid-col-5 m-grid-col-1 gap-20">
            @forelse ($officers as $officer)
                <a href="{{ url('/') }}/officer/{{ $officer->page_url }}"
                    class="flex column gap-0 overflow-hidden bradius-10px border-solid border-1px border-gray">
                    <img src="{{ $officer->image }}" alt="{{ $officer->official_name }}"
                        class="img full-width official-repeated-image">
                    <div class="flex column padar-20 background-gray flex-auto full-width jfs-ais gap-0">
                        @if (!empty($officer->offificial_name))
                            <h3 style="padding-bottom: 5px;">{{ $officer->offificial_name }}</h3>
                        @endif

                        @if (!empty($officer->designation))
                            <p style="padding-bottom: 2px;">{{ $officer->designation }}</p>
                        @endif

                        @if (!empty($officer->mobile))
                        <p style="padding-bottom: 2px;">মোবাইল: {{ ctbn($officer->mobile) }}</p>
                        @endif
                    </div>
                </a>
            @empty
            @endforelse
        </div>
    </section>
@endsection
