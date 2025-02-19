@php
    $siteSettings = \App\Models\SiteSettings::first();
@endphp
<form action="{{ route('setting-update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex column gap-10">
        {{-- Image Upload --}}
        {{-- Image Upload --}}
        <div class="site-banner-box position-relative padar-40 background-primary bradius-6px border-solid border-1px border-color-secondary"
            style="background-image: url('{{ !empty($settings->site_banner) ? asset($settings->site_banner) : asset('images/assets/hero-1.jpg') }}')">

            {{-- Site Logo Section --}}
            <div class="site-logo-prev-box position-relative z-index-2" id="site-logo-prev-box"
                style="background-image: url('{{ !empty($settings->site_logo) ? asset($settings->site_logo) : asset('images/assets/logo.png') }}')">
                <input type="file" id="site-setting" class="site-setting-image" name="site_logo" accept="image/*"
                    onchange="previewLogoImage(event)">
            </div>

            {{-- Banner Section --}}
            <div class="position-absolute full-width full-height bottom-0 right-0 padar-20 flex row jfe-aie">
                <input type="file" id="site-banner" class="site-setting-banner" name="site_banner" accept="image/*"
                    onchange="previewBannerImage(event)">
                <div class="upload-banner-img color-white flex row gap-10 banner-upload-button center"
                    onclick="triggerBannerFileInput()">
                    @include('icons.dashboard-icons.camera')
                    <p>Cover Photo</p>
                </div>
            </div>
        </div>

        {{-- @php
            $existingImage = isset($settings) && $settings->site_logo ? asset('storage/' . $settings->site_logo) : null;
        @endphp --}}

        {{-- Site Name --}}
        <div class="mb-3">
            <label for="site_name" class="form-label">Site Name *</label>
            <input type="text" name="site_name" id="site_name" class="form-control"
                value="{{ old('site_name', isset($settings) ? $settings->site_name : '') }}" placeholder="Site Name *"
                required>
        </div>

        {{-- Meta Description --}}
        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea name="meta_description" id="meta_description" class="form-control exclude-tyne" placeholder="Meta Description"
                rows="6" maxlength="150">{{ old('meta_description', isset($settings) ? $settings->meta_description : '') }}</textarea>
        </div>

        {{-- Color Fields --}}
        <div class="grid grid-col-8 m-grid-col-4 gap-20">
            <div class="mb-3">
                <label for="primary_color" class="form-label">Primary Color</label>
                <div class="color-picker" id="primary-color-picker"></div>
                <input type="hidden" name="primary_color" id="primary_color"
                    value="{{ old('primary_color', isset($settings) ? $settings->primary_color : '#000325') }}">
            </div>

            <div class="mb-3">
                <label for="secondary_color" class="form-label">Secondary Color</label>
                <div class="color-picker" id="secondary-color-picker"></div>
                <input type="hidden" name="secondary_color" id="secondary_color"
                    value="{{ old('secondary_color', isset($settings) ? $settings->secondary_color : '#3361d9') }}">
            </div>

            <div class="mb-3">
                <label for="paragraph_color" class="form-label">Paragraph Color</label>
                <div class="color-picker" id="paragraph-color-picker"></div>
                <input type="hidden" name="paragraph_color" id="paragraph_color"
                    value="{{ old('paragraph_color', isset($settings) ? $settings->paragraph_color : '#333333') }}">
            </div>

            <div class="mb-3">
                <label for="danger_color" class="form-label">Danger Color</label>
                <div class="color-picker" id="danger-color-picker"></div>
                <input type="hidden" name="danger_color" id="danger_color"
                    value="{{ old('danger_color', isset($settings) ? $settings->danger_color : '#e74c3c') }}">
            </div>

            <div class="mb-3">
                <label for="alert_color" class="form-label">Alert Color</label>
                <div class="color-picker" id="alert-color-picker"></div>
                <input type="hidden" name="alert_color" id="alert_color"
                    value="{{ old('alert_color', isset($settings) ? $settings->alert_color : '#f39c12') }}">
            </div>

            <div class="mb-3">
                <label for="success_color" class="form-label">Success Color</label>
                <div class="color-picker" id="success-color-picker"></div>
                <input type="hidden" name="success_color" id="success_color"
                    value="{{ old('success_color', isset($settings) ? $settings->success_color : '#4fff00') }}">
            </div>

            <div class="mb-3">
                <label for="warning_color" class="form-label">Warning Color</label>
                <div class="color-picker" id="warning-color-picker"></div>
                <input type="hidden" name="warning_color" id="warning_color"
                    value="{{ old('warning_color', isset($settings) ? $settings->warning_color : '#f39c12') }}">
            </div>

            <div class="mb-3">
                <label for="background_gray" class="form-label">Background Gray Color</label>
                <div class="color-picker" id="background-gray-color-picker"></div>
                <input type="hidden" name="background_gray" id="background_gray"
                    value="{{ old('background_gray', isset($settings) ? $settings->background_gray : '#f2f2f2') }}">
            </div>

        </div>

        <div class="mb-3">
            <label for="google_font" class="form-label">Site Font</label>
            <select name="google_font" id="google_font" class="form-control">
                @if (!empty($siteSettings))
                    <!-- Add other font options dynamically -->
                    <option value="{{ $siteSettings->google_font }}" selected disabled>
                        {{ $siteSettings->google_font }}
                    </option>
                @else
                    <option value="Tiro Bangla" selected disabled>Tiro Bangla</option>
                @endif
                <!-- Add more fonts as needed -->
            </select>
        </div>




        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">
            {{ isset($settings) ? 'Update' : 'Save' }}
        </button>
</form>



<script>
    // Set background for site logo (same as before)
    function previewLogoImage(event) {
        const siteLogoPrevBox = document.getElementById('site-logo-prev-box');
        const file = event.target.files[0];
        const removeButton = document.getElementById('remove-image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                siteLogoPrevBox.style.backgroundImage = `url(${e.target.result})`;
                siteLogoPrevBox.style.backgroundSize = 'cover';
                siteLogoPrevBox.style.backgroundPosition = 'center';
            };
            reader.readAsDataURL(file);
            removeButton.style.display = 'block'; // Show the remove button when an image is selected
        }
    }

    // Set background for site banner
    function previewBannerImage(event) {
        const siteBannerBox = document.querySelector('.site-banner-box');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                siteBannerBox.style.backgroundImage = `url(${e.target.result})`;
                siteBannerBox.style.backgroundSize = 'cover';
                siteBannerBox.style.backgroundPosition = 'center';
                siteBannerBox.style.backgroundRepeat = 'no-repeat';
            };
            reader.readAsDataURL(file);
        }
    }

    // Trigger file input when the banner upload button is clicked
    function triggerBannerFileInput() {
        const bannerInput = document.getElementById('site-banner');
        bannerInput.click(); // This will trigger the file input dialog
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // URL to fetch the Google Fonts list
        const googleFontsAPI =
            'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBcng4phxxZSOn-Lw8gBMD9ASsUTP3peqo';

        // Get the select field
        const fontSelect = document.getElementById('google_font');

        // Fetch the Google Fonts list
        fetch(googleFontsAPI)
            .then(response => response.json())
            .then(data => {
                const fonts = data.items;
                fonts.forEach(font => {
                    const option = document.createElement('option');
                    option.value = font.family;
                    option.textContent = font.family;
                    fontSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching Google Fonts:', error);
            });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fontSelect = document.getElementById('google_font');

        // Dynamically load the font from Google Fonts
        const fontLink = document.createElement('link');
        fontLink.href = `https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap`;
        fontLink.rel = 'stylesheet';
        document.head.appendChild(fontLink);

        // Event listener to update the font family on select change
        fontSelect.addEventListener('change', function() {
            const selectedFont = fontSelect.value;

            if (selectedFont) {
                // Apply the selected font to the body
                document.body.style.fontFamily = selectedFont;

                // Dynamically load the selected font from Google Fonts
                const fontLink = document.createElement('link');
                fontLink.href =
                    `https://fonts.googleapis.com/css2?family=${selectedFont.replace(' ', '+')}&display=swap`;
                fontLink.rel = 'stylesheet';
                document.head.appendChild(fontLink);
            }
        });
    });
</script>
