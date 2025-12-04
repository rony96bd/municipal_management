@extends('dashboard.templates.main')

@section('dash-body')
    <h2 class="fs-h2 marb-20">{{ $page_title }}</h2>

    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
        enctype="multipart/form-data" class="flex column gap-20">
        @csrf
        @if (isset($post))
            @method('PUT')
        @endif

        <div class="flex column gap-5">
            <label class="fs-base font-weight-bold">শিরোনাম *</label>
            <input type="text" name="title" class="input-default"
                value="{{ old('title', $post->title ?? '') }}" required>
            @error('title')
                <span class="color-danger fs-small">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex column gap-5">
            <label class="fs-base font-weight-bold">পোস্টের লেখা</label>
            <textarea name="content" rows="6" class="textarea-default">{{ old('content', $post->content ?? '') }}</textarea>
            @error('content')
                <span class="color-danger fs-small">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex column gap-5">
            <label class="fs-base font-weight-bold">ছবি (একাধিক দিতে পারবেন, ঐচ্ছিক)</label>
            <input type="file" name="images[]" accept="image/*" multiple>
            <input type="hidden" name="images_order" id="images_order">

            {{-- নতুন সিলেক্ট করা ছবির লাইভ প্রিভিউ ও অর্ডার --}}
            <div id="images-preview" class="mart-10 flex row gap-10 flex-wrap"></div>

            {{-- আগে আপলোড করা ছবি (এডিট মোডে) --}}
            @if (isset($post) && $post->images && $post->images->count())
                <div class="mart-10 flex row gap-10 flex-wrap">
                    @foreach ($post->images as $image)
                        <img src="{{ asset($image->image_path) }}" alt="Post image"
                            style="max-width: 120px; border-radius:4px;">
                    @endforeach
                </div>
            @endif

            @error('images.*')
                <span class="color-danger fs-small">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex column gap-5">
            <label class="fs-base font-weight-bold">সংযুক্ত ফাইল (PDF, ঐচ্ছিক)</label>
            <input type="file" name="attachment" accept="application/pdf">
            @if (isset($post) && $post->attachment_path)
                <div class="mart-10">
                    <a href="{{ asset($post->attachment_path) }}" target="_blank" class="color-primary">
                        বর্তমান সংযুক্ত PDF দেখুন
                    </a>
                </div>
            @endif
            @error('attachment')
                <span class="color-danger fs-small">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="background-primary color-white padt-10 padb-10 padr-30 padl-30 bradius-3px button-default-css">
                {{ isset($post) ? 'আপডেট করুন' : 'পোস্ট করুন' }}
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[name="images[]"]');
            const previewContainer = document.getElementById('images-preview');
            const orderInput = document.getElementById('images_order');

            if (!fileInput || !previewContainer || !orderInput) {
                return;
            }

            function updateOrderField() {
                const orderedNames = Array.from(previewContainer.querySelectorAll('[data-name]')).map(el =>
                    el.getAttribute('data-name')
                );
                orderInput.value = orderedNames.join(',');
            }

            function renderPreviews() {
                previewContainer.innerHTML = '';

                const files = Array.from(fileInput.files || []);
                const names = [];

                files.forEach(file => {
                    const reader = new FileReader();
                    const wrapper = document.createElement('div');
                    wrapper.className = 'image-preview-item';
                    wrapper.style.cursor = 'grab';
                    wrapper.setAttribute('data-name', file.name);

                    const img = document.createElement('img');
                    img.style.maxWidth = '120px';
                    img.style.borderRadius = '4px';
                    img.alt = file.name;

                    wrapper.appendChild(img);
                    previewContainer.appendChild(wrapper);

                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    names.push(file.name);
                });

                orderInput.value = names.join(',');

                if (window.Sortable && !previewContainer._sortable && previewContainer.children.length) {
                    previewContainer._sortable = new Sortable(previewContainer, {
                        animation: 150,
                        onEnd: updateOrderField,
                    });
                }
            }

            fileInput.addEventListener('change', renderPreviews);
        });
    </script>
@endsection
