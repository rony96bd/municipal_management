document.addEventListener('DOMContentLoaded', () => {
    const dashboardPower = document.querySelector('.dash-power');
    const powerBox = document.querySelector('.profile-action');
    const menuToggler = document.querySelector('.collapse-menu');
    const dashMenuLeft = document.querySelector('.dash-left-nav-box');

    // Power Button Action
    if (dashboardPower && powerBox) {
        dashboardPower.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent event from reaching the document listener
            powerBox.classList.toggle('display-none');
            powerBox.classList.toggle('flex');
        });

        powerBox.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent event from reaching the document listener
        });

        // Close on click outside
        document.addEventListener('click', () => {
            if (powerBox.classList.contains('flex')) {
                powerBox.classList.remove('flex');
                powerBox.classList.add('display-none');
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && powerBox.classList.contains('flex')) {
                powerBox.classList.remove('flex');
                powerBox.classList.add('display-none');
            }
        });
    }

    // Load the state from localStorage
    if (dashMenuLeft && localStorage.getItem('dashMenuCollapsed') === 'true') {
        dashMenuLeft.classList.add('collapsed');
    }

    // Toggle Menu width and save the state in localStorage
    if (menuToggler && dashMenuLeft) {
        menuToggler.addEventListener('click', function () {
            dashMenuLeft.classList.toggle('collapsed');
            localStorage.setItem('dashMenuCollapsed', dashMenuLeft.classList.contains('collapsed'));
        });
    }
});




document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.sidebar-nav'); // Adjust selector to target your links inside .sidebar-nav

    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active-menu');
        }
    });
});



document.addEventListener('DOMContentLoaded', function () {
    // Select all elements with the class .alert
    const alerts = document.querySelectorAll('.alert');

    // Loop through each alert and set a timer to fade out and remove it
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 2s ease'; // Smooth fade-out over 2 seconds
            alert.style.opacity = '0'; // Set opacity to 0 after 3 seconds
        }, 3000); // Start fade-out after 3 seconds

        setTimeout(() => {
            alert.remove(); // Remove the element after 5 seconds
        }, 5000); // Remove the element after 5 seconds
    });
});
