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
                    @if (!empty($stuff->image))
                        <img src="/{{ $stuff->image }}" alt="{{ $stuff->stuff_name }}"
                            class="img full-width official-repeated-image">
                    @else
                        @include('icons.frontend-icons.avator')
                    @endif
                </div>
                {{-- Primary Content Box --}}
                <div class="flex column gap-5 jst-ais padb-30 m-center m-text-center">
                    @if (!empty($stuff->stuff_name))
                        <h2 class="heading fs-24-32 font-weight-medium">
                            {{ $stuff->stuff_name }}
                            <span class="fs-18-22 font-weight-medium">({{ $stuff->designation }})</span>
                        </h2>
                        <p class="fs-16-20"> আলমডাঙ্গা পৌরসভা</p>
                        <p>আলমডাঙ্গা উপজেলা, চুয়াডাঙ্গা</p>
                    @endif

                </div>

            </div>
            {{-- Detail Area --}}
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-5px overflow-hidden">
                @if (!empty($stuff->office_phone))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ফোন নাম্বার (অফিস):
                        </p>
                        <p class="text-left">{{ $stuff->office_phone }}</p>
                    </div>
                @endif
                @if (!empty($stuff->home_phone))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ফোন নাম্বার (বাসা):
                        </p>
                        <p class="text-left">{{ $stuff->home_phone }}</p>
                    </div>
                @endif
                @if (!empty($stuff->mobile))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            মোবাইল:
                        </p>
                        <p class="text-left">{{ $stuff->mobile }}</p>
                    </div>
                @endif
                @if (!empty($stuff->fax))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ফ্যাক্স:
                        </p>
                        <p class="text-left">{{ $stuff->fax }}</p>
                    </div>
                @endif
                @if (!empty($stuff->email))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            ইমেইল:
                        </p>
                        <p class="text-left">{{ $stuff->email }}</p>
                    </div>
                @endif
                @if (!empty($stuff->home_district))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            নিজ জেলা:
                        </p>
                        <p class="text-left">{{ $stuff->home_district }}</p>
                    </div>
                @endif
                @if (!empty($stuff->joining_date))
                    <div class="flex grid grid-col-2 padar-10 single-detail-wrapper jce-aic">
                        <p class="flex column gap-10">
                            বর্তমান কর্মস্থলে যোগদানের তারিখ:
                        </p>
                        <p class="text-left">{{ \Carbon\Carbon::parse($stuff->joining_date)->format('d-m-Y') }}</p>
                    </div>
                @endif

            </div>
    </section>
@endsection
