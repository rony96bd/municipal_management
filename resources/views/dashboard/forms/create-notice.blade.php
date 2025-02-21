<form action="{{ isset($page) ? route('notice-update', $page->id) : route('store-notice') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('PUT')
    @endif
    <div class="flex grid grid-col-2 m-grid-col-1 gap-20">
        <div class="mb-3 grid-span-2">
            <input type="text" name="topic" id="topic" class="form-control"
                value="{{ old('topic', $page->topic ?? '') }}" placeholder="বিষয় *" required>
            @error('topic')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3 grid-span-2">
            <textarea name="description" id="description" class="form-control" rows="6" placeholder="ডেসক্রিপশন">{{ old('description', $page->description ?? '') }}</textarea>
            @error('description')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3 grid-span-2">
            <label for="file_upload" class="form-label">আপলোড করুন (PDF, DOC, CSV, Excel)</label>
            <input type="file" name="file_upload" id="file_upload" class="form-control"
                accept=".pdf, .doc, .docx, .csv, .xls, .xlsx">
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
        {{-- <div class="mb-3">
            <input type="text" name="page_url" id="page_url" class="form-control"
                value="{{ old('page_url', $page->page_url ?? '') }}"
                placeholder="url (english and lower case only - no spacing. Example: about-us)" required>
            @error('page_url')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div> --}}
        <button type="submit" class="btn btn-primary btn-span-2">
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
