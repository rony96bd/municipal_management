// Site Width toggler
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container-1240px');
    const burder = document.querySelector('.burder');

    burder.addEventListener('click', () => {
        container.classList.toggle('full-width');
    });
});





// Select all elements with the class '.includs-submenu'
const includesSubmenus = document.querySelectorAll('.includs-submenu');
const primaryHeader = document.querySelector('.nav-section');

includesSubmenus.forEach(submenu => {
  // Select the sub-menu inside the current '.includs-submenu'
  const subMenu = submenu.querySelector('.sub-menu');

  if (subMenu) {
    // Add event listener for mouseenter (hover) on '.includs-submenu'
    submenu.addEventListener('mouseenter', function() {
      // Add 'active' class to the '.sub-menu' inside the hovered '.includs-submenu'
      subMenu.classList.add('active');
      primaryHeader.classList.add('z-index-3');
    });

    // Add event listener for mouseleave (when the hover is removed) on '.includs-submenu'
    submenu.addEventListener('mouseleave', function() {
      // Remove 'active' class from the '.sub-menu' only if mouse leaves the entire '.includs-submenu'
      setTimeout(() => {
        if (!submenu.matches(':hover') && !subMenu.matches(':hover')) {
          subMenu.classList.remove('active');
          primaryHeader.classList.remove('z-index-3');
        }
      }, 50); // Small delay to ensure the mouse has actually left the submenu
    });

    // Ensure the sub-menu stays active when hovered directly on the sub-menu
    subMenu.addEventListener('mouseenter', function() {
      subMenu.classList.add('active');
    });

    subMenu.addEventListener('mouseleave', function() {
      // Only remove 'active' if the mouse leaves the sub-menu and not the parent
      setTimeout(() => {
        if (!submenu.matches(':hover')) {
          subMenu.classList.remove('active');
        }
      }, 50);
    });
  }
});


// Mobile Nav JS
jQuery(document).ready(function($) {
    $('.mobile-burger').on('click', function() {
        $(this).toggleClass('active');

        // Toggle the related mobile-nav
        $(".mobile-nav").slideToggle("fast");
    });
});

