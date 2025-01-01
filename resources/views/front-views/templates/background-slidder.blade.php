{{-- Background Slidder --}}
<div class="slider position-absolute top-0 left-0 full-width full-height">
    <div class="slides full-width full-height">
        @forelse ($slidders as $slidder)
            <div class="slide full-width full-height position-relative flex row jfe-aie"
                style="background-image: url('{{ !empty($slidder->image) ? asset($slidder->image) : asset('images/assets/hero-1.jpg') }}');">
                @if (!empty($slidder->title))
                    <p class="paragraph color-white">
                        {{ $slidder->title }}
                        <!-- Dynamically show title or a default value -->
                    </p>
                @endif

            </div>
        @empty
            <!-- Fallback content in case there are no slides -->
            <div class="slide full-width full-height position-relative flex row jfe-aie"
                style="background-image: url('{{ asset('images/assets/hero-1.jpg') }}');">
                <p class="paragraph color-white">ডামি স্লাইডার</p>
            </div>
            <div class="slide full-width full-height position-relative flex row jfe-aie"
                style="background-image: url('{{ asset('images/assets/hero-1.jpg') }}');">
                <p class="paragraph color-white">ডামি স্লাইডার</p>
            </div>
        @endforelse

    </div>
</div>
