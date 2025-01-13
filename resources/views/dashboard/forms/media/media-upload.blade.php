<form class="media-form" action="{{ route('media-store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    {{-- Image Upload --}}
    <div class="mb-3 media-field display-none marb-10">
        <p class="color-danger"><strong>নোট:</strong>সর্বোচ্চা ২ মেগাবাইট সাইজের যে কোন PDF, JPG, JPEG, PNG, PDF, DOC,
            DOCX, আপলোড করা যাবে। </p>
        <input type="file" name="file" accept=".jpg,.jpeg,.png, .pdf,.doc,.docx" required>
        @error('file')
            <small class="color-danger fs-base">{{ $message }}</small>
        @enderror
    </div>
    {{-- Submit Button --}}
    <button type="submit"
        class="media-button anchor outline-button padl-20 padr-20 padt-10 padb-10 border-solid border-1px border-color solid bradius-3px width-max-content full-width">
        নতুন ফাইল আপলোড করুন
    </button>
</form>
