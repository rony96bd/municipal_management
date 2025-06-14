<style>
    /* Styling for the file upload section */
    #file_upload {
        width: 100%;
        margin-bottom: 10px;
    }

    /* Container for the buttons */
    .file-buttons {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 10px;
    }

    /* Style the "View File" button */
    .view-file-btn {
        display: inline-block;
        padding: 8px 15px;
        background-color: #17a2b8;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .view-file-btn:hover {
        background-color: #138496;
    }

    /* Style the "Delete File" button */
    .delete-file-btn {
        padding: 8px 15px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .delete-file-btn:hover {
        background-color: #c82333;
    }

    /* Make the delete form display properly */
    .delete-form {
        margin: 0;
    }

    /* Make the buttons responsive on smaller screens */
    @media (max-width: 768px) {
        .file-buttons {
            flex-direction: column;
            align-items: flex-start;
        }

        .view-file-btn,
        .delete-file-btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
<form action="{{ isset($page) ? route('update-page', $page->id) : route('store-page') }}" method="POST"
    enctype="multipart/form-data">
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
                    <div class="file-buttons">
                        <a href="{{ asset($page->file_path) }}" target="_blank"
                            class="btn btn-info view-file-btn">বর্তমান ফাইল দেখুন</a>
                        <form class="delete-form" action="{{ route('pages.delete-attestment', $page->id) }}"
                            method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');"
                            style="display:flex;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-file-btn">
                                ফাইল মুছে ফেলুন
                            </button>
                        </form>
                    </div>
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
