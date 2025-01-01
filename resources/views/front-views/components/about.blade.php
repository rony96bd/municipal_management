<div class="flex column overflow-hidden bradius-6px background-gray">
    <h3
        class="section-title padl-30 padr-30 padt-10 padb-10 background-secondary color-white font-weight-medium fs-20-28 m-padl-10 m-padr-10 m-padr-10">
        পৌরসভা সম্পর্কে
    </h3>
    <div class="flex column gap-20 m-gap-10 padar-20 m-padar-10">
        @if ($about)
            {!! $about->about_institute !!}
        @else
            <p class="color-warning">কোন প্রশাসক যুক্ত করা নেয়</p>
        @endif


    </div>
</div>
