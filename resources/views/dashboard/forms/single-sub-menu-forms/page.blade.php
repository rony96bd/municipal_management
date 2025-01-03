<form action="{{ route('add-simple-submenu') }}" method="POST">
    @csrf
    @if ($pages->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="page" id="page" class="form-control" required>
                    <option value="" disabled {{ old('page') == '' ? 'selected' : '' }}>
                        পেজ নির্বাচন করুন
                    </option>
                    @foreach ($pages as $page)
                        <option value="{{ $page->id }}" {{ old('page') == $page->id ? 'selected' : '' }}>
                            {{ $page->page_name }}
                        </option>
                    @endforeach
                </select>
                <input name="top_menu_id" type="hidden" value="{{ $topmenu->id }}">
                {{-- Display validation error --}}
                @error('page')
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
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন পেজ উপলব্ধ নেয়।</p>
    @endif
</form>
