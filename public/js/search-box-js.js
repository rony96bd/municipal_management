document.addEventListener('DOMContentLoaded', () => {
    const searchButton = document.querySelector('.search');
    const searchClose = document.querySelector('.close-search');
    const searchFormBox = document.querySelector('.search-form-box');
    const body = document.body;

    // Function to add classes
    function openSearchForm() {
        searchFormBox.classList.add('active');
        body.classList.add('no-scrolling');
    }

    // Function to remove classes
    function closeSearchForm() {
        searchFormBox.classList.remove('active');
        body.classList.remove('no-scrolling');
    }

    // Open search form
    if (searchButton) {
        searchButton.addEventListener('click', function () {
            openSearchForm();
        });
    }

    // Close search form using close button
    if (searchClose) {
        searchClose.addEventListener('click', function () {
            closeSearchForm();
        });
    }

    // Close search form when clicking on the searchFormBox but not on its child elements
    if (searchFormBox) {
        searchFormBox.addEventListener('click', function (event) {
            if (event.target === searchFormBox) {
                closeSearchForm();
            }
        });
    }

    // Close search form with Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && searchFormBox.classList.contains('active')) {
            closeSearchForm();
        }
    });
});
