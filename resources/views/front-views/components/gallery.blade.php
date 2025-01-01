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
                    // Check if 'image_paths' is not null or empty before decoding
                    $imagePaths = !empty($gallery->image_paths) ? json_decode($gallery->image_paths, true) : [];
                @endphp

                @if (!empty($imagePaths))
                    @foreach ($imagePaths as $image)
                        {{ $image }}<br> <!-- Display the image path -->
                    @endforeach
                @else
                    <p>No images available for this gallery.</p>
                @endif
            @endforeach



        </div>
    </div>
@endif
