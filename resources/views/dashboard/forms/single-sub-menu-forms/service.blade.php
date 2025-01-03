<form action="{{ route('add-simple-submenu') }}" method="POST">
    @csrf
    @if ($services->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                <select name="service" id="service" class="form-control" required>
                    <option value="" disabled {{ old('service') == '' ? 'selected' : '' }}>
                        সার্ভিস নির্বাচন করুন
                    </option>
                    @foreach ($services as $service)
                        <option value="{{ $service->service_id }}"
                            {{ old('service') == $service->service_id ? 'selected' : '' }}>
                            {{ $service->service_item_name }}
                        </option>
                    @endforeach
                </select>
                <input name="top_menu_id" type="hidden" value="{{ $topmenu->id }}">
                {{-- Display validation error --}}
                @error('service')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">
                যুক্ত করুন
            </button>
        </div>
    @else
        {{-- Message for empty services --}}
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন সার্ভিস উপলব্ধ নেয়।</p>
    @endif
</form>
