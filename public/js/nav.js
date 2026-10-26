// Site Width toggler
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container-1240px');
    const burder = document.querySelector('.burder');

    if (burder && container) {
        burder.addEventListener('click', () => {
            container.classList.toggle('full-width');
        });
    }
});

// Select all elements with the class '.includs-submenu'
const includesSubmenus = document.querySelectorAll('.includs-submenu');
const primaryHeader = document.querySelector('.nav-section');

includesSubmenus.forEach(submenu => {
    // Select the sub-menu inside the current '.includs-submenu'
    const subMenu = submenu.querySelector('.sub-menu');

    if (subMenu) {
        // Add event listener for mouseenter (hover) on '.includs-submenu'
        submenu.addEventListener('mouseenter', function () {
            subMenu.classList.add('active');
            if (primaryHeader) {
                primaryHeader.classList.add('z-index-3');
            }
        });

        // Add event listener for mouseleave (when the hover is removed) on '.includs-submenu'
        submenu.addEventListener('mouseleave', function () {
            setTimeout(() => {
                if (!submenu.matches(':hover') && !subMenu.matches(':hover')) {
                    subMenu.classList.remove('active');
                    if (primaryHeader) {
                        primaryHeader.classList.remove('z-index-3');
                    }
                }
            }, 50);
        });

        // Ensure the sub-menu stays active when hovered directly on the sub-menu
        subMenu.addEventListener('mouseenter', function () {
            subMenu.classList.add('active');
        });

        subMenu.addEventListener('mouseleave', function () {
            setTimeout(() => {
                if (!submenu.matches(':hover')) {
                    subMenu.classList.remove('active');
                }
            }, 50);
        });
    }
});

// Mobile Nav JS
jQuery(document).ready(function ($) {
    $('.mobile-menu-trigger').on('click', function () {
        $(this).toggleClass('active');
        $(this).find('.mobile-burger').toggleClass('active');
        $('.mobile-nav').stop(true, true).slideToggle(220);
    });

    // Submenu Toggle on Mobile
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
        }
    });
});

