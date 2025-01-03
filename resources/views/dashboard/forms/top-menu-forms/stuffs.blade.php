<form action="{{ route('store-top-menu') }}" method="POST">
    @csrf
    @if ($stuffs->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="stuffs" id="stuffs" class="form-control" required>
                    <option value="" disabled {{ old('stuffs') == '' ? 'selected' : '' }}>
                        কর্মচারী নির্বাচন করুন
                    </option>
                    @foreach ($stuffs as $stuff)
                        <option value="{{ $stuff->id }}" {{ old('stuffs') == $stuff->id ? 'selected' : '' }}>
                            {{ $stuff->stuff_name }}
                        </option>
                    @endforeach
                </select>

                {{-- Display validation error --}}
                @error('stuffs')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">
                যুক্ত করুন
            </button>
        </div>
    @else
        {{-- Message for empty officials --}}
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন কর্মচারী উপলব্ধ নেয়।</p>
    @endif
</form>
