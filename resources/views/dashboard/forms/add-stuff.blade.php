<form action="{{ isset($page) ? route('update-stuff', $page->id) : route('store-stuff') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex grid grid-col-2 m-grid-col-1 gap-20">
        <div class="mb-3">
            {{-- Name --}}
            <input type="text" name="stuff_name" id="stuff_name" class="form-control"
                value="{{ old('stuff_name', isset($page) ? $page->stuff_name : '') }}" placeholder="কর্মচারীর নাম *"
                required>
            @error('stuff_name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Designation --}}
        <div class="mb-3">
            <input type="text" name="designation" id="designation" class="form-control"
                value="{{ old('designation', isset($page) ? $page->designation : '') }}" placeholder="কর্মচারীর পদবী *"
                required>
            @error('designation')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Official Phone --}}
        <div class="mb-3">
            <input type="text" name="office_phone" id="office_phone" class="form-control"
                value="{{ old('office_phone', isset($page) ? $page->office_phone : '') }}" placeholder="ফোন (অফিস) *"
                required>
            @error('office_phone')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Official Home --}}
        <div class="mb-3">
            <input type="text" name="home_phone" id="home_phone" class="form-control"
                value="{{ old('home_phone', isset($page) ? $page->home_phone : '') }}" placeholder="ফোন (বাসা) ">
            @error('home_phone')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Mobile --}}
        <div class="mb-3">
            <input type="text" name="mobile" id="mobile" class="form-control"
                value="{{ old('mobile', isset($page) ? $page->mobile : '') }}" placeholder="মোবাইল *" required>
            @error('mobile')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Email --}}
        <div class="mb-3">
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', isset($page) ? $page->email : '') }}" placeholder="ই-মেইল *" required>
            @error('email')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Home District --}}
        <div class="mb-3">
            <input type="text" name="home_district" id="home_district" class="form-control"
                value="{{ old('home_district', isset($page) ? $page->home_district : '') }}" placeholder="নিজ জেলা">
            @error('home_district')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- joining date --}}
        <div class="mb-3">
            <input type="text" name="joining_date" id="joining_date" class="form-control"
                value="{{ old('joining_date', isset($page) ? $page->joining_date : '') }}"
                placeholder="বর্তমান কর্মস্থলে যোগদানের তারিখ">
            @error('joining_date')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Url --}}
        <div class="mb-3">
            <input type="text" name="page_url" id="page_url" class="form-control"
                value="{{ old('page_url', isset($page) ? $page->page_url : '') }}"
                placeholder="url (english and lower case only - no spacing. Example: about-us) *" required>
            @error('page_url')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">প্রোফাইল ছবি আপলোড করুন</label>
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
        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary btn-span-2">
            {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>
