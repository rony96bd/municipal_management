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
            alert.style.zIndex = '100';
        }, 3000); // Start fade-out after 3 seconds

        setTimeout(() => {
            alert.remove(); // Remove the element after 5 seconds
        }, 5000); // Remove the element after 5 seconds
    });
});


document.addEventListener("click", function (e) {
    if (e.target.closest(".copy-url")) {
        const dataLink = e.target.closest(".copy-url").getAttribute("data_link");
        navigator.clipboard.writeText(dataLink).then(() => {
            alert("Link copied to clipboard!");
        }).catch(err => console.error("Failed to copy: ", err));
    }
});


// Image Preview and Remove

document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const removeImageButton = document.createElement('button');

    if (!document.getElementById('remove-image')) {
        removeImageButton.id = 'remove-image';
        removeImageButton.className = 'btn btn-danger btn-sm mt-2';
        removeImageButton.textContent = 'Remove';
        removeImageButton.style.display = 'none';
        imagePreviewContainer.appendChild(removeImageButton);
    }

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none');
                removeImageButton.style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageButton.addEventListener('click', function () {
        imageInput.value = ''; // Clear the input
        imagePreview.src = '#';
        imagePreview.classList.add('d-none');
        this.style.display = 'none';
    });

});




document.addEventListener("DOMContentLoaded", function () {
    // Define the default and active text
    let defaultText = "কোন তথ্য নেয়"; // Default text
    let activeText = "খালি কন্টেনার ড্রাগ করা যাবে না"; // Text when active

    // Get all elements with the class 'submenu-empty'
    let submenuElements = document.querySelectorAll('.submenu-empty');

    // Loop through each element and apply event listeners
    submenuElements.forEach(function (submenu) {
        // Change text on hover (grab state)
        submenu.addEventListener('mouseenter', function () {
            submenu.textContent = activeText; // Set the active text when grabbed (hovered)
        });

        // Revert text when the mouse leaves the element
        submenu.addEventListener('mouseleave', function () {
            submenu.textContent = defaultText; // Reset to default text when not hovered
        });
    });
});




// Media Upload
document.addEventListener("DOMContentLoaded", function () {
    const mediaButton = document.querySelector('.media-button');
    const mediaForm = document.querySelector('.media-field');

    if (mediaButton && mediaForm) {
        mediaButton.addEventListener('click', function () {
            // Toggle visibility of the media form
            mediaForm.classList.toggle('display-none');

            // Optional: Change button text if needed
            if (mediaForm.classList.contains('display-none')) {
                mediaButton.textContent = "নতুন ফাইল আপলোড করুন"; // Close upload form
            } else {
                mediaButton.textContent = "ফাইল আপলোড করুন"; // Open upload form
            }
        });
    }
});


