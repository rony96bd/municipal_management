<form action="{{ route('add-simple-submenu') }}" method="POST" class="full-width">
    @csrf
    @if ($services->isNotEmpty())
        {{-- Dropdown Selection --}}
        <div class="flex column gap-10">
            <div class="mb-3">
                {{-- Name --}}
                <input type="text" name="link_text" id="link_text" class="form-control" value="{{ old('link_text') }}"
                    placeholder="লিঙ্ক টেক্সট *" required>
                @error('link_text')
                    <small class="color-danger fs-base">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                {{-- Name --}}
                <input type="url" name="link_url" id="link_url" class="form-control" value="{{ old('link_url') }}"
                    placeholder="লিঙ্ক">
                @error('link_url')
                    <small class="color-danger fs-base">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                {{-- Tab Option --}}
                <select name="tab" id="tab" class="form-control" required>
                    <option value="1" {{ old('tab') == '1' ? 'selected' : '' }}>একই ট্যাবে ওপেন করুন</option>
                    <option value="2" {{ old('tab') == '2' ? 'selected' : '' }}>ভিন্ন ট্যাবে ওপেন করুন</option>
                </select>
                @error('tab')
                    <small class="color-danger fs-base">{{ $message }}</small>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">
                নাম যুক্ত করুন
            </button>
        </div>
    @else
        {{-- Message for empty services --}}
        <p class="font-weight-bold color-danger fs-18-22">সাইডবারে যুক্ত করার জন্য কোন সার্ভিস উপলব্ধ নেয়।</p>
    @endif
</form>
