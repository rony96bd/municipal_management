<div class="noticebox border-gray background-gray padar-30 bradius-6px gap-30 flex column"
    style="
    background-image: url({{ asset('/images/assets/notice-background.png') }});">
    <h3 class="sidebar-title font-weight-medium padl-100">নোটিশ বোর্ড</h3>
    <div class="flex column">
        @forelse ($notices as $notice)
            {{-- Single Notice Box --}}
            <a href="{{ url('/notice' . '/' . $notice->page_url) }}"
                class="anchor notice-anchor flex column gap-0 padar-5 bradius-3px">
                <img style="width: 20px; position: absolute;" src="{{ asset('images/assets/next.png') }}" alt="Notice Icon" class="img notice">
                <h3 style="margin: 1px 0px 0px 25px;" class="notice-title color-primary">{{ $notice->topic }}</h3>
                {{-- <p style="margin: 0 0 0 25px;" class="notice-date color-paragraph fs-base">বৃহস্পতিবার, সেপ্টেম্বর ৭, ২০২৩ : ৫:৪৩ পূর্বাহ্ণ </p> --}}
            </a>
        @empty
            <p class="color-warning">কোন নোটিশ নেই</p>
        @endforelse
        {{-- Primary Button --}}
        <p href="#" class="anchor flex center primary-button background-primary color-white padl-20 padr-20 padt-10 padb-10 bradius-3px mart-20 marl-auto">সকল নোটিশ</p>
    </div>
</div>
