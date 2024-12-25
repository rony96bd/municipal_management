<form action="{{ isset($page) ? route('update-representative', $page->id) : route('store-representative') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex grid grid-col-2 m-grid-col-1 gap-20">
        <div class="mb-3">
            {{-- Name --}}
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', isset($page) ? $page->name : '') }}" placeholder="জনপ্রতিনিধীর নাম *" required>
            @error('name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Designation --}}
        <div class="mb-3">
            <select name="designation" id="designation" class="form-control" required>
                <option value="" disabled
                    {{ old('designation', isset($page) ? $page->designation : '') == '' ? 'selected' : '' }}>
                    পদবী নির্বাচন করুন *
                </option>
                <option value="1"
                    {{ old('designation', isset($page) ? $page->designation : '') == '1' ? 'selected' : '' }}>
                    চেয়ারম্যান
                </option>
                <option value="2"
                    {{ old('designation', isset($page) ? $page->designation : '') == '2' ? 'selected' : '' }}>
                    মেম্বার
                </option>
                <option value="3"
                    {{ old('designation', isset($page) ? $page->designation : '') == '3' ? 'selected' : '' }}>
                    মেম্বার(মহিলা)
                </option>
            </select>
            @error('designation')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Word Number --}}
        <div class="mb-3">
            <input type="number" name="word_number" id="word_number" class="form-control"
                value="{{ old('word_number', isset($page) ? $page->word_number : '') }}" placeholder="ওয়ার্ড নাম্বার">
            @error('word_number')
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
        {{-- Fax --}}
        <div class="mb-3">
            <input type="text" name="fax" id="fax" class="form-control"
                value="{{ old('fax', isset($page) ? $page->fax : '') }}" placeholder="ফ্যাক্স">
            @error('fax')
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

        {{-- Joining Date --}}
        <div class="mb-3">
            <input type="date" name="joining_date" id="joining_date" class="form-control"
                value="{{ old('joining_date', isset($page) ? $page->joining_date : '') }}" placeholder="Joining Date"
                required>
            @error('joining_date')
                <small class="color-danger">{{ $message }}</small>
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
        {{-- Elected Type --}}
        <div class="mb-3">
            <select name="elected_type" id="elected_type" class="form-control">
                <option value="" disabled
                    {{ old('elected_type', isset($page) ? $page->elected_type : '') == '' ? 'selected' : '' }}>
                    যে ভাবে নির্বাচিত হয়েছে তা নির্বাচন করুন
                </option>
                <option value="1"
                    {{ old('elected_type', isset($page) ? $page->elected_type : '') == '1' ? 'selected' : '' }}>
                    নির্বাচনের মাধ্যমে িনির্বাচিত
                </option>
                <option value="2"
                    {{ old('elected_type', isset($page) ? $page->elected_type : '') == '2' ? 'selected' : '' }}>
                    সংরক্ষিত আসনে নির্বাচিত
                </option>
                <option value="3"
                    {{ old('elected_type', isset($page) ? $page->elected_type : '') == '3' ? 'selected' : '' }}>
                    অনান্য
                </option>
            </select>
            @error('elected_type')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Present Address --}}
        <div class="mb-3">
            <textarea name="presentaddress" id="presentaddress" class="form-control" placeholder="বর্তমান ঠিকানা">{{ old('presentaddress', isset($page) ? $page->presentaddress : '') }}</textarea>
            @error('presentaddress')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        {{-- Permanent Address --}}
        <div class="mb-3">
            <textarea name="permanentaddress" id="permanentaddress" class="form-control" placeholder="স্থায়ী ঠিকানা">{{ old('permanentaddress', isset($page) ? $page->presentaddress : '') }}</textarea>
            @error('permanentaddress')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        {{-- Image Upload --}}
        <div class="mb-3 btn-span-2">
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
