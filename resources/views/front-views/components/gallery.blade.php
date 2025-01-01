@if ($galleries->isNotEmpty())
    <!-- Check if galleries contain items -->
    <div class="flex column overflow-hidden bradius-6px background-gray gap-20">
        <h3
            class="section-title padl-30 padr-30 padt-10 padb-10 background-secondary color-white font-weight-medium fs-20-28 m-padl-10 m-padr-10 m-padr-10">
            ফটো গ্যালারী
        </h3>
        <div class="grid grid-col-5 gap-10">

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

                <div class="single-gallery-item" style="background-image: url('{{ $gallery_first_image }}');">
                    {{ $gallery->topic }}
                </div>
            @endforeach



        </div>
    </div>
@endif
