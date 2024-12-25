@extends('front-views.templates.othe-page-header')
@section('page-body')
    {{-- section --}}
    <section class="section">
        <div class="container flex column gap-40">
            {{-- Single Page Top Board --}}
            <div
                class="background-secondary color-white single-top-item bradius-10px padt-20 padl-20 pard-20 flex row gap-40 jfs-aie border-solid border-2px border-color-secondary m-column m-center m-padr-20 m-padt-0">
                {{-- Image Box --}}
                <div
                    class="flex row center officer-main-image padar-5 border-solid border-2px border-color-secondary bradius-50-per background-white">
                    @if (!empty($representative->image))
                        <img src="/{{ $representative->image }}" alt="{{ $representative->name }}"
                            class="img full-width official-repeated-image">
                    @else
                        @include('icons.frontend-icons.avator')
                    @endif
                </div>
                {{-- Primary Content Box --}}
                <div class="flex column gap-5 jst-ais padb-30 m-center m-text-center">
                    @if (!empty($representative->name))
                        <h2 class="heading fs-24-32 font-weight-medium">
                            {{ $representative->name }}
                            <span class="fs-18-22 font-weight-medium">(
                                @if ($representative->designation === '1')
                                    চেয়ারম্যান
                                @elseif ($representative->designation === '2')
                                    মেম্বার
                                @elseif ($representative->designation === '3')
                                    মেম্বার (মহিলা)
                                @else
                                    কোন তথ্য নেয়
                                @endif


                                )
                            </span>
                        </h2>
                        <p class="fs-16-20"> আলমডাঙ্গা পৌরসভা</p>
                        <p>আলমডাঙ্গা উপজেলা, চুয়াডাঙ্গা</p>
                    @endif

                </div>

            </div>
            {{-- Detail Area --}}
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-5px overflow-hidden">
                @if (!empty($representative->word_number))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ওয়ার্ড নং:
                        </p>
                        <p class="text-left">{{ $representative->word_number }}</p>
                    </div>
                @endif
                @if (!empty($representative->elected_type))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            যে ভাবে নির্বাচিত হয়েছেন:
                        </p>
                        <p class="text-left">
                            @if ($representative->elected_type === '1')
                                নির্বাচনের মাধ্যমে নির্বাচিত
                            @elseif ($representative->elected_type === '2')
                                সংরক্ষিত আসনে নির্বাচিত
                            @elseif ($representative->elected_type === '3')
                                অনান্য
                            @else
                                কোন তথ্য নেয়
                            @endif
                        </p>
                    </div>
                @endif
                @if (!empty($representative->office_phone))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ফোন নাম্বার (অফিস):
                        </p>
                        <p class="text-left">{{ $representative->office_phone }}</p>
                    </div>
                @endif
                @if (!empty($representative->home_phone))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ফোন নাম্বার (বাসা):
                        </p>
                        <p class="text-left">{{ $representative->home_phone }}</p>
                    </div>
                @endif
                @if (!empty($representative->mobile))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            মোবাইল:
                        </p>
                        <p class="text-left">{{ $representative->mobile }}</p>
                    </div>
                @endif
                @if (!empty($representative->fax))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ফ্যাক্স:
                        </p>
                        <p class="text-left">{{ $representative->fax }}</p>
                    </div>
                @endif
                @if (!empty($representative->email))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ইমেইল:
                        </p>
                        <p class="text-left">{{ $representative->email }}</p>
                    </div>
                @endif
                @if (!empty($representative->home_district))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            নিজ জেলা:
                        </p>
                        <p class="text-left">{{ $representative->home_district }}</p>
                    </div>
                @endif
                @if (!empty($representative->joining_date))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            বর্তমান কর্মস্থলে যোগদানের তারিখ:
                        </p>
                        <p class="text-left">{{ $representative->joining_date }}</p>
                    </div>
                @endif
                @if (!empty($representative->presentaddress))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            বর্তমান ঠিকানা:
                        </p>
                        <div>{!! $representative->presentaddress !!}</div>
                    </div>
                @endif
                @if (!empty($representative->permanentaddress))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            স্থায়ী ঠিকানা:
                        </p>
                        <div>{!! $representative->permanentaddress !!}
                        </div>
                    </div>
                @endif

            </div>
    </section>
@endsection
