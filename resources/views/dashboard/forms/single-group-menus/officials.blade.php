<form action="{{ route('store-single-group-menu') }}" method="POST">
    @csrf
    @if ($officials->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="officials" id="officials" class="form-control" required>
                    <option value="" disabled {{ old('officials') == '' ? 'selected' : '' }}>
                        কর্মকর্তা নির্বাচন করুন
                    </option>
                    @foreach ($officials as $official)
                        <option value="{{ $official->id }}" {{ old('officials') == $official->id ? 'selected' : '' }}>
                            {{ $official->offificial_name }}
                        </option>
                    @endforeach
                </select>
                <input name="group_menu_id" type="hidden" value="{{ $groupmenu->id }}">
                {{-- Display validation error --}}
                @error('officials')
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
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন কর্মকর্তা উপলব্ধ নেয়।</p>
    @endif
</form>
