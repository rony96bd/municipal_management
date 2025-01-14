<form action="{{ route('store-sidebar') }}" method="POST">
    @csrf
    @if ($news->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="news" id="news" class="form-control" required>
                    <option value="" disabled {{ old('news') == '' ? 'selected' : '' }}>
                        নিউজ নির্বাচন করুন
                    </option>
                    @foreach ($news as $singlenews)
                        <option value="{{ $singlenews->id }}" {{ old('news') == $singlenews->id ? 'selected' : '' }}>
                            {{ $singlenews->topic }}
                        </option>
                    @endforeach
                </select>

                {{-- Display validation error --}}
                @error('news')
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
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন নিউজ উপলব্ধ নেয়।</p>
    @endif
</form>
