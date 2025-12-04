@extends('dashboard.templates.main')

@section('dash-body')
    <div class="flex column full-width gap-20">
        <a href="{{ route('posts.create') }}"
            class="outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content">
            নতুন পোস্ট লিখুন
        </a>

        <div class="flex full-width justify-content-end flex column gap-10 mart-20 bradius-3px overflow-hidden">
            <h2 class="fs-h2">{{ $page_title }}</h2>
            <div class="flex column gap-0 border-solid border-1px border-color-primary bradius-3px overflow-hidden">
                <div
                    class="page-header background-primary color-white grid grid-col-3 border-color-primary full-width gap-20 padl-20 padr-20 padt-10 padb-10 m-display-none">
                    <h3 class="fs-h3 font-weight-bold">শিরোনাম</h3>
                    <h3 class="fs-h3 font-weight-bold">পোস্টের অংশ</h3>
                    <h3 class="fs-h3 font-weight-bold text-center">অ্যাকশন</h3>
                </div>

                @forelse ($posts as $post)
                    <div class="page-repeater grid grid-col-3 border-color-primary full-width gap-10 m-grid-col-1 m-gap-0">
                        <div class="flex row">
                            <span class="fs-h3 padt-10 padb-10 padl-20 padr-20 flex row jst-ace flex-auto">
                                {{ $post->title }}
                            </span>
                        </div>

                        <div class="flex row">
                            <span class="fs-base padt-10 padb-10 padl-20 padr-20 flex row jst-ace">
                                {{ Str::limit(strip_tags($post->content ?? 'কোনো লেখা নেই'), 120, ' ...') }}
                            </span>
                        </div>

                        <div class="flex row jfe-ace gap-10 padt-10 padb-10 padl-20 padr-20 m-column m-jst-ast">
                            <a href="{{ route('posts.edit', $post->id) }}"
                                class="background-primary color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px">
                                সম্পাদনা
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">
                                    ডিলিট
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="flex row center padar-10 text-center color-danger font-weight-bold">
                        কোন পোস্ট পাওয়া যায়নি।
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection


