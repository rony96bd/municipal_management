// Safe Slider JS
document.addEventListener('DOMContentLoaded', () => {
    // Get the slides container
    const slides = document.querySelector('.slides');
    const slideItems = document.querySelectorAll('.slide');

    if (slides && slideItems.length > 0) {
        const totalSlides = slideItems.length;

        // Clone the first slide and append it to the end
        const firstSlide = slideItems[0].cloneNode(true);
        slides.appendChild(firstSlide);

        let currentIndex = 0;
        slideItems[currentIndex].classList.add('slider-active');

        function moveToNextSlide() {
            slideItems[currentIndex]?.classList.remove('slider-active');
            currentIndex = (currentIndex + 1) % (totalSlides + 1);
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;

            if (currentIndex === totalSlides) {
                setTimeout(() => {
                    slides.style.transition = 'none';
                    slides.style.transform = 'translateX(0)';
                    currentIndex = 0;
                    slideItems[currentIndex]?.classList.add('slider-active');
                }, 1000);
            } else {
                slides.style.transition = 'transform 1s ease-in-out';
                slideItems[currentIndex]?.classList.add('slider-active');
            }
        }

        setInterval(moveToNextSlide, 10000);
    }

    // Ticker JS for News
    const slidderWrapper = document.querySelector('.slidder-wrapper');
    const items = document.querySelectorAll('.single-slidder-item');

    if (slidderWrapper && items.length > 0) {
        const totalWidth = Array.from(items).reduce((width, item) => width + item.offsetWidth, 0);
        let duration = (totalWidth / 100) * 1;
        duration = Math.max(5, Math.min(duration, 100));

        const styleTag = document.createElement('style');
        document.head.appendChild(styleTag);
        styleTag.innerHTML = `
            .slidder-wrapper {
                animation-duration: ${duration}s !important;
            }
        `;
    }
});
