<form action="{{ route('store-group-menu') }}" method="POST" class="flex column gap-10">
    @csrf
    <div class="mb-3">
        <input name="group_label" type="text" placeholder="গ্রুপ এর নাম" value="{{ old('group_label') }}">
        <input name="top_menu_id" type="hidden" value="{{ $topmenu->id }}">
        @error('group_label')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">
        যুক্ত করুন
    </button>
</form>
