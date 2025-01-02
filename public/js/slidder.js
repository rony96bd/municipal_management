// Get the slides container
const slides = document.querySelector('.slides');
// Get all individual slides
const slideItems = document.querySelectorAll('.slide');
// Set the number of slides
const totalSlides = slideItems.length;

// Clone the first slide and append it to the end
const firstSlide = slideItems[0].cloneNode(true);
slides.appendChild(firstSlide);

// Set the index for the current slide
let currentIndex = 0;

// Ensure the first slide is active on load
slideItems[currentIndex].classList.add('slider-active');

// Function to move the slider to the next slide
function moveToNextSlide() {
    // Remove the "slider-active" class from the previous slide
    slideItems[currentIndex].classList.remove('slider-active');

    // Increment the current slide index
    currentIndex = (currentIndex + 1) % (totalSlides + 1); // Loop back to the first slide (including the clone)

    // Move the slides container
    slides.style.transform = `translateX(-${currentIndex * 100}%)`;

    // Reset to the first slide after reaching the cloned slide
    if (currentIndex === totalSlides) {
        setTimeout(() => {
            slides.style.transition = 'none'; // Disable transition for the reset
            slides.style.transform = 'translateX(0)'; // Move back to the original first slide
            currentIndex = 0; // Reset the index
            slideItems[currentIndex].classList.add('slider-active'); // Reapply active class to the first slide
        }, 1000); // Wait for the transition to complete before resetting
    } else {
        slides.style.transition = 'transform 1s ease-in-out'; // Enable transition
        slideItems[currentIndex].classList.add('slider-active'); // Add the active class to the current slide
    }
}

// Set the slider to move automatically every 10 seconds
setInterval(moveToNextSlide, 10000); // Change 10000 to control the speed (in milliseconds)







// Ticker JS for News
const slidderWrapper = document.querySelector('.slidder-wrapper');
const items = document.querySelectorAll('.single-slidder-item');

// Calculate the total width of all the items combined
const totalWidth = Array.from(items).reduce((width, item) => width + item.offsetWidth, 0);

// Output the total width for debugging
console.log('Total width of all items:', totalWidth);

// Calculate the duration based on the total width of all items
// Duration will scale with the total width, but be clamped between 30s and 100s
let duration = (totalWidth / 1000) *
    10; // Adjust the formula to fit your need (e.g., dividing by 1000 to scale better)

// Ensure the duration is between 30s and 100s
duration = Math.max(30, Math.min(duration, 100)); // Clamp between 30s and 100s

// Output the calculated duration for debugging
console.log('Calculated duration:', duration);

// Create a style tag dynamically
const styleTag = document.createElement('style');
document.head.appendChild(styleTag);

// Update the animation duration dynamically in the style tag
styleTag.innerHTML = `
    .slidder-wrapper {
        animation-duration: ${duration}s !important;
    }
`;
