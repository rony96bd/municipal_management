<form action="{{ route('store-top-menu') }}" method="POST">
    @csrf
    {{-- Dropdown Selection --}}
    <div class="flex column gap-10">
        <div class="mb-3">
            <select name="static_page" id="static_page" class="form-control" required>
                <option value="" ‍selected disabled {{ old('static_page') == '' ? 'selected' : '' }}>
                    স্ট্যাটিক পেজ নির্বাচন করুন
                </option>
                <option value="1" {{ old('static_page') == '1' ? 'selected' : '' }}>
                    প্রথম পাতা
                </option>
                <option value="2" {{ old('static_page') == '2' ? 'selected' : '' }}>
                    কর্মকর্তা লিস্ট পাতা
                </option>
                <option value="3" {{ old('static_page') == '3' ? 'selected' : '' }}>
                    কর্মচারী লিস্ট পাতা
                </option>
                <option value="4" {{ old('static_page') == '4' ? 'selected' : '' }}>
                    জনপ্রতিনিধি লিস্ট পাতা
                </option>
                <option value="5" {{ old('static_page') == '5' ? 'selected' : '' }}>
                    সকল সার্ভিস পাতা
                </option>
                <option value="6" {{ old('static_page') == '6' ? 'selected' : '' }}>
                    সকল নোটিশ পাতা
                </option>
                <option value="7" {{ old('static_page') == '7' ? 'selected' : '' }}>
                    সকল নিউজ পাতা
                </option>
                <option value="8" {{ old('static_page') == '8' ? 'selected' : '' }}>
                    ফটো গ্যালারী
                </option>
            </select>
            {{-- Display validation error --}}
            @error('static_page')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">
            যুক্ত করুন
        </button>
    </div>
</form>
