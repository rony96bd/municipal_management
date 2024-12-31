@extends('dashboard.templates.main')
@section('dash-body')
    <div class="flex column full-width gap-20">
        <a href="{{ route('create-stuff') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">
            নতুন ইউজার যুক্ত করুন</a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">সকল ইউজার</h2>
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden">
                <div
                    class="page-header background-primary color-white grid grid-col-3 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                    <h3 class="fs-h3 font-weight-bold">নাম</h3>
                    <h3 class="fs-h3 font-weight-bold">ই-মেইল</h3>
                    <h3 class="fs-h3 font-weight-bold text-center">অ্যাকশান</h3>
                </div>
                <div id="stuffs-list" class="sortable-list">
                    @forelse ($users as $user)
                        <div class="page-repeater grid grid-col-3 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0"
                            data-id="{{ $user->id }}">
                            <div class="flex row">
                                <div class="drag-box flex center padl-20 padr-20 padt-10 padb-10 m-display-none">
                                    @include('icons.drag')
                                </div>
                                <a href="{{ url('/user') }}/{{ $user->page_url }}"
                                    class="fs-h3 padt-10 padb-10 padl-0 padr-20 flex row jst-ace flex-auto m-padl-20"
                                    target="_blank">{{ $user->name }}</a>
                            </div>
                            <a class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace"
                                href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>
                            <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast">
                                {{-- <a href="{{ route('edit-stuff', $page->id) }}"
                                    class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">সম্পাদনা
                                    করুন</a>
                                <form action="{{ route('delete-stuff', $page->id) }}" method="POST"
                                    onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">ডিলিট
                                        করুন</button>
                                </form> --}}
                            </div>
                        </div>
                    @empty
                        <div class="flex row center padar-10 text-center color-danger font-weight-bold">কোন তথ্য পাওয়া যায়
                            নি। </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
