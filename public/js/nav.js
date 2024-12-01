// Site Width toggler
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container-1240px');
    const burder = document.querySelector('.burder');

    burder.addEventListener('click', () => {
        container.classList.toggle('full-width');
    });
});
