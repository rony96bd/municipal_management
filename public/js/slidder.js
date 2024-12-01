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
    }, 1000); // Wait for the transition to complete before resetting
  } else {
    slides.style.transition = 'transform 1s ease-in-out'; // Enable transition
  }

  // Add the "slider-active" class to the current active slide
  slideItems[currentIndex].classList.add('slider-active');
}

// Set the slider to move automatically every 3 seconds
setInterval(moveToNextSlide, 10000); // Change 3000 to control the speed (in milliseconds)
