<form action="{{ route('store-sidebar') }}" method="POST" class="full-width" enctype="multipart/form-data">
    @csrf
    <div class="flex column gap-10">
        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">সাইডবার ইমেজ আপলোড করুন</label>
            <input type="file" name="image" id="image" class="form-control" required>
            @error('image')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">
            আপলোড করুন
        </button>
    </div>

</form>
