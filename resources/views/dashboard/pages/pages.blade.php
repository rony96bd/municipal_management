@extends('dashboard.templates.main')
@section('dash-body')
    @if (session('success'))
        <div class="alert alert-success marb-20">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex column full-width gap-20">
        <a href="{{ route('create-page') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">নতুন
            পাতা খুলুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সকল পাতা</h2>
            <div class="flex column gap-0">
                <div
                    class="page-header background-primary color-white grid grid-col-3 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10">
                    <h3 class="fs-h3 font-weight-bold">পাতার নাম:</h3>
                </div>
                @forelse ($pages as $page)
                    <div class="page-repeater grid grid-col-3 border-color-primary full-width gap-10">
                        <div class="flex row">
                            <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10">
                                @include('icons.drag')
                            </div>
                            <a href="{{ url('/') }}/{{ $page->page_url }}"
                                class="fs-h3 padt-10 padb-10 padl-0 padr-20 flex row jst-ace flex-auto"
                                target="_blank">{{ $page->page_name }}</a>
                        </div>
                        <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace"
                            href="{{ url('/') }}/{{ $page->page_url }}"
                            target="_blank">{{ url('/') }}/{{ $page->page_url }}</a>
                        <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20">
                            <a href="{{ route('edit-page', $page->id) }}"
                                class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                করুন</a>
                            <form action="{{ route('delete-page', $page->id) }}" method="POST"
                                onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">ডিলিট
                                    করুন</button>
                            </form>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
