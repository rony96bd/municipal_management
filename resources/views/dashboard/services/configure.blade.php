@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">@php
        echo $page_title;
    @endphp</h2>
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex column gap-10">
        <h2 class="fs-h2">নতুন সেবা যুক্ত করুন</h2>
        @include('dashboard.forms.service-configure')
    </div>



    {{-- <div class="grid grid-col-1 gap-60">

        <div class="flex full-width justify-content-end flex column gap-10 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সেবা সমূহ</h2>
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden">
                <div
                    class="page-header background-primary color-white grid grid-col-3 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                    <h3 class="fs-h3 font-weight-bold">সেবার নাম</h3>
                    <h3 class="fs-h3 font-weight-bold">পাতার ইউ.আর.এল</h3>
                    <h3 class="fs-h3 font-weight-bold text-center">অ্যাকশান</h3>
                </div>
                @forelse ($single_services as $single_service)
                    <div class="page-repeater grid grid-col-3 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0">
                        <div class="flex row">
                            <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                @include('icons.drag')
                            </div>
                            <a href="{{ url('/service') }}/ {{ $service->page_url }}/{{ $single_service->page_url }}"
                                class="fs-h3 padt-10 padb-10 padl-0 padr-20 m-padl-20 flex row jfs-ace"
                                target="_blank"><strong>{{ $single_service->service_item_name }}</strong></a>
                        </div>
                        <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace"
                            href="{{ url('/service') }}/ {{ $service->page_url }}/{{ $single_service->page_url }}"
                            target="_blank">{{ url('/service') }}/
                            {{ $service->page_url }}/{{ $single_service->page_url }}</a>
                        <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast">
                            <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none"
                                data_link="{{ url('/service') }}/{{ $single_service->page_url }}"
                                title="ইউ আর এল কপি করুন">
                                @include('icons.copy-link')
                            </div>
                            <a href="{{ route('edit-single-service-item', $single_service->id) }}"
                                class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                করুন</a>
                            <form action="{{ route('delete-service', $service->id) }}" method="POST"
                                onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">ডিলিট
                                    করুন</button>
                            </form>
                        </div>
                    </div>
                @empty
                    {{ $service->service_name }} এ কোন সেবা যুক্ত করা নেয়।
                @endforelse
            </div>
        </div>  --}}
@endsection
