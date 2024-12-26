@extends('dashboard.templates.main')
@section('dash-body')
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex column full-width gap-20">
        <a href="{{ route('create-service') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">নতুন
            সেবা যুক্ত করুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সেবা সমূহ</h2>

            @forelse ($services as $service)
                <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden">
                    <div
                        class="page-header background-primary color-white grid grid-col-5 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                        <h3 class="fs-h3 font-weight-bold">সেবার নাম</h3>
                        <h3 class="fs-h3 font-weight-bold grid-span-2">পাতার ইউ.আর.এল</h3>
                        <h3 class="fs-h3 font-weight-bold grid-span-2 text-center">অ্যাকশান</h3>
                    </div>
                    <div class="page-repeater grid grid-col-5 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0">
                        <div class="flex row">
                            <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                @include('icons.drag')
                            </div>
                            <a href="{{ url('/service') }}/{{ $service->page_url }}"
                                class="fs-h3 padt-10 padb-10 padl-0 padr-20 m-padl-20"
                                target="_blank"><strong>{{ $service->service_name }}</strong><br>{{ $service->service_description }}</a>
                        </div>
                        <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace grid-span-2"
                            href="{{ url('/service') }}/{{ $service->page_url }}"
                            target="_blank">{{ url('/service') }}/{{ $service->page_url }}</a>
                        <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast grid-span-2">
                            <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none"
                                data_link="{{ url('/service') }}/{{ $service->page_url }}" title="ইউ আর এল কপি করুন">
                                @include('icons.copy-link')
                            </div>
                            <a href="{{ route('service-configure', $service->page_url) }}"
                                class="background-success color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">কনফিগার
                                করুন</a>
                            <a href="{{ route('edit-service', $service->service_id) }}"
                                class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                করুন</a>
                            <form action="{{ route('delete-service', $service->service_id) }}" method="POST"
                                onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">ডিলিট
                                    করুন</button>
                            </form>
                        </div>
                    </div>
                    @forelse ($service->singleServices as $singleservice)
                        <div
                            class="page-repeater grid grid-col-5 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0">
                            <div class="flex row">
                                <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                    @include('icons.sub-item')
                                </div>
                                <a href="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}"
                                    class="fs-h3 padt-10 padb-10 padl-0 padr-20 m-padl-20 flex column jcc-ais"
                                    target="_blank"><strong>{{ $singleservice->service_item_name }}</strong></a>
                            </div>
                            <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace grid-span-2"
                                href="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}"
                                target="_blank">{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}</a>
                            <div
                                class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast grid-span-2">
                                <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none"
                                    data_link="{{ url('/service') }}/{{ $service->page_url }}/{{ $singleservice->page_url }}"
                                    title="ইউ আর এল কপি করুন">
                                    @include('icons.copy-link')
                                </div>
                                <a href="{{ route('edit-service', $service->service_id) }}"
                                    class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                    করুন</a>
                                <form action="{{ route('delete-service', $service->service_id) }}" method="POST"
                                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">ডিলিট
                                        করুন</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="padar-20 text-center full-width">{{ $service->service_name }} এর অধীনে কোন সার্ভিস যুক্ত
                            করা
                            নেয়</p>
                    @endforelse
                </div>
            @empty
                <p class="padar-20 text-center full-width">কোন সার্ভিস যুক্ত করা নেয়</p>
            @endforelse
        </div>
    </div>
    </div>
@endsection
