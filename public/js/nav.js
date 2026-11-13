// Site Width toggler
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container-1240px');
    const burder = document.querySelector('.burder');

    if (burder && container) {
        burder.addEventListener('click', () => {
            container.classList.toggle('full-width');
        });
    }

    // 1. Desktop Navigation: Ensure full-box clickability
    document.querySelectorAll('.nav-section .main-menu > li.llisting').forEach(li => {
        li.addEventListener('click', function (e) {
            // If the click is inside a dropdown submenu or mega menu, let the submenu link handle it
            if (e.target.closest('.sub-menu, .mega-menu')) {
                return;
            }
            const directLink = li.querySelector(':scope > a');
            // If click was on li padding, gap, or arrow icon (not direct <a>), trigger the link click
            if (directLink && e.target !== directLink && !directLink.contains(e.target)) {
                directLink.click();
            }
        });
    });

    // 2. Desktop Dropdowns: Smooth hover with 250ms grace period (no click interference)
    const includesSubmenus = document.querySelectorAll('.nav-section .includs-submenu');
    includesSubmenus.forEach(submenu => {
        const subMenu = submenu.querySelector('.sub-menu, .mega-menu');
        if (!subMenu) return;

        let closeTimer = null;

        const openSubmenu = () => {
            if (closeTimer) {
                clearTimeout(closeTimer);
                closeTimer = null;
            }
            subMenu.classList.add('active');
        };

        const closeSubmenu = () => {
            closeTimer = setTimeout(() => {
                subMenu.classList.remove('active');
            }, 250);
        };

        submenu.addEventListener('mouseenter', openSubmenu);
        submenu.addEventListener('mouseleave', closeSubmenu);
        subMenu.addEventListener('mouseenter', openSubmenu);
        subMenu.addEventListener('mouseleave', closeSubmenu);
    });
});

// Mobile Nav JS
jQuery(document).ready(function ($) {
    $('.mobile-menu-trigger').on('click', function () {
        $(this).toggleClass('active');
        $(this).find('.mobile-burger').toggleClass('active');
        $('.mobile-nav').stop(true, true).slideToggle(220);
    });

    // Submenu Toggle on Mobile or direct link navigation
    $('.mobile-nav .nav-toggle').on('click', function (e) {
        var currentSubmenu = $(this).next('.mob-sub-wrapper');
        if (currentSubmenu.length) {
            e.preventDefault();
            var parentItem = $(this).closest('.mob-menu-item');
            parentItem.toggleClass('open');
            currentSubmenu.stop(true, true).slideToggle(200);

            // Close all other submenus
            $('.mob-sub-wrapper').not(currentSubmenu).slideUp(200);
            $('.mob-menu-item').not(parentItem).removeClass('open');
        } else {
            // Direct item without submenu: tapping anywhere on the row opens the link
            var link = $(this).find('a').first();
            if (link.length && e.target !== link[0] && !link[0].contains(e.target)) {
                var url = link.attr('href');
                if (url && url !== '#') {
                    if (link.attr('target') === '_blank') {
                        window.open(url, '_blank');
                    } else {
                        window.location.href = url;
                    }
                }
            }
        }
    });
});
