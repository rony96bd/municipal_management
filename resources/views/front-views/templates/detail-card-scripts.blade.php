<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Clean up empty blocks (containing only &nbsp; or whitespace) that cause huge white gaps
    document.querySelectorAll('.detail-content-box p, .detail-content-box div').forEach(function (el) {
        if (!el.querySelector('img, table, iframe, video, audio, form, input, button') &&
            el.textContent.replace(/[\s\u00a0\u200b\uFEFF]/g, '') === '') {
            el.style.display = 'none';
        }
    });

    // 2. Wrap wide tables in a dedicated horizontal scroll container for mobile devices
    document.querySelectorAll('.detail-content-box table').forEach(function (table) {
        if (table.closest('.table-responsive-wrap')) {
            return;
        }
        var wrapper = document.createElement('div');
        wrapper.className = 'table-responsive-wrap';

        var hint = document.createElement('div');
        hint.className = 'table-scroll-hint';
        hint.textContent = '← ডানে-বামে স্ক্রল করে সম্পূর্ণ ছক দেখুন →';

        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(hint);
        wrapper.appendChild(table);
    });

    // 3. Mark content-box images as clickable if not already marked
    document.querySelectorAll('.detail-content-box img').forEach(function (img) {
        img.classList.add('clickable-detail-image');
        if (!img.title) {
            img.title = 'ক্লিক করে বড় আকারে দেখুন';
        }
    });

    // 4. Lightbox overlay for zoomable images
    var overlay = document.getElementById('detail-lightbox-overlay');
    var overlayImg = document.getElementById('detail-lightbox-image');
    if (!overlay || !overlayImg) {
        return;
    }

    var closeBtn = overlay.querySelector('.detail-lightbox-close');

    document.body.addEventListener('click', function (e) {
        var img = e.target.closest('.clickable-detail-image, .detail-content-box img');
        if (img && img.src) {
            overlayImg.src = img.src;
            overlayImg.alt = img.alt || 'বড় আকারের ছবি';
            overlay.classList.add('active');
        }
    });

    function closeOverlay() {
        overlay.classList.remove('active');
        overlayImg.src = '';
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeOverlay);
    }

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) {
            closeOverlay();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeOverlay();
        }
    });
});
</script>
