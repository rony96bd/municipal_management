<form action="{{ isset($page) ? route('update-page', $page->id) : route('store-page') }}" method="POST">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex column gap-20">
        <div class="mb-3">
            <input type="text" name="page_name" id="page_name" class="form-control"
                value="{{ old('page_name', isset($page) ? $page->page_name : '') }}" placeholder="পাতার নাম" required>
            @error('page_name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <input type="text" name="page_url" id="page_url" class="form-control"
                value="{{ old('page_url', isset($page) ? $page->page_url : '') }}"
                placeholder="url (english and lower case only - no spacing. Example: about-us)" required>
            @error('page_url')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <textarea name="page_data" id="textarea" class="form-control" rows="20" placeholder="পাতার তথ্য এখানে যাবে">{{ old('page_data', isset($page) ? $page->page_data : '') }}</textarea>
            @error('page_data')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>
