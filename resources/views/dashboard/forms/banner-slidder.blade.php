<form action="{{ isset($page) ? route('update-page', $page->id) : route('store-banner-slidder') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex column gap-20">
        <div class="mb-3">
            {{-- Topic --}}
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', isset($page) ? $page->title : '') }}" placeholder="স্লাইডার এর নাম *" required>
            @error('title')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">স্লাইডারের ছবি যুক্ত করুন</label>
            <input type="file" id="image" name="image" accept="image/*">
            <div id="image-preview-container" class="mt-2">
                @if (isset($page) && $page->image)
                    <img id="image-preview" src="{{ asset('uploads/' . $page->image) }}" alt="Uploaded Image"
                        class="img-thumbnail" style="width: 80px; height: 80px;">
                    <button type="button" id="remove-image" class="btn btn-danger btn-sm mt-2">Remove</button>
                @else
                    <img id="image-preview" src="#" alt="Image Preview" class="img-thumbnail d-none"
                        style="width: 80px; height: 80px;">
                @endif
            </div>
            @error('image')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>
