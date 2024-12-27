<form
    action="{{ isset($serviceItem) ? route('single-service-update', $serviceItem->id) : route('configure-single-service-store', $service->page_url) }}"
    method="POST">
    @csrf
    @if (isset($serviceItem))
        @method('PUT') <!-- Use PUT for updates -->
    @endif
    <div class="flex column gap-20">
        <div class="mb-3">
            <input type="text" name="service_item_name" id="service_item_name" class="form-control"
                value="{{ old('service_item_name', isset($serviceItem) ? $serviceItem->service_item_name : '') }}"
                placeholder="সেবার নাম" required>
            @error('service_item_name')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <textarea name="service_item_description" id="textarea" class="form-control" rows="6"
                placeholder="সেবার ডেসক্রিপশন">{{ old('service_item_description', isset($serviceItem) ? $serviceItem->service_item_description : '') }}</textarea>
            @error('service_item_description')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Page URL --}}
        <div class="mb-3">
            <input type="text" name="page_url" id="page_url" class="form-control"
                value="{{ old('page_url', isset($serviceItem) ? $serviceItem->page_url : '') }}"
                placeholder="url (english and lower case only - no spacing. Example: about-us)" required>
            @error('page_url')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <input type="hidden" name="service_id" id="service_id"
                value="{{ old('service_id', isset($serviceItem) ? $serviceItem->service_id : (isset($service) ? $service->service_id : '')) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($serviceItem) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>
