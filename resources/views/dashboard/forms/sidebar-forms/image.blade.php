<form action="{{ route('store-sidebar') }}" method="POST" class="full-width" enctype="multipart/form-data">
    @csrf
    @if ($services->isNotEmpty())
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
    @else
        {{-- Message for empty services --}}
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন সার্ভিস উপলব্ধ নেয়।</p>
    @endif
</form>
