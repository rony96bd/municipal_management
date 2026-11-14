<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script src="{{ asset('js/client-image-optimizer.js') }}?v={{ file_exists(public_path('js/client-image-optimizer.js')) ? filemtime(public_path('js/client-image-optimizer.js')) : '2.0' }}"></script>
    <script src="https://cdn.tiny.cloud/1/w5vu2tz4pnqfzczmcofjbcky17ok19mug2ek9jmeozezjzjt/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        window.MunicipalImageOptimizer = window.MunicipalImageOptimizer || {};

        const EDITOR_UPLOAD_URL = '{{ route('editor.image.upload') }}';
        const EDITOR_CSRF_TOKEN = '{{ csrf_token() }}';

        async function uploadEditorImageSafely(file, progress) {
            let fileToUpload = file;
            if (window.MunicipalImageOptimizer && typeof window.MunicipalImageOptimizer.compressImageFile === 'function') {
                try {
                    fileToUpload = await window.MunicipalImageOptimizer.compressImageFile(file, file.name || 'editor_image.jpg');
                } catch (e) {
                    console.warn('Canvas pre-compression failed, using raw file:', e);
                }
            }

            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', EDITOR_UPLOAD_URL, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', EDITOR_CSRF_TOKEN);
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.onprogress = function (e) {
                    if (typeof progress === 'function' && e.lengthComputable) {
                        progress((e.loaded / e.total) * 100);
                    }
                };

                xhr.onload = function () {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject({ message: 'HTTP Error ' + xhr.status + ': ' + (xhr.statusText || 'Upload failed'), remove: true });
                        return;
                    }

                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location !== 'string') {
                            reject({ message: 'সার্ভার থেকে সঠিক ইমেজ লিঙ্ক পাওয়া যায়নি।', remove: true });
                            return;
                        }
                        resolve(json.location);
                    } catch (err) {
                        reject({ message: 'সার্ভার রেসপন্স পার্স করতে সমস্যা হয়েছে।', remove: true });
                    }
                };

                xhr.onerror = function () {
                    reject({ message: 'নেটওয়ার্ক সমস্যার কারণে ইমেজ আপলোড ব্যর্থ হয়েছে।', remove: true });
                };

                const formData = new FormData();
                formData.append('file', fileToUpload, fileToUpload.name || 'editor_image.jpg');
                xhr.send(formData);
            });
        }

        tinymce.init({
            selector: 'textarea:not(.exclude-tyne)',
            plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media',
                'searchreplace', 'table', 'visualblocks', 'wordcount',
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            automatic_uploads: true,
            paste_data_images: true,
            images_file_types: 'jpg,jpeg,png,gif,webp',
            file_picker_types: 'image',
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            images_upload_handler: (blobInfo, progress) => {
                if (window.MunicipalImageOptimizer && typeof window.MunicipalImageOptimizer.tinymceUploadHandler === 'function') {
                    return window.MunicipalImageOptimizer.tinymceUploadHandler(
                        blobInfo,
                        progress,
                        EDITOR_UPLOAD_URL,
                        EDITOR_CSRF_TOKEN
                    );
                }
                const rawBlob = blobInfo.blob();
                const fileName = blobInfo.filename ? blobInfo.filename() : 'editor_image.jpg';
                const file = new File([rawBlob], fileName, {
                    type: rawBlob.type || 'image/jpeg',
                    lastModified: Date.now(),
                });
                return uploadEditorImageSafely(file, progress);
            },
            file_picker_callback: (callback, value, meta) => {
                if (window.MunicipalImageOptimizer && typeof window.MunicipalImageOptimizer.tinymceFilePicker === 'function') {
                    return window.MunicipalImageOptimizer.tinymceFilePicker(
                        callback,
                        value,
                        meta,
                        EDITOR_UPLOAD_URL,
                        EDITOR_CSRF_TOKEN
                    );
                }

                if (meta && meta.filetype && meta.filetype !== 'image') {
                    return;
                }

                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/jpeg,image/png,image/webp,image/gif');

                input.addEventListener('change', async function () {
                    const file = input.files && input.files[0];
                    if (!file) {
                        return;
                    }
                    try {
                        const locationUrl = await uploadEditorImageSafely(file);
                        callback(locationUrl, { title: file.name, alt: file.name.replace(/\.[^/.]+$/, '') });
                    } catch (err) {
                        const msg = (err && err.message) ? err.message : err;
                        alert('ইমেজ আপলোড করতে সমস্যা হয়েছে: ' + msg);
                    }
                });

                input.click();
            },
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                'See docs to implement AI Assistant')),
        });
    </script>
    @include('css-js-loaders.load-css')

    <title>
        @if (empty($page_title))
            ড্যাশবোর্ড - পৌরসভা ম্যানেজমেন্ট সিস্টেম - ফরায়েজী ক্রিয়েটিভ এজেন্সি
        @else
            {{ $page_title }} - আলমডাঙ্গা পৌরসভা
        @endif
    </title>
</head>

<body>
    <main class="dashboard-body flex column gap-0">
        {{-- Dashboard Top Nav --}}
        @include('dashboard.templates.top-nav')
        {{-- Dashboard Left Nav and Main Box --}}
        <div class="flex row jst-ast dashmain-wrapper flex-auto">
            {{-- Sidebar Nav --}}
            @include('dashboard.templates.sidebar-nav')
            {{-- Dashboard Dom Conent Area --}}
            <div class="dash-main-area padar-20 flex-auto">
                {{-- All Content of Dashboard will be shownhere --}}
