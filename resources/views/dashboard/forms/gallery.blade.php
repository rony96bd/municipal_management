<form action="{{ isset($page) ? route('notice-update', $page->id) : route('store-gallery') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($page))
        @method('PUT')
    @endif
    <div class="flex grid grid-col-2 m-grid-col-1 gap-20">
        <!-- Topic Input -->
        <div class="mb-3 grid-span-2">
            <input type="text" name="topic" id="topic" class="form-control"
                value="{{ old('topic', $page->topic ?? '') }}" placeholder="বিষয় *" required>
            @error('topic')
                <small class="color-danger fs-base">{{ $message }}</small>
            @enderror
        </div>

        <!-- Description Input -->
        <div class="mb-3 grid-span-2">
            <textarea name="description" id="description" class="form-control" rows="6" placeholder="ডেসক্রিপশন">{{ old('description', $page->description ?? '') }}</textarea>
            @error('description')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>
        {{-- Url --}}
        <div class="mb-3">
            <input type="text" name="page_url" id="page_url" class="form-control"
                value="{{ old('page_url', isset($page) ? $page->page_url : '') }}"
                placeholder="url (english and lower case only - no spacing. Example: about-us) *" required>
            @error('page_url')
                <small class="color-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Multiple Image Upload -->
        <div class="mb-3 grid-span-2">
            <label for="images" class="form-label">Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
            <div id="image-preview-container" class="flex row gap-10 mart-20">
                <!-- Previews will be displayed here -->
            </div>
        </div>


        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-span-2">
            {{ isset($page) ? 'আপডেট করুন' : 'প্রকাশ করুন' }}
        </button>
    </div>
</form>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const imagesInput = document.getElementById("images");
        const previewContainer = document.getElementById("image-preview-container");

        imagesInput.addEventListener("change", (event) => {
            // Clear existing previews
            previewContainer.innerHTML = "";

            Array.from(event.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    // Create preview element
                    const preview = document.createElement("div");
                    preview.classList.add("image-preview");

                    preview.innerHTML = `
                    <img src="${e.target.result}" alt="Image Preview" class="preview-image" />
                    <button type="button" class="remove-image" data-index="${index}">&times;</button>
                `;
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        });

        previewContainer.addEventListener("click", (event) => {
            if (event.target.classList.contains("remove-image")) {
                const index = event.target.dataset.index;
                const files = Array.from(imagesInput.files);
                files.splice(index, 1);

                // Recreate FileList
                const dataTransfer = new DataTransfer();
                files.forEach((file) => dataTransfer.items.add(file));
                imagesInput.files = dataTransfer.files;

                // Remove preview
                event.target.parentElement.remove();
            }
        });
    });
</script>

<style>
    .image-preview {
        position: relative;
        display: inline-block;
        margin-right: 10px;
    }

    .preview-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #ff0000;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 14px;
        line-height: 18px;
        cursor: pointer;
    }
</style>
