<form action="{{ isset($service) ? route('update-service', $service->service_id) : route('store-service') }}"
    method="POST">
    @csrf
    @if (isset($service))
        @method('POST') <!-- Use method spoofing for PUT if needed -->
    @endif
    <div class="flex column gap-20">
        <div class="mb-3">
            <input type="text" name="service_name" id="service_name" class="form-control"
                value="{{ old('service_name', isset($service) ? $service->service_name : '') }}" placeholder="সেবার নাম"
                required>
            @error('service_name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <textarea name="service_description" id="textarea" class="form-control exclude-tyne" rows="6"
                placeholder="সেবার ডেসক্রিপশন">{{ old('service_description', isset($service) ? $service->service_description : '') }}</textarea>
            @error('service_description')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        {{-- Url --}}
        <div class="mb-3">
            <input type="text" name="page_url" id="page_url" class="form-control"
                value="{{ old('page_url', isset($service) ? $service->page_url : '') }}"
                placeholder="url (english and lower case only - no spacing. Example: about-us) *" required>
            @error('page_url')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>
