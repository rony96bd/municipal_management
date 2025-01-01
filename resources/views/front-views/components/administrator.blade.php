<div class="flex column overflow-hidden bradius-6px background-gray">
    <h3
        class="section-title padl-30 padr-30 padt-10 padb-10 background-secondary color-white font-weight-medium fs-20-28 m-padl-10 m-padr-10 m-padr-10">
        প্রশাসক, আলমডাঙ্গা পৌরসভা, চুয়াডাঙ্গা
    </h3>
    <div class="grid grid-col-2 m-grid-col-2 gap-20 m-gap-10 padar-20 m-padar-10">
        {{-- @forelse ($officials as $official)
            <div class="flex row m-column gap-20 jfs-ace">
                <img src="{{ $official->image }}" alt="{{ $official->name }}" class="bradius-6px administrator-img">
                <div class="flex column gap-5 jcc-ais">
                    <h3 class="color-primary fs-18-22 color-primary">শেখ মেহেদী ইসলাম</h3>
                    <h4 class="color-primary fs-base color-primary">প্রশাসক, আলমডাঙ্গা পৌরসভা, চুয়াডাঙ্গা</h4>
                    <p class="color-secondary">প্রশাসক, আলমডাঙ্গা পৌরসভা, চুয়াডাঙ্গা একজন বিশেষ কর্মচারী যিনি একটি
                        সংস্থা
                        বা প্রতিষ্ঠানের প্রধান কর্মকর্তা
                        হিসেবে কাজ করেন। প্রশাসক, আলমডাঙ্গা পৌরসভা, চুয়াডাঙ্গা সাধারণভাবে একটি প্রতিষ্ঠানের সমস্ত
                        কার্যক্রম
                        নির্দেশন করেন এবং প্রতিষ্ঠানের
                        সমস্ত কর্মকর্তাদের প্রধান হিসেবে কাজ করেন।</p>
                </div>
            </div>
        @empty
            <p class="color-warning">কোন প্রশাসক যুক্ত করা নেয়</p>
        @endforelse --}}
        @if ($official)
            {{-- Single Admin --}}
            <a href="{{ url('/officer' . '/' . $official->page_url) }}"
                class="flex row m-column m-jfs-ais gap-20 jfs-ace">
                <img src="{{ url($official->image) }}" alt="{{ $official->offificial_name }}"
                    class="bradius-6px administrator-img">
                <div class="flex column gap-5 jcc-ais">
                    @if (!empty($official->offificial_name))
                        <h2 style="font-size: x-large;" class="color-primary fs-18-22 color-primary">{{ $official->offificial_name }}</h2>
                    @endif
                    @if (!empty($official->designation))
                        <h3 style="font-size: larger;" class="color-primary fs-base color-secondary font-weight-bold"> {{ $official->designation }}
                        </h3>
                    @endif
                    @if (!empty($official->description))
                        <p class="color-primary">{{ $official->description }}</p>
                    @endif
                    @if (!empty($official->office_phone))
                        <p class="color-primary">মোবাইল নং: {{ $official->mobile }}</p>
                    @endif
                    @if (!empty($official->office_phone))
                        <p class="color-primary">ফোন (অফিস:) {{ $official->office_phone }}</p>
                    @endif
                    @if (!empty($official->fax))
                        <p class="color-primary">ফ্যাক্স: {{ $official->fax }}</p>
                    @endif
                    @if (!empty($official->email))
                        <p class="color-primary">ই-মেইল: {{ $official->email }}</p>
                    @endif
                </div>
            </a>
        @else
            <p class="color-warning">কোন প্রশাসক যুক্ত করা নেয়</p>
        @endif


    </div>
</div>
