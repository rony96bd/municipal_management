<form action="{{ isset($page) ? route('update-official', $page->id) : route('store-official') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex grid grid-col-2 m-grid-col-1 gap-20">
        <div class="mb-3">
            {{-- Name --}}
            <label for="offificial_name" class="form-label" style="color: #3E7B27">কর্মকর্তার নাম</label>
            <input type="text" name="offificial_name" id="offificial_name" class="form-control" value="{{ old('offificial_name', isset($page) ? $page->offificial_name : '') }}" placeholder="কর্মকর্তার নাম *" required>
            @error('offificial_name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Designation --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">কর্মকর্তার পদবী</label>
            <input type="text" name="designation" id="designation" class="form-control" value="{{ old('designation', isset($page) ? $page->designation : '') }}" placeholder="কর্মকর্তার পদবী *" required>
            @error('designation')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- BCS Batch --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">ব্যাচ (বি.সি.এস)</label>
            <input type="text" name="bcs" id="bcs" class="form-control"
                value="{{ old('bcs', isset($page) ? $page->bcs : '') }}" placeholder="ব্যাচ (বি.সি.এস)">
            @error('bcs')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- BCS ID --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">সার্ভিস আই.ডি</label>
            <input type="text" name="bcsid" id="bcsid" class="form-control"
                value="{{ old('bcsid', isset($page) ? $page->bcsid : '') }}" placeholder="আই.ডি">
            @error('bcsid')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- NID --}}
        <div class="mb-3">
            <label for="nid" class="form-label" style="color: #3E7B27">জাতীয় পরিচয়পত্র নম্বর</label>
            <input type="number" name="nid" id="nid" class="form-control"
                value="{{ old('nid', isset($page) ? $page->nid : '') }}" placeholder="জাতীয় পরিচয়পত্র নম্বর">
            @error('nid')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Education Qualification --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">শিক্ষাগত যোগ্যতা</label>
            <input type="text" name="edu" id="edu" class="form-control"
                value="{{ old('edu', isset($page) ? $page->edu : '') }}" placeholder="শিক্ষাগত যোগ্যতা">
            @error('edu')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Official Phone --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">ফোন (অফিস)</label>
            <input type="text" name="office_phone" id="office_phone" class="form-control"
                value="{{ old('office_phone', isset($page) ? $page->office_phone : '') }}" placeholder="ফোন (অফিস) *"
                required>
            @error('office_phone')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Official Home --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">ফোন (বাসা)</label>
            <input type="text" name="home_phone" id="home_phone" class="form-control"
                value="{{ old('home_phone', isset($page) ? $page->home_phone : '') }}" placeholder="ফোন (বাসা)">
            @error('home_phone')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Fax --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">ফ্যাক্স</label>
            <input type="text" name="fax" id="fax" class="form-control"
                value="{{ old('fax', isset($page) ? $page->fax : '') }}" placeholder="ফ্যাক্স">
            @error('fax')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Mobile --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">মোবাইল নম্বর</label>
            <input type="text" name="mobile" id="mobile" class="form-control"
                value="{{ old('mobile', isset($page) ? $page->mobile : '') }}" placeholder="মোবাইল *" required>
            @error('mobile')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Email --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">ইমেইল</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', isset($page) ? $page->email : '') }}" placeholder="ই-মেইল *" required>
            @error('email')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Home District --}}
        <div class="mb-3">
            <label for="offificial_name" class="form-label" style="color: #3E7B27">নিজ জেলা</label>
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
                value="{{ old('first_joining', isset($page) && $page->first_joining ? \Carbon\Carbon::parse($page->first_joining)->toDateString() : '') }}"
                placeholder="চাকুরীতে প্রথম যোগদানের তারিখ">
            @error('first_joining')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- PRL Date --}}
        <div class="mb-3">
            <label for="prl_date" class="form-label">চাকুরী হতে অবসরের তারিখ</label>
            <input type="date" name="prl_date" id="prl_date" class="form-control"
                value="{{ old('prl_date', isset($page) && $page->prl_date ? \Carbon\Carbon::parse($page->prl_date)->toDateString() : '') }}"
                placeholder="চাকুরী হতে অবসরের তারিখ">
            @error('prl_date')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- First Designation --}}
        <div class="mb-3">
            <label for="first_designation" class="form-label">চাকুরীতে প্রথম যোগদানের পদবী *</label>
            <input type="text" name="first_designation" id="first_designation" class="form-control"
                value="{{ old('first_designation', isset($page) ? $page->first_designation : '') }}"
                placeholder="চাকুরীতে প্রথম যোগদানের পদবী *">
            @error('first_designation')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- joining date --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label" style="color: #3E7B27">বর্তমান কর্মস্থলে যোগদানের তারিখ</label>
            <input type="date" name="joining_date" id="joining_date" class="form-control"
                value="{{ old('joining_date', isset($page) ? $page->joining_date->toDateString() : '') }}"
                placeholder="বর্তমান কর্মস্থলে যোগদানের তারিখ" required>
            @error('joining_date')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label" style="color: #3E7B27">প্রোফাইল ছবি আপলোড করুন</label>
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
