document.addEventListener('DOMContentLoaded', function () {
    // Wrap wide tables in a dedicated horizontal scroll container for mobile devices
    document.querySelectorAll('.detail-content-box table').forEach(function (table) {
        if (table.closest('.table-responsive-wrap')) {
            return;
        }
        var wrapper = document.createElement('div');
        wrapper.className = 'table-responsive-wrap';

        var hint = document.createElement('div');
        hint.className = 'table-scroll-hint';
        hint.textContent = '← ডানে-বামে স্ক্রল করুন →';

        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(hint);
        wrapper.appendChild(table);
    });

    // Lightbox for clickable detail images
    var overlay = document.getElementById('detail-lightbox-overlay');
    var overlayImg = document.getElementById('detail-lightbox-image');
    if (!overlay || !overlayImg) {
        return;
    }

    var closeBtn = overlay.querySelector('.detail-lightbox-close');

    document.body.addEventListener('click', function (e) {
        var img = e.target.closest('.clickable-detail-image');
        if (img) {
            overlayImg.src = img.src;
            overlayImg.alt = img.alt || '';
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
