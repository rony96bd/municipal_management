@extends('dashboard.templates.main')
@section('dash-body')
    <h2 class="fs-h2 marb-20">
        @php
            echo $page_title;
        @endphp</h2>
    <div class="flex column full-width gap-20">
        <a href="{{ route('menus.create') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">
            @include('icons.plus') নতুন মেন্যু খুলুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সকল মেন্যু</h2>
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden">
                <div
                    class="page-header background-primary color-white grid grid-col-3 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                    <h3 class="fs-h3 font-weight-bold">মেন্যুর নাম</h3>
                    <h3 class="fs-h3 font-weight-bold">মেন্যু ডেসক্রিপশন</h3>
                    <h3 class="fs-h3 font-weight-bold text-center">অ্যাকশান</h3>
                </div>
                @forelse ($menus as $menu)
                    <div class="page-repeater grid grid-col-3 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0">
                        <div class="flex row">
                            <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                @include('icons.drag')
                            </div>
                            <a href="{{ url('/') }}/{{ $menu->name }}"
                                class="fs-h3 padt-10 padb-10 padl-0 padr-20 flex row jst-ace flex-auto m-padl-20"
                                target="_blank">{{ $menu->name }}</a>
                        </div>
                        <div class="anchor copy-url drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                            {!! $menu->description !!}
                        </div>
                        <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast">

                            <a href="{{ route('menus.builder', $menu->id) }}"
                                class="background-success button-success-css color-primary padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">মেনু
                                বিল্ডার</a>

                            <a href="{{ route('menus.edit', $menu->id) }}"
                                class="background-success button-success-css color-primary padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">এডিট
                            </a>
                            @if ($menu->deletable == true)
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST"
                                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">ডিলিট
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
