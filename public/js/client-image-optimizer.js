/**
 * Client-Side Image Pre-Compressor
 * Municipal Management & Attestation System
 * 
 * Automatically intercepts image file inputs, scales down photos > 2048px on an HTML5 canvas,
 * compresses to ~200-300KB print-quality JPEG before upload, dramatically accelerating form submissions.
 */
(function () {
    'use strict';

    // Configuration
    var CONFIG = {
        maxDimension: 2048,      // Max width/height (print quality 200-300 DPI on A4)
        quality: 0.82,           // Visually lossless 82% JPEG
        minSizeBytes: 250 * 1024 // Only pre-compress files larger than 250KB
    };

    function formatBytes(bytes) {
        if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(1) + ' MB';
        }
        return Math.round(bytes / 1024) + ' KB';
    }

    function isCompressibleImage(file) {
        if (!file || !file.type) return false;
        var type = file.type.toLowerCase();
        return (type === 'image/jpeg' || type === 'image/jpg' || type === 'image/png' || type === 'image/webp')
            && file.size > CONFIG.minSizeBytes;
    }

    function compressImageFile(file) {
        return new Promise(function (resolve) {
            if (!isCompressibleImage(file)) {
                return resolve(file);
            }

            // Verify Canvas and DataTransfer support
            if (!window.HTMLCanvasElement || !window.URL || !window.DataTransfer) {
                return resolve(file);
            }

            var objectUrl = URL.createObjectURL(file);
            var img = new Image();

            img.onload = function () {
                URL.revokeObjectURL(objectUrl);

                var origW = img.naturalWidth || img.width;
                var origH = img.naturalHeight || img.height;

                var targetW = origW;
                var targetH = origH;
                var maxDim = CONFIG.maxDimension;

                if (origW > maxDim || origH > maxDim) {
                    if (origW >= origH) {
                        targetW = maxDim;
                        targetH = Math.round((origH * maxDim) / origW);
                    } else {
                        targetH = maxDim;
                        targetW = Math.round((origW * maxDim) / origH);
                    }
                }

                var canvas = document.createElement('canvas');
                canvas.width = targetW;
                canvas.height = targetH;
                var ctx = canvas.getContext('2d');

                // White background for transparent PNG conversion to JPEG
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, targetW, targetH);
                ctx.drawImage(img, 0, 0, targetW, targetH);

                canvas.toBlob(function (blob) {
                    if (blob && blob.size < file.size) {
                        // Produce new compressed File
                        var newName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                        var optimizedFile = new File([blob], newName, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        optimizedFile._originalSize = file.size;
                        optimizedFile._optimizedSize = blob.size;
                        resolve(optimizedFile);
                    } else {
                        resolve(file);
                    }
                }, 'image/jpeg', CONFIG.quality);
            };

            img.onerror = function () {
                URL.revokeObjectURL(objectUrl);
                resolve(file);
            };

            img.src = objectUrl;
        });
    }

    function showStatusBadge(input, origSize, newSize) {
        if (!input || !input.parentNode) return;

        // Remove existing badge if any
        var oldBadge = input.parentNode.querySelector('.cio-badge');
        if (oldBadge) {
            oldBadge.remove();
        }

        var savedPercent = Math.round(((origSize - newSize) / origSize) * 100);
        var badge = document.createElement('div');
        badge.className = 'cio-badge';
        badge.style.cssText = 'margin-top:4px;font-size:12px;color:#0f6b3a;background:#ecfdf5;border:1px solid #a7f3d0;padding:3px 8px;border-radius:5px;display:inline-flex;align-items:center;gap:4px;';
        badge.innerHTML = '⚡ <b>সংকুচিত:</b> ' + formatBytes(origSize) + ' ➔ ' + formatBytes(newSize) + ' (' + savedPercent + '% দ্রুত আপলোড)';
        input.parentNode.appendChild(badge);
    }

    function handleFileInputChange(event) {
        var input = event.target;
        if (!input || input.type !== 'file' || !input.files || input.files.length === 0) {
            return;
        }

        // Check if input accepts images or has files to compress
        var files = Array.from(input.files);
        var hasCompressible = files.some(isCompressibleImage);
        if (!hasCompressible) {
            return;
        }

        // Find parent form submit button to prevent double-submit during quick compression
        var form = input.closest('form');
        var submitBtn = form ? form.querySelector('[type="submit"]') : null;
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.setAttribute('data-original-text', submitBtn.innerHTML);
            submitBtn.innerHTML = '⏳ ছবি অপটিমাইজ হচ্ছে...';
        }

        var compressPromises = files.map(function (file) {
            return compressImageFile(file);
        });

        Promise.all(compressPromises).then(function (compressedFiles) {
            try {
                var dt = new DataTransfer();
                var anyCompressed = false;
                var totalOrig = 0;
                var totalNew = 0;

                compressedFiles.forEach(function (f) {
                    dt.items.add(f);
                    if (f._originalSize && f._optimizedSize) {
                        anyCompressed = true;
                        totalOrig += f._originalSize;
                        totalNew += f._optimizedSize;
                    }
                });

                input.files = dt.files;

                if (anyCompressed) {
                    showStatusBadge(input, totalOrig, totalNew);
                }
            } catch (e) {
                // Ignore if DataTransfer assignment is restricted
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    var origText = submitBtn.getAttribute('data-original-text');
                    if (origText) {
                        submitBtn.innerHTML = origText;
                    }
                }
            }
        });
    }

    // Attach via event delegation on change event across whole document
    document.addEventListener('change', function (e) {
        if (e.target && e.target.type === 'file') {
            handleFileInputChange(e);
        }
    }, true);

})();
