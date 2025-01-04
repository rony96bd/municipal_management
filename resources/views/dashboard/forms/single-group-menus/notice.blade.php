<form action="{{ route('store-single-group-menu') }}" method="POST">
    @csrf
    @if ($notices->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="notice" id="notice" class="form-control" required>
                    <option value="" disabled {{ old('notice') == '' ? 'selected' : '' }}>
                        নোটিশ নির্বাচন করুন
                    </option>
                    @foreach ($notices as $notice)
                        <option value="{{ $notice->id }}" {{ old('notice') == $notice->id ? 'selected' : '' }}>
                            {{ $notice->topic }}
                        </option>
                    @endforeach
                </select>
                <input name="group_menu_id" type="hidden" value="{{ $groupmenu->id }}">
                {{-- Display validation error --}}
                @error('notice')
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
