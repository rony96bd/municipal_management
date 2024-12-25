@extends('front-views.templates.othe-page-header')
@section('page-body')
    <section class="section">
        <div class="container grid grid-col-5 m-grid-col-1 gap-20">
            @forelse ($representatives as $representative)
                <a href="{{ url('/') }}/officer/{{ $representative->page_url }}"
                    class="flex column gap-0 overflow-hidden bradius-10px border-solid border-1px border-gray">
                    <img src="{{ $representative->image }}" alt="{{ $representative->সৃমড }}"
                        class="img full-width official-repeated-image">
                    <div class="flex column padar-20 background-gray flex-auto full-width jfs-ais gap-0">
                        @if (!empty($representative->name))
                            <h3 class="text-center">{{ $representative->name }}</h3>
                        @endif

                        @if (!empty($representative->designation))
                            <p class="text-center mart-10">
                                @if ($representative->designation === '1')
                                    চেয়ারম্যান
                                @elseif ($representative->designation === '2')
                                    মেম্বার
                                @elseif ($representative->designation === '3')
                                    {{-- Corrected the duplicate '2' logic --}}
                                    মেম্বার (মহিলা)
                                @else
                                    কোন তথ্য নেয়
                                @endif
                            </p>
                        @endif

                        @if (!empty($representative->mobile))
                            <p class="text-center">মোবাইল: {{ $representative->mobile }}</p>
                        @endif
                    </div>

                </a>
            @empty
            @endforelse
        </div>
    </section>
@endsection
