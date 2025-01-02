<form action="{{ route('store-sidebar') }}" method="POST" class="full-width">
    @csrf
    @if ($services->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                {{-- Name --}}
                <input type="text" name="sidebar_title" id="sidebar_title" class="form-control"
                    value="{{ old('sidebar_title') }}" placeholder="সাইডবারের নাম *" required>
                @error('offificial_name')
                    <small class="color-danger fs-base">{{ $message }}</small>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">
                নাম যুক্ত করুন
            </button>
        </div>
    @else
        {{-- Message for empty services --}}
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন সার্ভিস উপলব্ধ নেয়।</p>
    @endif
</form>
