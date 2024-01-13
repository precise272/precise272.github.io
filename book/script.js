// script.js
document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    const totalPages = document.querySelectorAll('.page').length;

    function goToPage(pageNumber) {
        if (pageNumber >= 1 && pageNumber <= totalPages) {
            currentPage = pageNumber;
            updateBook();
        }
    }

    function updateBook() {
        const book = document.getElementById('book');
        const offsetX = (currentPage - 1) * -100;
        book.style.transform = `translateX(${offsetX}%)`;

        document.querySelectorAll('.page').forEach(function(page, index) {
            page.classList.toggle('active', index + 1 === currentPage);
        });
    }

    function makeDecision() {
        nextPage();
    }

    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            updateBook();
        }
    }

    document.querySelectorAll('.page button').forEach(function(button) {
        button.addEventListener('click', function() {
            makeDecision();
        });
    });

    // Display only the cover page initially
    updateBook();
});
