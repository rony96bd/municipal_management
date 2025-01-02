<form action="{{ route('store-sidebar') }}" method="POST">
    @csrf
    @if ($notices->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="noice" id="noice" class="form-control" required>
                    <option value="" disabled {{ old('noice') == '' ? 'selected' : '' }}>
                        নোটিশ নির্বাচন করুন
                    </option>
                    @foreach ($notices as $notice)
                        <option value="{{ $notice->id }}" {{ old('noice') == $notice->id ? 'selected' : '' }}>
                            {{ $notice->topic }}
                        </option>
                    @endforeach
                </select>

                {{-- Display validation error --}}
                @error('noice')
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
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন নোটিশ উপলব্ধ নেয়।</p>
    @endif
</form>
