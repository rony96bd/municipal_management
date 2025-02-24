<form action="{{ isset($page) ? route('update-page', $page->id) : route('store-page') }}" method="POST" enctype="multipart/form-data">
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

        <div class="mb-3 grid-span-2">
            <label for="file_upload" class="form-label">আপলোড করুন (PDF, DOC, CSV, Excel)</label>
            <input type="file" name="file_upload" id="file_upload" class="form-control"
                accept=".pdf, .doc, .docx, .csv, .xls, .xlsx, .jpg, .jpeg, .png">
            @if (isset($page) && $page->file_path)
                <div class="mt-2" id="attachment-section">
                    <a href="{{ asset($page->file_path) }}" target="_blank" class="btn btn-info">বর্তমান ফাইল দেখুন</a>
                    <button type="button" class="btn btn-danger" id="delete-attachment-btn"
                        data-id="{{ $page->id }}">ফাইল মুছে ফেলুন</button>
                </div>
            @endif

            @error('file_upload')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>

@if (isset($page) && $page->file_path)
    <form class="mart-20" action="{{ route('delete-attestment', $page->id) }}" method="POST"
        onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');" style="display:flex;">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="background-danger button-default-css color-white padt-10 padb-10 padr-20 padl-20 text-center bradius-3px full-width">
            ডিলিট করুন
        </button>
    </form>
@endif
