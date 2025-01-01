<form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="mb-3">
        <textarea name="about_institute" id="about_institute" class="form-control" rows="35"
            placeholder="পাতার তথ্য এখানে যাবে">{{ old('page_data', isset($about) ? $about->about_institute : '') }}</textarea>
        @error('about_institute')
            <small class="color-danger">{{ $message }}</small>
        @enderror
    </div>
    {{-- Submit Button --}}
    <button type="submit" class="btn btn-primary btn-span-2">
        {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
    </button>
    </div>
</form>
