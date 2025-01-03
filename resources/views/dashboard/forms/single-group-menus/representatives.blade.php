<form action="{{ route('add-simple-submenu') }}" method="POST">
    @csrf
    @if ($representatives->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="representatives" id="representatives" class="form-control" required>
                    <option value="" disabled {{ old('representatives') == '' ? 'selected' : '' }}>
                        জনপ্রতিনিধি নির্বাচন করুন
                    </option>
                    @foreach ($representatives as $representative)
                        <option value="{{ $representative->id }}"
                            {{ old('representatives') == $representative->id ? 'selected' : '' }}>
                            {{ $representative->name }}
                        </option>
                    @endforeach
                </select>
                <input name="top_menu_id" type="hidden" value="{{ $topmenu->id }}">
                {{-- Display validation error --}}
                @error('representatives')
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
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন প্রনপ্রতিনিধি উপলব্ধ নেয়।</p>
    @endif
</form>
