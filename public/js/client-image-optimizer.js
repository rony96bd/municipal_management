/**
 * Lightweight Client-Side Canvas Pre-Compression for Image Attachments & TinyMCE Editor.
 * Compresses large images (>300KB) in the browser down to ~200-300KB (<=2048px, 82% quality)
 * before form submission or TinyMCE upload/paste so upload speed is up to 10x faster.
 */
(function () {
    'use strict';

    if (window.MunicipalImageOptimizer) {
        return;
    }

    const CONFIG = {
        maxDimension: 2048,
        targetQuality: 0.82,
        minSizeToCompress: 300 * 1024, // 300 KB
        compressibleTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
    };

    const MAX_DIMENSION = CONFIG.maxDimension;
    const TARGET_QUALITY = CONFIG.targetQuality;
    const MIN_SIZE_TO_COMPRESS = CONFIG.minSizeToCompress;
    const COMPRESSIBLE_TYPES = CONFIG.compressibleTypes;

    /**
     * Compress a single image File or Blob using an off-screen HTML5 Canvas (HTMLCanvasElement).
     *
     * @param {File|Blob} file
     * @param {string} [fallbackName]
     * @returns {Promise<File>}
     */
    function compressImageFile(file, fallbackName) {
        return new Promise((resolve) => {
            const fileName = file.name || fallbackName || ('editor_image_' + Date.now() + '.jpg');
            const mimeType = (file.type || 'image/jpeg').toLowerCase();

            if (!file || !COMPRESSIBLE_TYPES.includes(mimeType)) {
                resolve(file instanceof File ? file : new File([file], fileName, { type: mimeType || 'image/jpeg' }));
                return;
            }

            // Skip small JPEGs/WebPs that are already <= 300KB, but always compress pasted PNGs > 150KB
            const threshold = mimeType === 'image/png' ? 150 * 1024 : MIN_SIZE_TO_COMPRESS;
            if (file.size <= threshold) {
                resolve(file instanceof File ? file : new File([file], fileName, { type: mimeType }));
                return;
            }

            const img = new Image();
            const objectUrl = URL.createObjectURL(file);

            img.onload = function () {
                URL.revokeObjectURL(objectUrl);

                let width = img.naturalWidth || img.width;
                let height = img.naturalHeight || img.height;

                if (width <= 0 || height <= 0) {
                    resolve(file instanceof File ? file : new File([file], fileName, { type: mimeType }));
                    return;
                }

                // Scale down proportionally if exceeding MAX_DIMENSION
                if (width > MAX_DIMENSION || height > MAX_DIMENSION) {
                    const ratio = Math.min(MAX_DIMENSION / width, MAX_DIMENSION / height);
                    width = Math.max(1, Math.round(width * ratio));
                    height = Math.max(1, Math.round(height * ratio));
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                if (!ctx) {
                    resolve(file instanceof File ? file : new File([file], fileName, { type: mimeType }));
                    return;
                }

                // Convert large PNG screenshots/pastes or JPEGs to high-efficiency JPEG/WebP
                // (For PNGs without transparency need in photos/scans, JPEG at 82% reduces 4MB -> 220KB)
                const outputMime = (mimeType === 'image/webp') ? 'image/webp' : 'image/jpeg';
                if (outputMime === 'image/jpeg') {
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(0, 0, width, height);
                }

                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(
                    function (blob) {
                        // Release canvas memory immediately
                        canvas.width = 1;
                        canvas.height = 1;

                        if (!blob || blob.size >= file.size) {
                            resolve(file instanceof File ? file : new File([file], fileName, { type: mimeType }));
                            return;
                        }

                        const baseName = fileName.replace(/\.[^/.]+$/, '');
                        const ext = outputMime === 'image/webp' ? '.webp' : '.jpg';
                        const compressedFile = new File([blob], baseName + ext, {
                            type: outputMime,
                            lastModified: Date.now(),
                        });

                        resolve(compressedFile);
                    },
                    outputMime,
                    TARGET_QUALITY
                );
            };

            img.onerror = function () {
                URL.revokeObjectURL(objectUrl);
                resolve(file instanceof File ? file : new File([file], fileName, { type: mimeType }));
            };

            img.src = objectUrl;
        });
    }

    /**
     * Upload a (pre-compressed) image File/Blob to the backend TinyMCE upload endpoint.
     *
     * @param {File|Blob} file
     * @param {string} uploadUrl
     * @param {string} csrfToken
     * @param {Function} [progress]
     * @returns {Promise<string>} Resolves with the uploaded image URL
     */
    async function uploadEditorImage(file, uploadUrl, csrfToken, progress) {
        const compressedFile = await compressImageFile(file, file.name || 'pasted_image.jpg');

        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', uploadUrl, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.upload.onprogress = function (e) {
                if (typeof progress === 'function' && e.lengthComputable) {
                    progress((e.loaded / e.total) * 100);
                }
            };

            xhr.onload = function () {
                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                try {
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location !== 'string') {
                        reject('Invalid response from server.');
                        return;
                    }
                    resolve(json.location);
                } catch (err) {
                    reject('Failed to parse upload response.');
                }
            };

            xhr.onerror = function () {
                reject('Image upload failed due to a network error.');
            };

            const formData = new FormData();
            formData.append('file', compressedFile, compressedFile.name);
            xhr.send(formData);
        });
    }

    /**
     * TinyMCE 7 images_upload_handler: triggers automatically when an image is pasted,
     * dragged-and-dropped, or uploaded from the Image -> Upload tab.
     */
    function tinymceUploadHandler(blobInfo, progress, uploadUrl, csrfToken) {
        const rawBlob = blobInfo.blob();
        const fileName = blobInfo.filename ? blobInfo.filename() : 'editor_image.jpg';
        const file = new File([rawBlob], fileName, {
            type: rawBlob.type || 'image/jpeg',
            lastModified: Date.now(),
        });

        return uploadEditorImage(file, uploadUrl, csrfToken, progress);
    }

    /**
     * TinyMCE 7 file_picker_callback: adds a direct local computer file browse button
     * inside the Insert/Edit Image dialog.
     */
    function tinymceFilePicker(callback, value, meta, uploadUrl, csrfToken) {
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
                const locationUrl = await uploadEditorImage(file, uploadUrl, csrfToken);
                callback(locationUrl, { title: file.name, alt: file.name.replace(/\.[^/.]+$/, '') });
            } catch (err) {
                alert('ইমেজ আপলোড করতে সমস্যা হয়েছে: ' + err);
            }
        });

        input.click();
    }

    /**
     * Handle change event on any file input to pre-compress selected images sequentially.
     *
     * @param {Event} event
     */
    async function handleFileInputChange(event) {
        const input = event.target;
        if (!input || input.tagName !== 'INPUT' || input.type !== 'file') {
            return;
        }
        if (input.dataset.compressing === 'true' || !input.files || input.files.length === 0) {
            return;
        }
        if (typeof DataTransfer === 'undefined') {
            return;
        }

        const originalFiles = Array.from(input.files);
        const hasCompressibleImage = originalFiles.some(
            (f) => COMPRESSIBLE_TYPES.includes((f.type || '').toLowerCase()) && f.size > MIN_SIZE_TO_COMPRESS
        );

        if (!hasCompressibleImage) {
            return;
        }

        input.dataset.compressing = 'true';
        const submitButtons = input.form
            ? Array.from(input.form.querySelectorAll('button[type="submit"], input[type="submit"]'))
            : [];

        submitButtons.forEach((btn) => {
            btn.dataset.wasDisabled = btn.disabled ? 'true' : 'false';
            btn.disabled = true;
        });

        try {
            const dataTransfer = new DataTransfer();
            for (let i = 0; i < originalFiles.length; i++) {
                const compressed = await compressImageFile(originalFiles[i]);
                dataTransfer.items.add(compressed);
            }
            input.files = dataTransfer.files;
        } catch (e) {
            // Fail open: keep original files so server-side ImageOptimizer handles it
            console.warn('Client-side image pre-compression skipped:', e);
        } finally {
            delete input.dataset.compressing;
            submitButtons.forEach((btn) => {
                if (btn.dataset.wasDisabled === 'false') {
                    btn.disabled = false;
                }
                delete btn.dataset.wasDisabled;
            });
        }
    }

    // Export global helper for TinyMCE & custom scripts
    window.MunicipalImageOptimizer = {
        compressImageFile: compressImageFile,
        uploadEditorImage: uploadEditorImage,
        tinymceUploadHandler: tinymceUploadHandler,
        tinymceFilePicker: tinymceFilePicker,
    };

    document.addEventListener('change', handleFileInputChange, true);
})();
