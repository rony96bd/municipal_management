<form action="{{ isset($page) ? route('update-stuff', $page->id) : route('store-stuff') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex grid grid-col-2 m-grid-col-1 gap-20">
        <div class="mb-3">
            {{-- Name --}}
            <label for="joining_date" class="form-label">কর্মচারীর নাম</label>
            <input type="text" name="stuff_name" id="stuff_name" class="form-control"
                value="{{ old('stuff_name', isset($page) ? $page->stuff_name : '') }}" placeholder="কর্মচারীর নাম *"
                required>
            @error('stuff_name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Designation --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label">কর্মচারীর পদবী</label>
            <input type="text" name="designation" id="designation" class="form-control"
                value="{{ old('designation', isset($page) ? $page->designation : '') }}" placeholder="কর্মচারীর পদবী *"
                required>
            @error('designation')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Mobile --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label">মোবাইল নম্বর</label>
            <input type="text" name="mobile" id="mobile" class="form-control"
                value="{{ old('mobile', isset($page) ? $page->mobile : '') }}" placeholder="মোবাইল *" required>
            @error('mobile')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Email --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label">ইমেইল</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', isset($page) ? $page->email : '') }}" placeholder="ই-মেইল *">
            @error('email')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Home District --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label">নিজ জেলা</label>
            <input type="text" name="home_district" id="home_district" class="form-control"
                value="{{ old('home_district', isset($page) ? $page->home_district : '') }}" placeholder="নিজ জেলা">
            @error('home_district')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- First Joining --}}
        <div class="mb-3">
            <label for="first_joining" class="form-label">চাকুরীতে প্রথম যোগদানের তারিখ *</label>
            <input type="date" name="first_joining" id="first_joining" class="form-control"
                value="{{ old('first_joining', isset($page) && $page->first_joining ? $page->first_joining->toDateString() : '') }}"
                placeholder="চাকুরীতে প্রথম যোগদানের তারিখ" required>
            @error('first_joining')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- First Designation --}}
        <div class="mb-3">
            <label for="first_designation" class="form-label">চাকুরীতে প্রথম যোগদানের পদবী *</label>
            <input type="text" name="first_designation" id="first_designation" class="form-control"
                value="{{ old('first_designation', isset($page) ? $page->first_designation : '') }}" placeholder="চাকুরীতে প্রথম যোগদানের পদবী *"
                required>
            @error('first_designation')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- joining date --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label">বর্তমান কর্মস্থলে যোগদানের তারিখ *</label>
            <input type="date" name="joining_date" id="joining_date" class="form-control"
                value="{{ old('joining_date', isset($page) && $page->joining_date ? $page->joining_date->toDateString() : '') }}"
                placeholder="বর্তমান কর্মস্থলে যোগদানের তারিখ" required>
            @error('joining_date')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Grade --}}
        <div class="mb-3">
            <label for="grade" class="form-label">কর্মচারীর গ্রেড</label>
            <input type="number" name="grade" id="grade" class="form-control"
                value="{{ old('grade', isset($page) ? $page->grade : '') }}"
                placeholder="কর্মচারীর গ্রেড">
            @error('grade')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">প্রোফাইল ছবি আপলোড করুন</label>
            <input type="file" id="image" name="image" accept="image/*">
            <div id="image-preview-container" class="mt-2">
                @if (isset($page) && $page->image)
                    <img id="image-preview" src="{{ asset('' . $page->image) }}" alt="Uploaded Image"
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
