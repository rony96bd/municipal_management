<form action="{{ route('store-sidebar') }}" method="POST" class="full-width">
    @csrf
    {{-- Dropdown Selection --}}
    <div class="flex column gap-10">
        <div class="mb-3">
            {{-- Name --}}
            <input type="text" name="sidebar_title" id="sidebar_title" class="form-control"
                value="{{ old('sidebar_title') }}" placeholder="সাইডবারের নাম *" required>
            @error('sidebar_title')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">
            নাম যুক্ত করুন
        </button>
    </div>
</form>
