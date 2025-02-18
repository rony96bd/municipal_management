@if ($galleries->isNotEmpty())
    <!-- Check if galleries contain items -->
    <div class="flex column overflow-hidden bradius-6px background-gray">
        <h3
            class="section-title padl-30 padr-30 padt-10 padb-10 background-secondary color-white font-weight-medium fs-20-28 m-padl-10 m-padr-10 m-padr-10">
            ফটো গ্যালারী
        </h3>
        <div class="grid grid-col-3 m-grid-col-2 gap-10 padar-20">

            @foreach ($galleries as $gallery)
                @php
                    $gallery_first_image = null; // Initialize as null for each gallery
                    $images = !empty($gallery->image_path) ? json_decode($gallery->image_path) : [];
                @endphp

                @if (!empty($images) && is_array($images))
                    @php
                        $gallery_first_image = $images[0]; // Get the first image
                    @endphp
                @else
                    <p>No images available.</p>
                @endif

                <a href="{{ url($gallery_first_image) }}" class="gallery-item flex column jfe-aie"
                    style="background-image: url('{{ $gallery_first_image }}');">
                    <p class="gallery-text full-width color-white text-center padar-5">{{ $gallery->topic }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endif
