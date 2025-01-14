<form action="{{ route('store-sidebar') }}" method="POST" class="full-width">
    @csrf
    {{-- Dropdown Selection --}}
    <div class="flex column gap-10">
        <div class="mb-3">
            <input type="hidden" name="gap" id="gap" value="true">
            {{-- Display validation error --}}
            @error('service')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">
            গ্যাপ যুক্ত করুন
        </button>
    </div>
</form>
