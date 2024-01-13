<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.28.0/cytoscape.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }

        .content {
            padding: 20px;
        }

.add-choice-btn {
    margin-left: 10px;
}
#flowchartSection {
  margin-top: 20px;
  padding: 20px;
  border: 1px solid #ccc;
}

#flowchartContainer {
  width: 100%;
  height: 400px; /* Adjust the height as needed */
  border: 1px solid #ddd;
}

    </style>
<script>
// Define constants for URLs
const FETCH_SELECTED_BOOK_URL = '/book/admin-portal/books/fetch-selected-book.php';
const FETCH_SELECTED_BOOK_PREFERENCES_URL = '/book/admin-portal/books/fetch-selected-book-preferences.php';
const FETCH_SELECTED_BOOK_CHAPTERS_URL = '/book/admin-portal/books/fetch-selected-book-chapters.php';
const FETCH_SELECTED_BOOK_PAGES_URL = '/book/admin-portal/books/fetch-selected-book-pages.php';
const SCRIPT_PATH_URL = '/book/admin-portal/books/';
function loadContent(section) {
        // Hide all sections
        $('#home, #userManagement, #newsManagement, #bookManagement').hide();

        // Load content based on the clicked link
        switch (section) {
            case 'home':
                $('#home').show();
                break;
            case 'user-management':
                $('#userManagement').show();
                break;
            case 'news-management':
                $('#newsManagement').show();
                break;
            case 'book-management':
                $('#bookManagement').show();
                break;
            default:
                break;
        }
    }

//////////////////////////////BOOK MANAGEMENT/////////////////////////////////////////////
// Declare selectedBookId as a global variable
// Global variable for choice counter
var choiceCounter = 0;
var selectedBookId;
var selectedPageId;
var amountOfChoices; 
var selectedChapterId;
 // Load books full details //
function loadBookData(bookId) {
        // Load book details
        fetchSelectedBook(bookId)
            .then((bookDetails) => {
                clearBookDetailsTable();
                displayBookDetails(bookDetails);
                showBookDetailsSection();
            })
            .catch((error) => {
                console.error('Error loading book details:', error);
            });

        // Load book preferences
        fetchSelectedBookPreferences(bookId)
            .then((bookPreferences) => {
                clearBookPreferencesTable();
                displayBookPreferences(bookPreferences);
            })
            .catch((error) => {
                console.error('Error loading book preferences:', error);
            });

        // Load book chapters
        fetchSelectedBookChapters(bookId)
            .then((bookChapters) => {
                //clearBookChaptersTable();
                displayBookChapters(bookChapters, bookId);
            })
            .catch((error) => {
                console.error('Error loading book chapters:', error);
            });

        // Load book pages (assuming you have a chapterId available)
        // Adjust this according to your application logic
       // var chapterId = getSelectedChapterId();  // Replace with your logic
       //
    }

function loadPagesForChapter(bookId, chapterId) {
    fetchSelectedBookPages(bookId, chapterId)
        .then(function (pages) {
            displayPages(pages, chapterId);
        })
        .catch(function (error) {
            console.error('Error fetching pages:', error);
        });
}

// Fetch and display the list of books
function fetchBookList() {
    var endpoint = '/book/admin-portal/books/fetch-books.php';

    $.ajax({
        url: endpoint,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
			console.log('Received data:', data);
            clearBookListTable();
            data.forEach(function (book) {
                appendBookListRow(book);
            });
        },
        error: function (error) {
            console.error('Error fetching book list:', error);
        }
    });
}

// Function to clear the book list table
function clearBookListTable() {
    $('#bookListTable tbody').empty();
}

// Function to append a row to the book list table
function appendBookListRow(book) {
    var row = $("<tr>");
    row.append("<td><input type='radio' name='bookRadio' data-book-id='" + book.book_id + "'></td>");
    row.append("<td>" + book.book_id + "</td>");
    row.append("<td>" + book.title + "</td>");
    row.append("<td>" + book.author + "</td>");
    row.append("<td>" + book.year + "</td>");
    row.append("<td>" + book.description + "</td>");
    row.append("<td>" + book.image_url + "</td>");
    row.append("<td>" + book.video_url + "</td>");
    row.append("<td>" + (book.deleted ? 'Yes' : 'No') + "</td>");
    row.append("<td>" + (book.live ? 'Yes' : 'No') + "</td>");

    $("#bookListTable tbody").append(row);
}

// Function to refresh the book list
function refreshBookList() {
    fetchBookList();
}

// Helper function to get form data for a new book
function getNewBookFormData() {
    return {
        title: $("#title").val(),
        author: $("#author").val(),
        year: $("#year").val(),
        description: $("#description").val(),
        image_url: $("#image_url").val(),
        video_url: $("#video_url").val()
    };
}

// Helper function to handle the response after saving a new book
function handleNewBookSaveResponse(response) {
    if (response && response.message && response.message.includes("successfully")) {
        clearNewBookForm();
        hideNewBookModal();
        refreshBookList();
        alert("Success: " + response.message);
        logBookDetails(response.bookDetails);
    } else {
        alert("Error saving new book: " + (response.error || "Unknown error"));
    }
}

// Helper function to handle errors after saving a new book
function handleNewBookSaveError(error) {
    console.error('Error saving new book:', error);
    alert("Error saving new book. Please try again.");
}

// Function to select a book
function selectBook() {
    var selectedRadio = $('input[name="bookRadio"]:checked');

    if (selectedRadio.length > 0) {
        var bookId = selectedRadio.data('book-id');

        showEditSections(bookId);
    } else {
        alert("Please select a book.");
    }
}

// Create new book form
function showCreateBookForm() {
    // Clear the form fields when opening the modal
    $("#createBookForm")[0].reset();

    // Show the modal
    $("#createBookModal").modal("show");
}

// Function to Save new book
function saveNewBook() {
    // Get the form data
    var formData = {
        title: $("#title").val(),
        author: $("#author").val(),
        year: $("#year").val(),
        description: $("#description").val(),
        image_url: $("#image_url").val(),
        video_url: $("#video_url").val()
        // Add more fields as needed
    };

    // Make an AJAX request to save the new book
    $.ajax({
        url: '/book/admin-portal/books/add-book.php', // Corrected endpoint
        method: 'POST',
        dataType: 'json',
        data: formData,
        success: function (response) {
            // Handle the server response
            handleSaveNewBookResponse(response);
        },
        error: function (error) {
            console.error('Error saving new book:', error);
            alert("Error saving new book. Please try again.");
        }
    });
}

// Create a consistent function for handling the response after saving a new book
function handleSaveNewBookResponse(response) {
    if (response && response.message && response.message.includes("successfully")) {
        // Clear the form values
        $("#createBookForm")[0].reset();

        // Close the modal
        $("#createBookModal").modal("hide");

        // Refresh the book list
        refreshBookList();

        // Display success alert
        alert("Success: " + response.message);

        // Optionally, you can handle the book details here if needed
        var bookDetails = response.bookDetails;
        console.log("Book Details:", bookDetails);
    } else {
        // Display an error message or handle the error accordingly
        alert("Error saving new book: " + (response.error || "Unknown error"));
    }
}

// Function to clear the new book form
function clearNewBookForm() {
    $("#createBookForm")[0].reset();
}

// Function to show the new book modal
function showNewBookModal() {
    $("#createBookModal").modal("show");
}

// Function to show Edit sections
function showEditSections(bookId) {
    hideBookListSection();
    showSections(['bookDetailsSection', 'bookPreferencesSection', 'chapterListSection']);
    loadBookDetails(bookId);
    loadBookPreferences(bookId);
    loadChaptersList(bookId);
    
}

// Function to hide book list section
function hideBookListSection() {
    $('#bookListSection').hide();
}

// Function to show specific sections
function showSections(sectionIds) {
    sectionIds.forEach(function (sectionId) {
        $('#' + sectionId).show();
    });
}

// Function to load book details for editing
function loadBookDetails(bookId) {
    fetchSelectedBook(bookId)
        .then((bookDetails) => {
            // Update the selectedBookId after the AJAX call is complete
            selectedBookId = bookId;

            clearBookDetailsTable();
            displayBookDetails(bookDetails);
            showBookDetailsSection();
        })
        .catch((error) => {
            console.error('Error loading book details:', error);
        });
}

// Load Book Preferences For Editing
function loadBookPreferences(bookId) {
     fetchSelectedBookPreferences(bookId)
        .then((bookPreferences) => {
            clearBookPreferencesTable();
            displayBookPreferences(bookPreferences);
        })
        .catch((error) => {
            console.error('Error loading book details:', error);
        });

}

// Function to fetch selected book details from the server
function fetchSelectedBook(bookId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/book/admin-portal/books/fetch-selected-book.php',
            method: 'GET',
            data: { book_id: bookId },
            dataType: 'json',
            success: function (bookDetails) {
                resolve(bookDetails);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

// Function to fetch selected book preferences from the server
function fetchSelectedBookPreferences(bookId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/book/admin-portal/books/fetch-selected-book-preferences.php',
            method: 'GET',
            data: { book_id: bookId },
            dataType: 'json',
            success: function (bookPreferences) {
                resolve(bookPreferences);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

//////CHAPTERS///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

// Function to add collapsible div for chapter details
function addChapterDetailsCollapse(chapter) {
    // Create a collapse div for each chapter
    var collapseDiv = '<div class="collapse" id="chapterCollapse_' + chapter.chapter_id + '">' +
        '<div class="card card-body">' +
        // Add any additional chapter details or form elements here
        'Author: ' + chapter.author + '<br>' +
        'Year: ' + chapter.year + '<br>' +
        'Description: ' + chapter.description +
        '</div>' +
        '</div>';

    // Append the collapse div to the container
    $('#collapseChapters').append(collapseDiv);
}


// Function to fetch selected book chapters from the server
function fetchSelectedBookChapters(bookId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/book/admin-portal/books/fetch-selected-book-chapters.php',
            method: 'GET',
            data: { book_id: bookId },
            dataType: 'json',
            success: function (bookChapters) {
                resolve(bookChapters);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

 // Function to display chapters in the list
    async function displayChaptersList(bookChapters) {
        // Clear existing chapters list
        $('#chaptersContainer').empty();

        // Iterate through chapters and append card for each chapter to the container
        for (let index = 0; index < bookChapters.length; index++) {
            const bookChapter = bookChapters[index];

            // Create a card for each chapter
            var chapterCard = '<div class="card">' +
                '<div class="card-header">' +
                '<a class="btn btn-link chapter-link" data-bs-toggle="collapse" href="#chapterCollapse' + bookChapter.chapter_id + '" data-chapter-id="' + bookChapter.chapter_id + '">' +
                'Chapter: ' + bookChapter.chapter_number +
                '</a>' +
                '<button class="btn btn-primary" onclick="openEditChapterModal(' + bookChapter.chapter_id + ')">Edit Chapter</button>' +
                '<button class="btn btn-danger" onclick="deleteChapter(' + bookChapter.chapter_id + ')">Delete Chapter</button>' + 
                '<button class="btn btn-success" id="addNewPageBtn" onclick="openNewPageModal(' + bookChapter.chapter_id + ');">Add Page</button>' + 
                '</div>' +
                '<div id="chapterCollapse' + bookChapter.chapter_id + '" class="collapse" data-parent="#chaptersContainer">' +
                '<div class="card-body">' +
                // List of pages and choices for Chapter
                '<ul id="pagesAndChoicesList' + bookChapter.chapter_id + '" class="list-group">' +
                '</ul>' +
                '</div>' +
                '</div>' +
                '</div>';

            // Append the chapter card to the container
            $('#chaptersContainer').append(chapterCard);
        }

        // Event listener for collapse event
        $('.chapter-link').on('click', async function () {
            var chapterId = $(this).data('chapter-id');

            // Ensure that both selectedBookId and chapterId are defined
            if (selectedBookId && chapterId) {
                try {
                    // Fetch and display pages for the current chapter
                    const pages = await fetchSelectedBookPages(selectedBookId, chapterId);
                    displayPagesInAccordion(chapterId, pages);
                } catch (error) {
                    console.error('Error fetching pages:', error);
                }
            } else {
                console.error('selectedBookId or chapterId is not defined.');
            }
        });
    }

////PAGES//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

// Function to display pages in the accordion
function displayPagesInAccordion(chapterId, pages) {
    var pagesList = $('#pagesAndChoicesList' + chapterId);
    pagesList.empty();

    if (pages && pages.length > 0) {
        // Append each page to the list
        $.each(pages, function (index, page) {
            // Construct the HTML for each page with an expandable textarea, input fields, a save button, and an "Add Choice" button
            var pageItem = '<li class="list-group-item">' +
                '<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#pageCollapse' + page.page_id + '" aria-expanded="false" aria-controls="pageCollapse' + page.page_id + '">' +
                'Page Id: ' + page.page_id + ' : ' + ' Choice Id: ' + page.choice_id + '</button>' +
                // Add hidden input for chapter_id
                '<input type="hidden" id="chapterIdInput' + page.page_id + '" value="' + chapterId + '">' +
                '<div class="btn-group ms-auto">' +
                '<button class="btn btn-danger delete-page-btn" data-page-id="' + page.page_id + '" data-chapter-id="' + chapterId + '">Delete Page</button>' +
                '</div>' +
                '</li>';

            pagesList.append(pageItem);

            // Create a collapse for each page with an expandable textarea, input fields, a save button, and a placeholder for choices
            var pageCollapse = '<div class="collapse" id="pageCollapse' + page.page_id + '">' +
                '<div class="card card-body">' +
                'Content: <textarea id="contentInput' + page.page_id + '" class="form-control" rows="4">' + page.content + '</textarea><br>' +
                'Choices: <ul id="choicesList' + page.page_id + '" class="list-group"></ul>' +
                '<button class="btn btn-success" onclick="savePageChanges(' + page.page_id + ',' + page.chapterId + ')">Save Changes</button>' +
                '</div>' +
                '</div>';

            pagesList.append(pageCollapse);

           // Load choices for the current page
loadChoicesForPage(page.book_id, chapterId, page.page_id, function(choices, pageId, chapterId) {
    displayChoices(choices, pageId, chapterId, choices.length);
});
        });
    } else {
        pagesList.append('<li class="list-group-item">No pages available for this chapter.</li>');
    }
}

// Function to open the "Add New Page" modal
function openAddPageModal(chapterId) {
    var nextPageNumber = getNextPageNumber(chapterId);
    $('#newPageNumber').val(nextPageNumber);
    $('#addPageModal').modal('show');
}

// Function to get the next page number
function getNextPageNumber(chapterId) {
    // Add your logic to determine the next page number (e.g., based on existing pages for the chapter)
    // For simplicity, incrementing the highest existing page number by 1
    var highestPageNumber = 0;

    $('#pagesAndChoicesList' + chapterId).find('li').each(function () {
        var pageNumberMatch = $(this).text().match(/Page: (\d+)/);
        if (pageNumberMatch) {
            var pageNumber = parseInt(pageNumberMatch[1], 10);
            if (!isNaN(pageNumber) && pageNumber > highestPageNumber) {
                highestPageNumber = pageNumber;
            }
        }
    });

    return highestPageNumber + 1;
}

// Function to save a new page after creating a new choice
function saveNewPage(bookId, chapterId, pageId, choiceId, choiceText) {
    console.log('Received in saveNewPage:', { bookId, chapterId, pageId, choiceId }); // Log the received values

    // Send an AJAX request to save the new page
    $.ajax({
        url: '/book/admin-portal/books/add-pages.php',
        type: 'POST',
        dataType: 'json',
        data: {
            book_id: bookId,
            chapter_id: chapterId,
            page_number: pageId, // Change to page_number
            content: 'New Page Content', // You can set your default content here
            choice_id: choiceId  // Add the choice_id parameter
        },
        success: function (response) {
            // Display success or error message
            if (response.error) {
                console.error('Error saving new page:', response.error);
                // Log additional details about the request
                console.log('Request details:', {
                    book_id: bookId,
                    chapter_id: chapterId,
                    page_number: pageId,
                    content: 'New Page Content', // You can set your default content here
                    choice_id: choiceId  // Add the choice_id parameter
                });

                // Display error alert
                alert('Error saving new page: ' + response.error);
            } else {
                console.log('New page saved successfully:', response.message);

                // Optionally, you can perform additional actions after saving the new page

                // Display success alert
                alert('New page saved successfully!');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
            // Log additional details about the request
            console.log('Request details:', {
                book_id: bookId,
                chapter_id: chapterId,
                page_number: pageId,
                content: 'New Page Content', // You can set your default content here
                choice_id: choiceId  // Add the choice_id parameter
            });

            // Display error alert
            alert('Error saving new page. Please try again.');
        }
    });
}


// Function to save changes for a page
function savePageChanges(pageId, chapterId) {
    // Get the content from the textarea
    var content = $('#contentInput' + pageId).val();

    // Send an AJAX request to save the changes
    $.ajax({
        url: '/book/admin-portal/books/edit-page.php',
        type: 'POST',
        dataType: 'json',
        data: {
            page_id: pageId,
            chapter_id: chapterId,
            content: content
        },
        success: function (response) {
            // Display success or error message
            if (response.error) {
                console.error('Error saving changes:', response.error);
            } else {
                console.log('Changes saved successfully:', response.message);
            }
        },
        error: function (error) {
            console.error('Error saving changes:', error);
        }
    });
}

// Function to fetch selected book pages from the server
function fetchSelectedBookPages(selectedBookId, chapterId, selectedPageId) {
    console.log('fetchSelectedBookPages function: Fetching book pages with the following parameters:');
    //console.log('Selected Page ID:', selectedPageId);

    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/book/admin-portal/books/fetch-selected-book-pages.php',
            method: 'GET',
            data: { book_id: selectedBookId, chapter_id: chapterId, page_id: selectedPageId },
            dataType: 'json',
            success: function (bookPages) {
                console.log('Received Book Pages:', bookPages);
                resolve(bookPages);
            },
            error: function (error) {
                console.error('Error fetching book pages:', error);
                reject(error);
            }
        });
    });
}


// Function to load pages for all chapters
function loadPagesForAllChapters(selectedBookId, chapters) {
    // Assuming you have a variable to store the selected page ID
    selectedPageId;

    // Iterate through chapters and fetch pages for each chapter
    $.each(chapters, function (index, chapter) {
        fetchSelectedBookPages(selectedBookId, chapter.chapter_id, selectedPageId)
            .then(function (pages) {
                console.log('Fetched pages for chapter ' + chapter.chapter_id + ':', pages);

                // Use a template to generate HTML for each page
                var pageItemTemplate = '<li>' +
                    'Page ID: {{page_id}}, ' +
                    'Page Number: {{page_number}}, ' +
                    'Content: {{content}}, ' +
                    'Choices: {{choices}}' +
                    '</li>';

                // Display pages for the current chapter
                displayPages(pages, chapter.chapter_id, pageItemTemplate, selectedPageId);
            })
            .catch(function (error) {
                console.error('Error fetching pages:', error);
            });
    });
}

// Function to fetch page details from the server
function fetchPageDetails(bookId, chapterId, pageId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/book/admin-portal/books/fetch-selected-book-pages.php',
            method: 'GET',
            data: { book_id: bookId, chapter_id: chapterId, page_id: pageId },  // Using bookId, chapterId, and pageId
            dataType: 'json',
            success: function (pageDetails) {
                resolve(pageDetails);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}


// Function to clear the book details table
function clearBookDetailsTable() {
    $('#bookDetailsTableBody').empty();
}

// Function to clear the book details table
function clearBookPreferencesTable() {
    $('#bookPreferencesTableBody').empty();
}

// Function to display book details in the editable table
function displayBookDetails(bookDetails) {
    // Check if book details are not null or undefined
    if (bookDetails !== null && bookDetails !== undefined) {
        // Iterate through book details and append columns to the row
        $.each(bookDetails, function (key, value) {
            // Exclude the book_id field from being displayed
            if (key !== 'book_id') {
                // Create input fields for editing
                var inputField;
                var inputId = key; // Generate a unique ID for each input field

                if (key === 'book_size') {
                    // Create a dropdown for Book Size
                    inputField = '<select class="form-control" id="' + inputId + '" name="' + key + '">' +
                        '<option value="Small">Small</option>' +
                        '<option value="Normal">Normal</option>' +
                        '<option value="Large">Large</option>' +
                        '</select>';
                } else {
                    inputField = '<input type="text" class="form-control" id="' + inputId + '" value="' + value + '" name="' + key + '">';
                }

                // Create a row for book details with input fields
                var detailsRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';
                // Append the row to the table
                $('#bookDetailsTableBody').append(detailsRow);
            }

            // Update the hidden input field with the book ID
            $('#bookDetailsBookId').val(bookDetails.book_id);
        });
    } else {
        console.error('Received null or undefined book details from the server.');
    }
}

// Function to display book details in the editable table
function displayBookPreferences(bookPreferences) {
    // Check if book details are not null or undefined
    if (bookPreferences !== null && bookPreferences !== undefined) {
        // Iterate through book details and append columns to the row
        $.each(bookPreferences, function (key, value) {
            // Exclude the book_id field from being displayed
            if (key !== 'book_id') {
                // Create input fields for editing
                var inputField;
                var inputId = key; // Generate a unique ID for each input field

                if (key === 'book_size') {
                    // Create a dropdown for Book Size
                    inputField = '<select class="form-control" id="' + inputId + '" name="' + key + '">' +
                        '<option value="Small">Small</option>' +
                        '<option value="Normal">Normal</option>' +
                        '<option value="Large">Large</option>' +
                        '</select>';
                } else {
                    inputField = '<input type="text" class="form-control" id="' + inputId + '" value="' + value + '" name="' + key + '">';
                }

                // Create a row for book Preferences with input fields
                var preferencesRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';
                // Append the row to the table
                $('#bookPreferencesTableBody').append(preferencesRow);
            }

            // Update the hidden input field with the book ID
            $('#bookPreferencesBookId').val(bookPreferences.book_id);
        });
    } else {
        console.error('Received null or undefined book Preferences from the server.');
    }
}

// Function to show the book details section
function showBookDetailsSection() {
    $('#bookListSection').hide();
    $('#bookDetailsSection').show();
}

// Function to save edited book details
function saveEditedBookDetails() {
    // Fetch the book ID from the hidden input field
    var bookId = $('#bookDetailsBookId').val();

    // Prepare data for the AJAX request
    var formData = $('#editBookDetailsForm').serialize();

    // Send AJAX request to save edited book details
    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-details.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            handleSaveResponse(response);
        },
        error: function (error) {
            console.error('Error saving book details:', error);
            alert('An error occurred while saving book details. Please try again.');
        }
    });
}

// Function to handle the response after saving book details
function handleSaveResponse(response) {
    if (response && response.message) {
        // Display a success message
        alert(response.message);
        // Optionally, you can refresh the book list or perform other actions
    } else if (response && response.error) {
        // Display an error message
        alert('Error: ' + response.error);
    } else {
        // Display a generic error message
        alert('An unknown error occurred while saving book details.');
    }
}

// Function to save edited book preferences
function saveEditedBookPreferences() {
    var formData = $('#editBookPreferencesForm').serialize();
    console.log('Form Data:', formData);

    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-preferences.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response && response.message) {
                alert(response.message);
            } else if (response && response.error) {
                alert('Error: ' + response.error);
            } else {
                alert('An unknown error occurred while saving book preferences.');
            }
        },
        error: function (error) {
            console.error('Error saving book preferences:', error);
            alert('An error occurred while saving book preferences. Please try again.');
        }
    });
	  // Prevent the default form submission
    return false;
}

// Function to save edited book chapters
function saveEditedBookChapters() {
    var formData = $('#editBookChaptersForm').serialize();
    console.log('Form Data:', formData);

    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-chapters.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            handleSaveEditedDataResponse(response);
        },
        error: function (error) {
            handleSaveEditedDataError(error);
        }
    });

    // Prevent the default form submission
    return false;
}
    
    // Function to save the new chapter
function saveNewChapter() {
    var newChapterNumber = $('#newChapterNumber').val();
    var newStoryline = $('#newStoryline').val();
    var newAffinityRequirement = $('#newAffinityRequirement').val();

    // Perform an AJAX request to save the new chapter to the database
    $.ajax({
        url: '/book/admin-portal/books/save-new-chapter.php',
        method: 'POST',
        data: {
            book_id: $('#bookChaptersBookId').val(),
            chapter_number: newChapterNumber,
            storyline: newStoryline,
            affinity_requirement: newAffinityRequirement
        },
        dataType: 'json',
        success: function (response) {
            if (response && response.message) {
                console.log(response.message);

                // Update the book chapters table on success
                refreshBookChaptersList();

                // Close the modal
                $('#addChapterModal').modal('hide');
            } else if (response && response.error) {
                console.error('Error: ' + response.error);
            } else {
                console.error('An unknown error occurred while saving the new chapter.');
            }
        },
        error: function (error) {
            console.error('Error saving new chapter:', error);
        }
    });
}

 // Function to open the "Add New Chapter" modal
    function openAddChapterModal() {
        var nextChapterNumber = getNextChapterNumber();
        $('#newChapterNumber').val(nextChapterNumber);
        $('#addChapterModal').modal('show');
    }

    // Function to get the next chapter number
    function getNextChapterNumber() {
        // Add your logic to determine the next chapter number (e.g., based on existing chapters)
        // For simplicity, incrementing the highest existing chapter number by 1
        var highestChapterNumber = 0;

        $('#bookChaptersTableBody').find('input[name="chapter_number[]"]').each(function () {
            var chapterNumber = parseInt($(this).val(), 10);
            if (!isNaN(chapterNumber) && chapterNumber > highestChapterNumber) {
                highestChapterNumber = chapterNumber;
            }
        });

        return highestChapterNumber + 1;
    }

    // Function to refresh the book chapters list
function refreshBookChaptersList() {
    // Clear the existing rows in the table
    $('#bookChaptersTableBody').empty();

    // Fetch and display the updated chapters
    var bookId = $('#bookChaptersBookId').val();
    fetchSelectedBookChapters(bookId)
        .then(function (bookChapters) {
            // Display the updated chapters
            displayBookChapters(bookChapters);
        })
        .catch(function (error) {
            console.error('Error fetching book chapters:', error);
        });
}

// Function to save common data for edited book details, preferences, chapters, and pages
function saveEditedData(url, bookId, formData) {
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            handleSaveEditedDataResponse(response);
        },
        error: function (error) {
            handleSaveEditedDataError(error);
        }
    });
}

// Helper function to handle response after saving edited data
function handleSaveEditedDataResponse(response) {
    if (response && response.message) {
        alert(response.message);
    } else if (response && response.error) {
        alert('Error: ' + response.error);
    } else {
        alert('An unknown error occurred while saving data.');
    }
}

// Helper function to handle errors after saving edited data
function handleSaveEditedDataError(error) {
    console.error('Error saving data:', error);
    alert('An error occurred while saving data. Please try again.');
}

// Function to show book list and hide other sections
function showBookList() {
    hideSections(['bookDetailsSection', 'bookPreferencesSection', 'chapterListSection']);
    showSections(['bookListSection']);
}

// Function to hide specific sections
function hideSections(sectionIds) {
    sectionIds.forEach(function (sectionId) {
        $('#' + sectionId).hide();
    });
}

// Function to show book selection page
function showBookSelectionPage() {
    // Implementation...
}

// Function to log book details to the console
function logBookDetails(bookDetails) {
    console.log("Book Details:", bookDetails);
}




///CHOICES///////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
// Function to load choices for a page
function loadChoicesForPage(bookId, chapterId, pageId, callback) {
    $.ajax({
        url: '/book/admin-portal/books/fetch-choices-for-pages.php',
        type: 'POST',
        dataType: 'json',
        data: { page_id: pageId },
        success: function (response) {
            console.log('Choices loaded successfully for page ' + pageId, response);

            if (typeof callback === 'function') {
                // Pass the correct parameters to the callback function, including choice_id
                callback(response.choices, pageId, chapterId, bookId, response.choices.choice_id, response.choices.length);
            } else {
                console.error('Callback is not a function:', callback);
            }
        },
        error: function (error) {
            console.error('Error fetching choices:', error);
            console.log('page id=', pageId);
        }
    });
}

//Function to display choices with collapse within the selected page.
// Function to display choices with collapse within the selected page.
function displayChoices(choices, pageId, chapterId, amountOfChoices) {
    console.log('Displaying choices for page ' + pageId + ':', choices);

    var choicesList = $('#choicesList' + pageId);
    choicesList.empty();

    if (choices && Object.keys(choices).length > 0) {
        console.log('Displaying choices length:', Object.keys(choices).length);

        // Include choice_text as Choice 1 if it exists
        if (choices['choice_text'] !== undefined && choices['choice_text'] !== null) {
              var choiceText = 'Choice 1: ' + choices['choice_text'] + ', Target Page: ' + choices['target_page'] + '<br>';

            // Create and append the list item for choice_text with its own collapse
            var choiceItem = '<li class="list-group-item">' +
                '<div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#choiceCollapse' + pageId + '_1">' +
                choiceText +
                '</div>' +
                '<div class="collapse choice-collapse" id="choiceCollapse' + pageId + '_1">' +
                '<div class="card card-body">' +
                'Choice 1: ' + choices['choice_text'] + ', Target Page: ' + choices['target_page'] + '<br>' +
                '</div>' +
                '</div>' +
                '</li>';

            choicesList.append(choiceItem);
        }

        // Iterate over each choice property
        for (var i = 1; i <= 4; i++) {
            // Check if the current choice property exists in the choices object
            if (choices['choice_text_' + i] !== undefined && choices['choice_text_' + i] !== null) {
                var choiceText = 'Choice ' + (i + 1) + ': ' + choices['choice_text_' + i] + ', Target Page: ' + choices['target_page_' + i] + '<br>';

                // Create and append the list item for each choice text with its own collapse
                var choiceItem = '<li class="list-group-item">' +
                    '<div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#choiceCollapse' + pageId + '_' + (i + 1) + '">' +
                    choiceText +
                    '</div>' +
                    '<div class="collapse choice-collapse" id="choiceCollapse' + pageId + '_' + (i + 1) + '">' +
                    '<div class="card card-body">' +
                    'Choice ' + (i + 1) + ': ' + choices['choice_text_' + i] + ', Target Page: ' + choices['target_page_' + i] + '<br>' +
                    '</div>' +
                    '</div>' +
                    '</li>';

                choicesList.append(choiceItem);
            }
        }

        var addChoiceButton = '<button class="btn btn-success" onclick="addChoice(' + pageId + ', ' + chapterId + ', ' + amountOfChoices + ')">Add Choice</button>';
        choicesList.append('<li class="list-group-item">' + addChoiceButton + '</li>');
    }
    console.log('Displaying choices for page ' + pageId + ':', choices);
console.log('Displaying choices length:', Object.keys(choices).length);

}

// Function to get the selected choice based on the radio button
function getSelectedChoice(pageId) {
    var selectedChoice = $('input[name="choiceRadio' + pageId + '"]:checked').val();
    return selectedChoice ? parseInt(selectedChoice) : 1; // Default to 1 if no choice is selected
}

// Function to open the Edit Choice modal
function openEditChoiceModal(choiceId, choiceText, targetPage) {
    // Populate the modal fields with the current choice details
    $('#editedChoiceId').val(choiceId);
    $('#editedChoiceText').val(choiceText);
    $('#editedTargetPage').val(targetPage);

    // Open the modal
    $('#editChoiceModal').modal('show');
}

// Function to save changes to a choice
function saveChoiceChanges(pageId) {
// Retrieve the selected radio button value (choiceId)
var choiceId = $('input[name="choiceRadio' + pageId + '"]:checked').val();
console.log('Selected choiceId:', choiceId);

// ... rest of your code ...

    // If no radio button is selected, show an alert and return
    if (choiceId === undefined) {
        alert('Please select a choice to edit.');
        return;
    }

    // Retrieve edited choice details from input fields or modal
    var editedChoiceText = $('#editedChoiceText').val();
    var editedTargetPage = $('#editedTargetPage').val();

    // Send an AJAX request to save the changes
    $.ajax({
        url: '/book/admin-portal/books/save-edited-choice.php',
        type: 'POST',
        dataType: 'json',
        data: {
            choice_id: choiceId,
            edited_choice_text: editedChoiceText,
            target_page: editedTargetPage
        },
        success: function (response) {
            console.log('AJAX Success - Response:', response);

            if (response.error) {
                console.error('Error saving choice changes:', response.error);
                console.error('choiceId:', choiceId);
                console.error('edited choice text:', editedChoiceText);
                console.error('target page:', editedTargetPage);
                // Display error alert
                alert('Error saving choice changes: ' + response.error);
            } else {
                console.log('Choice changes saved successfully:', response.message);
                // Optionally, update the displayed choice details without refreshing the page
                // You may need to add code to update the UI with the new choice details
                // For example, update the choice text in the list
                // $('#choiceText' + choiceId).text(editedChoiceText);
                // Display success alert
                alert('Choice changes saved successfully!');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
            // Log the sent data
            console.log('Sent Data:', {
                choice_id: choiceId,
                edited_choice_text: editedChoiceText,
                target_page: editedTargetPage
            });
            // Display error alert
            alert('Error saving choice changes. Please try again.');
        }
    });
}

// Function to get the choice text based on the choice ID
function getChoiceText(choiceId) {
    // Implement logic to retrieve the choice text from the choices object or server based on choice ID
    // Replace the following line with your actual logic
    return 'Choice Text for ID ' + choiceId;
}


// Function to add choices for the new page
function saveNewPageChoices(chapterId, pageId) {
    // Perform an AJAX request to add choices for the new page
    $.ajax({
        url: '/book/admin-portal/books/add-choices.php',
        method: 'POST',
        data: {
            book_id: selectedBookId,
            chapter_id: chapterId,
            page_id: pageId,
            choice_text: 'Default Choice', // Provide default choice text
            target_page: 0
        },
        dataType: 'json',
        success: function (response) {
            if (response && response.message) {
                console.log('Choices added successfully:', response.message);
                // Reload choices for the new page
                loadChoicesForPage(selectedBookId, chapterId, pageId, displayChoices);
            } else if (response && response.error) {
                console.error('Error adding choices:', response.error);
            } else {
                console.error('An unknown error occurred while adding choices.');
            }
        },
        error: function (error) {
            console.error('Error adding choices:', error);
        }
    });
}

function addChoice(pageId, chapterId, amountOfChoices) {
    var choicesList = $('#choicesList' + pageId);
    var newChoiceItem = '<li class="list-group-item">' +
        '<input type="text" class="form-control" placeholder="Enter choice text" id="newChoiceInput' + pageId + '">' +
        '<button class="btn btn-success save-choice-btn" onclick="saveChoice(' + pageId + ',' + chapterId + ', $(\'#newChoiceInput' + pageId + '\'))">Save</button>' +
        '</li>';
    choicesList.append(newChoiceItem);
}

// Function to save a new choice for a page
function saveChoice(pageId, selectedChapterId, choiceInput) {
    // Check if choiceInput is a valid jQuery object
    if (choiceInput && choiceInput.val) {
        var choiceText = choiceInput.val();

        // Encode the choice text
        choiceText = encodeURIComponent(choiceText);

        // Check if the choice text is not empty
        if (choiceText.trim() !== '') {
            // Send an AJAX request to save the new choice
            $.ajax({
                url: '/book/admin-portal/books/add-choices.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    book_id: selectedBookId, // Assuming selectedBookId is a global variable
                    chapter_id: selectedChapterId,
                    page_id: pageId,
                    choice_text: choiceText,
                    target_page: 0
                },
                success: function (response) {
                    // Display success or error message
                    if (response.error) {
                        console.error('Error saving choice:', response.error);
                        // Log additional details about the request
                        console.log('Request details:', {
                            book_id: selectedBookId,
                            chapter_id: selectedChapterId,
                            page_id: pageId,
                            choice_text: choiceText,
                            target_page: 0
                       
                        });

                        // Display error alert
                        alert('Error saving choice: ' + response.error);
                    } else {
                        console.log('Choice saved successfully:', response.message);

                        // Reload choices for the current page after saving
                        loadChoicesForPage(selectedBookId, selectedChapterId, pageId, function (choices, pageId, chapterId, bookId, choiceId, amountOfChoices) {
                            displayChoices(choices, pageId, chapterId, choiceId, amountOfChoices);
                                
                                
                                saveNewPage(selectedBookId, selectedChapterId, pageId, choiceId, choiceText);
                            
                        });

                        // Display success alert
                        alert('Choice saved successfully!');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    // Log additional details about the request
                    console.log('Request details:', {
                        book_id: selectedBookId,
                        chapter_id: selectedChapterId,
                        page_id: pageId,
                        choice_text: choiceText,
                        target_page: 0
                    });

                    // Display error alert
                    alert('Error saving choice. Please try again.');
                }
            });
        } else {
            console.error('Choice text cannot be empty.');
            // Display error alert for empty choice text
            alert('Choice text cannot be empty.');
        }
    } else {
        console.error('Invalid choiceInput.');
    }
}

// Function to refresh the choices list
function refreshChoicesList(pageId, chapterId, amountOfChoices) {
    // Implement this function based on your requirements
   // Reload choices for the current page after saving
loadChoicesForPage(selectedBookId, selectedChapterId, pageId, function(choices, pageId, chapterId, amountOfChoices) {
    displayChoices(choices, pageId, chapterId, amountOfChoices);
    // Create a new page using the new choice's ID
    saveNewPage(selectedChapterId, response.choice_id);
});

}

// Function to edit a choice
function editChoice(choiceId) {
    // Perform edit action with the choice ID
    console.log('Editing choice with ID:', choiceId);
    // Add your edit logic here
}

// Function to delete a choice
function deleteChoice(choiceId) {
    // Perform delete action with the choice ID
    console.log('Deleting choice with ID:', choiceId);
    // Add your delete logic here
}


////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


// Update the event handlers for "Edit" and "Delete" buttons
$(document).on('click', '.edit-choice-btn', function () {
    // Find the selected radio button
    var selectedChoiceId = $('input[name="choiceRadio"]:checked').val();

    if (selectedChoiceId) {
        // Call the editChoice function with the selected choice ID
        editChoice(selectedChoiceId);
    } else {
        console.log('No choice selected for editing.');
    }
});

$(document).on('click', '.delete-choice-btn', function () {
    // Find the selected radio button
    var selectedChoiceId = $('input[name="choiceRadio"]:checked').val();

    if (selectedChoiceId) {
        // Call the deleteChoice function with the selected choice ID
        deleteChoice(selectedChoiceId);
    } else {
        console.log('No choice selected for deletion.');
    }
});

// Function to get the selected chapterId (replace with your logic)
    function getSelectedChapterId() {
        var selectedChapterId = $('input[name="selectedChapter"]:checked');
        return selectedChapterRadio.val();
    }

    // Function to handle chapter selection
    function selectChapter() {
        var selectedChapterId = getSelectedChapterId();
        if (selectedChapterId) {
            // Load pages and choices for the selected chapter
            loadPagesAndChoices(selectedBookId, selectedChapterId);
        } else {
            console.error('Error: No chapter selected.');
        }
    }

// Function to clear previous content
function clearPreviousContent() {
    // Assuming 'pagesContainer' and 'choicesContainer' are the containers for pages and choices
    $('#pagesContainer').empty();
    $('#choicesContainer').empty();
}

function displayBookPages(bookPages, chapterId) {
    var pagesList = $('#pagesList');
    pagesList.empty();

    if (bookPages.length > 0) {
        $.each(bookPages, function (index, page) {
            var pageItem = '<li>' +
                '<input type="radio" name="selectedPage" value="' + page.page_id + '" data-chapter-id="' + page.chapter_id + '">' +
                'Page ID: ' + page.page_id +
                ', Chapter ID: ' + page.chapter_id +
                ', Page Number: ' + page.page_number +
                ', Content: ' + page.content +
                ', Choices: ' + page.choices +
                ' <button class="btn btn-success" onclick="openEditPageModal(' + page.page_id + ', ' + chapterId + ')">Edit Page</button>' +
                '</li>';

            pagesList.append(pageItem);
        });
    } else {
        pagesList.append('<li>No pages available for this chapter.</li>');
    }
}


// Function to initialize the chapter select options
function initializeChapterSelect() {
    var chapterSelect = $('#chapterSelect');
    $.each(chaptersData, function (index, chapter) {
        chapterSelect.append('<option value="' + chapter.id + '">' + chapter.name + '</option>');
    });
}

// Load Book For Editing
	function loadBookDetailsForEditing(selectedBookId) {
	selectedBookId = $("input[name='bookRadio']:checked").data('book-id');
    loadBookDetails(selectedBookId);
   loadBookPreferences(selectedBookId);
   loadChaptersList(selectedBookId);
	loadBookData(selectedBookId);
    
}

// Function to open the New Chapter modal
function openNewChapterModal() {
  // Clear any existing data in the modal form
  // ...

  // Show the modal
  $('#newChapterModal').modal('show');
}


// Function to delete a page and its choices
function deletePage(pageId, chapterId) {
    // Confirm the deletion with the user
    if (confirm('Are you sure you want to delete this page?')) {
        // Send an AJAX request to delete the page and its choices
        $.ajax({
            url: '/book/admin-portal/books/delete-page.php',
            type: 'POST',
            dataType: 'json',
            data: { page_id: pageId },
            success: function (response) {
                // Handle success (reload pages and choices)
                if (!response.error) {
                    // Reload pages and choices for the current chapter
                     fetchSelectedBookPages(selectedBookId, chapterId)
          .then(function (pages) {
            displayPagesInAccordion(chapterId, pages);
          })
                    console.log('Page deleted successfully:', response.message);
                } else {
                    console.error('Error deleting page:', response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
}

// Update the event handlers for "delete page" and "Delete" buttons
$(document).on('click', '.delete-page-btn', function () {
   // Event listener for "Delete Page" button clicks
//$('.delete-page-btn').on('click', function () {
    // Extract page and chapter IDs from data attributes
    var pageId = $(this).data('page-id');
    var chapterId = $(this).data('chapter-id');

    // Log IDs for debugging
    console.log('Delete page pageId:', pageId);
    console.log('Delete page chapterId:', chapterId);

    // Call the deletePage function
    deletePage(pageId, chapterId);
});

// Event listener for "Save Page" button in the modal
$('#savePageButton').on('click', saveNewPage);

// EVENT LISTNERS-----------------------------------------------------------
$(document).ready(function () {
    
    
// Event handlers
$('#saveEditedBookPreferencesBtn').on('click', saveEditedBookPreferences);
$('#saveEditedBookChaptersBtn').on('click', saveEditedBookChapters);
$('#selectBookBtn').on('click', selectBook);

// Event listener for book selection
$('#bookList').on('change', function () {
    // Update the global variable when the book selection changes
    selectedBookId = $(this).val();
    if (selectedBookId) {
        // Set the selectedBookId in the hidden input
        $('#selectedBookId').val(selectedBookId);

        // Store selectedBookId as a data attribute in a higher-level container
        $('#bookListContainer').data('selected-book-id', selectedBookId);

        loadBookData(selectedBookId);
    } else {
        console.error('Error: Invalid book selection.');
    }
});

// Add a click event listener for chapter list items
$('#chaptersList').on('click', 'li', function () {
    // Fetch the selected book ID and chapter ID
    var selectedBookId = $('#bookList').val();
    var selectedChapterId = $(this).data('chapter_id');

    // Check if a book is selected
    if (selectedBookId) {
        // Load book details for editing
        loadBookDetailsForEditing(selectedBookId);

        // Fetch chapter details
        $.ajax({
            url: '/book/admin-portal/books/fetch-selected-chapter.php',
            method: 'GET',
            data: { book_id: selectedBookId, chapter_id: selectedChapterId },
            dataType: 'json',
            success: function (chapterDetails) {
                // Set selectedChapterId using the fetched data
                selectedChapterId = chapterDetails.chapter_id;

                // Load pages for the selected chapter
                loadPagesAndChoices(selectedBookId, selectedChapterId);
            },
            error: function (error) {
                console.error('Error fetching chapter details:', error);
            }
        });

        // Load pages for the selected chapter
        loadPagesAndChoices();
    } else {
        // Inform the user to select a book
        alert('Please select a book before editing.');
    }
});

// Add Chapter button click event
    $('#addNewChapterBtn').on('click', function () {
        openAddChapterModal();
    });
    
  // Add a click event handler for the "Save Changes" button in the modal
    $('#saveNewChapterBtn').on('click', function () {
        saveNewChapter();
    });


    // Event listener for the close book details button
    $('#closeBookDetailsBtn').on('click', function () {
        showBookList(); // Assuming showBookList() hides bookDetailsSection and shows bookListSection
    });
    
   
    
    // Event listener to displlay book management section
    $('#bookManagementBtn').on('click', function () {
        fetchBookList();
        hideSections(['home', 'userManagement', 'newsManagement','bookDetailsSection', 'bookPreferencesSection', 'chapterListSection']);
         showSections(['bookManagement']);
         hideSections
    });
    
});

// Function to set the selectedBookId in a global variable
function setGlobalSelectedBookId(bookId) {
    selectedBookId = bookId;
}

function openNewPageModal(chapterId, choiceId) {
    // Calculate the new page number (increment by 1)
    var existingPagesCount = $('#pagesAndChoicesList' + chapterId + ' li').length;
    var newPageNumber = existingPagesCount + 1;

    // Set the auto-incremented page number in the modal
    $('#newPageNumber').val(newPageNumber);

    // Set selectedChapterId
    selectedChapterId = chapterId;

    // Show the modal
    $('#addPageModal').modal('show');

    // Save the new page when the modal is shown
    saveNewPage(chapterId);
}

 function loadChaptersList(selectedBookId) {
  // Fetch selected book chapters and display them
  fetchSelectedBookChapters(selectedBookId)
    .then(function (bookChapters) {
      displayChaptersList(bookChapters);

      // Fetch and display pages for the first chapter
      if (bookChapters.length > 0) {
        var firstChapterId = bookChapters[0].chapter_id;

        fetchSelectedBookPages(selectedBookId, firstChapterId)
          .then(function (pages) {
            displayPagesInAccordion(firstChapterId, pages);
          })
          .catch(function (error) {
            console.error('Error fetching pages:', error);
          });
      }
    })
    .catch(function (error) {
      console.error('Error fetching book chapters:', error);
    });
}

// Call fetchSelectedBookChapters and handle the response
fetchSelectedBookChapters(selectedBookId)
    .then(function (bookChapters) {
        displayChaptersList(bookChapters);
    })
    .catch(function (error) {
        console.error('Error fetching book chapters:', error);
    });


</script>

</head>
<body>

<!------------------------- Bootstrap Navbar ------------------------------------------------------------->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadContent('home')">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadContent('user-management')">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadContent('news-management')">News Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id = "bookManagementBtn" >Book Management</a>"
                    <!-- //onclick="loadContent('book-management') -->
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- admin-portal.php  Entire Page Container -------------------------------------------------------------------------------->
<div class="container mt-5">
<!--------------------------- Page content ---------------------------------------------------------------->
<div class="content">
    <div id="dynamicContent">
        <!-- Content will be loaded here -->
    </div>
</div>
<!--------------------------- Home Section ---------------------------------------------------------------->
<div id="home">
    <div class="container mt-5">
        <h2>Welcome to the Admin Portal</h2>
        <p>This is the landing page for the Admin Portal. Use the navigation links to manage users and news articles.</p>
    </div>
</div>

<!--------------------------- Book Management Section ----------------------------------------------------->
<div id="bookManagement" style="display: none;">
    <h1>Book Management 1.1</h1>

    <div id="bookListSection">
        <h2>Book List</h2>
        <table id="bookListTable" class="table table-striped table-bordered">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Description</th>
                    <th>Image URL</th>
                    <th>Video URL</th>
                    <th>Deleted</th>
                    <th>Live</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Book list items will be dynamically added here -->
            </tbody>
        </table>
        <!-- Select Book Button -->
        <div id="selectBookSection">
        <div>
        <button id="createBookBtn" class="btn btn-primary" onclick="showCreateBookForm()">Create Book</button>
        <button id="selectBookBtn" class="btn btn-primary" onclick="selectBook()">Select Book</button>
        </div>
        </div>
    </div>


    <!-- Create Book Section -->
<div id="createBookSection">

    <!-- Create Book Modal -->
    <div class="modal fade" id="createBookModal" tabindex="-1" role="dialog" aria-labelledby="createBookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBookModalLabel">Create New Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Create Book Form -->
                    <!-- Create Book Form -->
<form id="createBookForm">
    <div class="mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="author">Author</label>
        <input type="text" class="form-control" id="author" name="author">
    </div>
    <div class="mb-3">
        <label for="year">Year</label>
        <input type="number" class="form-control" id="year" name="year">
    </div>
    <div class="mb-3">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="image_url">Image URL</label>
        <input type="text" class="form-control" id="image_url" name="image_url">
    </div>
    <div class="mb-3">
        <label for="video_url">Video URL</label>
        <input type="text" class="form-control" id="video_url" name="video_url">
    </div>
    <!-- Hidden Fields for deleted and live -->
    <input type="hidden" name="deleted" value="0">
    <input type="hidden" name="live" value="0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="saveNewBook()">Save Book</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
   <!-- Selected Book Editing Section-->
    <div id="bookDetailsSection" style="display: none;">
        <div>
    <button id="closeBookDetailsBtn" class="btn btn-primary">Close Book</button>
    <button id="deleteBookBtn" class="btn btn-danger">Delete Book</button>
    </div>
		<div id="accordion">
<!-- Book Details --->
  <div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
        DETAILS
      </a>
    </div>
    <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
        <form id="editBookDetailsForm">
                        <!-- Table to display book details -->
                        <div class="table-responsive">
                            <table class="table" id="bookDetailsTable">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody id="bookDetailsTableBody">
                                    <!-- Book details will be dynamically added here -->
                                </tbody>
                            </table>
                            <input type="hidden" id="bookDetailsBookId" name="book_id" value="...">
							<button type="button" id="saveEditedBookDetailsBtn" class="btn btn-primary" onclick="saveEditedBookDetails()">Save Changes</button>
                        </div>
                    </form>

      </div>
    </div>
  </div>

<!-- Book Preferences --->
  <div class="card">
    <div class="card-header">
      <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
        PREFERENCES
      </a>
    </div>
    <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
				<form id="editBookPreferencesForm">
                <!-- Table to display book preferences -->
                <div class="table-responsive">
                    <table class="table" id="bookPreferencesTable">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody id="bookPreferencesTableBody">
                            <!-- Book preferences will be dynamically added here -->
                        </tbody>

                    </table>

                <input type="hidden" id="selectedBookId" value="">
               <input type="hidden" id="bookPreferencesBookId" name="book_id" value="...">
				<button type="button" id="saveEditedBookPreferencesBtn" class="btn btn-primary">Save Changes</button>
</div>
            </form>
      </div>
    </div>
  </div>

<!-- Chapters Section -->
<div id="bookChaptersDrop">
<div class="card">
    <div class="card-header">
	<input type="hidden" id="bookChaptersBookId" name="book_id" value="...">

        <a class="collapsed btn" id="" data-bs-toggle="collapse" href="#collapseChapters">
            CHAPTERS
        </a>
    </div>
    <div id="collapseChapters" class="collapse" data-bs-parent="#accordion">
        <div class="card-body">

            <!-- Container for chapters -->
            <div id="chaptersContainer">
                <!-- Repeat the below structure for each chapter -->
                <!-- Card for each chapter -->
                
            </div>
        </div>
    </div>
</div>
</div>
<!-- Edit Chapter Modal -->
<div class="modal" id="editChapterModal" tabindex="-1" role="dialog">
  <!-- Modal content -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Chapter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for editing chapter details -->
        <!-- Include input fields for chapter details -->
        <!-- Adjust as needed based on your requirements -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- New Chapter Modal -->
<div class="modal" id="newChapterModal" tabindex="-1" role="dialog">
  <!-- Modal content -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Chapter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for creating a new chapter -->
        <!-- Include input fields for new chapter details -->
        <!-- Adjust as needed based on your requirements -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create Chapter</button>
      </div>
    </div>
  </div>
</div>


        </div>
    </div>
</div>

</div>

	<!-- Modal for adding a new chapter -->
<div class="modal fade" id="addChapterModal" tabindex="-1" aria-labelledby="addChapterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addChapterModalLabel">Add New Chapter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Input fields for the new chapter -->
                <div class="mb-3">
                    <label for="newChapterNumber" class="form-label">Chapter Number</label>
                    <input type="text" class="form-control" id="newChapterNumber" readonly>
                </div>
                <div class="mb-3">
                    <label for="newStoryline" class="form-label">Storyline</label>
                    <input type="text" class="form-control" id="newStoryline">
                </div>
                <div class="mb-3">
                    <label for="newAffinityRequirement" class="form-label">Affinity Requirement</label>
                    <input type="text" class="form-control" id="newAffinityRequirement">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveNewChapterBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" role="dialog" aria-labelledby="addPageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPageModalLabel">Add New Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input fields for the new page -->
                <div class="mb-3">
                    <label for="newPageContent">Page Content:</label>
                    <textarea class="form-control" id="newPageContent" name="newPageContent" placeholder="Add your creative storyline for this page here..." required></textarea>
                </div>
                <!-- Hidden input to store the chapterId -->
                <input type="hidden" id="newPageChapterId">
                <!-- Hidden input to store the auto-incremented page number -->
                <input type="text" class="form-control" id="newPageNumber" readonly>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveNewPage()">Save Page</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Choice Modal -->
<div class="modal fade" id="editChoiceModal" tabindex="-1" aria-labelledby="editChoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editChoiceModalLabel">Edit Choice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Hidden input to store the edited choice ID -->
                <input type="hidden" id="editedChoiceId">

                <!-- Input field for editing the choice text -->
                <div class="mb-3">
                    <label for="editedChoiceText" class="form-label">Choice Text:</label>
                    <input type="text" class="form-control" id="editedChoiceText" placeholder="Enter edited choice text">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveChoiceChanges()">Save Changes</button>
            </div>
        </div>
    </div>
</div>






</div>

<!--------------------------- User Management Section ----------------------------------------------------->
<div id="userManagement" style="display: none;">
    <div class="container mt-5">

        <h2>User Management</h2>
        <!-- Add User Section -->
        <div class="mb-5">
            <h2>Add User</h2>
            <form id="addUserForm" action="/book/admin-portal/users/add-user.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Date of Birth" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="gender" name="gender" placeholder="Gender">
                </div>
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>

        <!-- Edit and Remove User Section -->
        <div class="mb-5">
            <h2>Edit and Remove User</h2>
            <!-- List of Users -->
            <ul id="userList" class="list-group">
                <!-- User details will be displayed here dynamically -->
            </ul>
            <!-- Edit and Remove Buttons -->
            <button type="button" class="btn btn-warning mt-3" onclick="editSelectedUser()">Edit Selected User</button>
            <button type="button" class="btn btn-danger mt-3" onclick="removeSelectedUser()">Remove Selected User</button>
        </div>

        <!-- Edit User Form -->
        <div id="editUserFormSection" style="display: none;">
            <h2>Edit User</h2>
            <form id="editUserForm" action="save-changes.php" method="post">
                <!-- Fields for editing user data -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="editUserId" name="user_id" readonly>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newUsername" name="new_username" placeholder="New Username">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="newEmail" name="new_email" placeholder="New Email">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="New Password">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newFullName" name="new_full_name" placeholder="New Full Name">
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" id="newDateOfBirth" name="new_date_of_birth" placeholder="New Date of Birth">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newCountry" name="new_country" placeholder="New Country">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newGender" name="new_gender" placeholder="New Gender">
                </div>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </form>
        </div>

    </div>
</div>
<!--------------------------- News Management Section ----------------------------------------------------->
<div id="newsManagement" style="display: none;">
    <div class="container mt-5">

        <h2>News Management</h2>
        <!-- Add News Section -->
        <div class="mb-5">
            <h2>Add News Article</h2>
            <form id="addNewsForm" action="add-news.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="headline" name="headline" placeholder="Headline" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="article" name="article" placeholder="Article Content" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Add News</button>
            </form>
        </div>

        <!-- Edit and Remove News Section -->
        <div class="mb-5">
            <h2>Edit and Remove News</h2>
            <!-- List of News Articles -->
            <ul id="newsList" class="list-group">
                <!-- News details will be displayed here dynamically -->
            </ul>
            <!-- Edit and Remove Buttons -->
            <button type="button" class="btn btn-warning mt-3" onclick="editSelectedNews()">Edit Selected News</button>
            <button type="button" class="btn btn-danger mt-3" onclick="removeSelectedNews()">Remove Selected News</button>
        </div>

        <!-- Edit News Form -->
        <div id="editNewsFormSection" style="display: none;">
            <h2>Edit News Article</h2>
            <form id="editNewsForm" action="save-news-changes.php" method="post">
                <!-- Fields for editing news data -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="editNewsId" name="news_id" readonly>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newHeadline" name="new_headline" placeholder="New Headline">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="newArticle" name="new_article" placeholder="New Article Content" rows="5"></textarea>
                </div>
                <!-- Optional Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image (Optional)</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveNewsChanges()">Save Changes</button>
            </form>
        </div>

    </div>
</div>


<script>
// Define the loadContent function

$(document).ready(function () {
///////////////////////////////////USER MANAGEMENT////////////////////////////////////////////
// Fetch and display the list of users
function fetchUserList() {
        $.ajax({
            url: '/book/admin-portal/users/fetch-users.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Clear existing list
                $('#userList').empty();

                // Display users in the list
                data.forEach(function (user) {
                    $('#userList').append('<li class="list-group-item">' +
                        '<input type="checkbox" class="form-check-input" name="selectedUsers[]" value="' + user.user_id + '">' +
                        ' ' + user.username +
                        '</li>');
                });
            },
            error: function (error) {
                console.error('Error fetching user list:', error);
            }
        });
    }
// Add User Section
$('#addUserForm').submit(function (event) {
        // Prevent the form from submitting in the traditional way
        event.preventDefault();

        // Collect form data
        var formData = $(this).serialize();

        // Send an AJAX request to add user
        $.ajax({
            url: '/book/admin-portal/users/add-user.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Display success or error alert
                if (response.message) {
                    alert(response.message);
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }

                // Refresh the user list after adding a user
                fetchUserList();
            },
            error: function (error) {
                console.error('Error adding user:', error);
            }
        });
    });
// Edit selected user
function editSelectedUser() {
    var selectedUsers = $("input[name='selectedUsers[]']:checked");

    if (selectedUsers.length === 1) {
        var userId = selectedUsers.val();

        // Fetch user details for editing
        $.ajax({
            url: '/book/admin-portal/users/fetch-user-details.php',
            method: 'GET',
            data: {user_id: userId},
            dataType: 'json',
            success: function (userData) {
                // Display the user details in the edit form
                $('#editUserId').val(userData.user_id);
                // Set values for other fields
                $.each(userData, function (key, value) {
                    if (key === 'age') {
                        // Set the value of newDateOfBirth field
                        $('#newDateOfBirth').val(value);
                    } else if (key === 'password_hash') {
                        // You may choose not to populate the password field for security reasons
                       // $('#newPassword').val(value);
					} else if (key === 'gender') {
                        // Set gender val
                        $('#newGender').val(value);
                    } else if (key === 'name') {
                        // Set the value of newFullName field
                        $('#newFullName').val(value);
                    } else {
                        // Set values for other fields
                        $('#new' + key.charAt(0).toUpperCase() + key.slice(1)).val(value);
                    }
                });

                // Hide user list and display the edit form
                $('#userList').hide();
                $('#editUserFormSection').show();
            },
            error: function (error) {
                console.error('Error fetching user details:', error);
            }
        });
    } else {
        alert('Please select exactly one user to edit.');
    }
}
// Function to format date in yyyy-mm-dd to a user-friendly format
function formatDate(dateString) {
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}
// Remove selected user
function removeSelectedUser() {
    var selectedUsers = $("input[name='selectedUsers[]']:checked");

    if (selectedUsers.length > 0) {
        if (confirm('Are you sure you want to remove the selected user(s)?')) {
            // Proceed with removing the selected user(s)
            var userIds = selectedUsers.map(function () {
                return this.value;
            }).get();

            $.ajax({
                url: '/book/admin-portal/users/remove-user.php',
                method: 'POST',
                data: {user_ids: userIds},
                dataType: 'json',
                success: function (response) {
                    // Display success alert
                    alert(response.message);

                    // Refresh the user list after removal (assuming fetchUserList is the function to fetch users)
                    fetchUserList();
                },
                error: function (error) {
                    console.error('Error removing user(s):', error);
                }
            });
        }
    } else {
        alert('Please select at least one user to remove.');
    }
}
// Cancel edit and show the user list
function cancelUserEdit() {
        $('#editUserFormSection').hide();
        $('#userList').show();
    }
// Save changes
function saveUserChanges() {
    // Collect form data
    var formData = $('#editUserForm').serialize();

    // Send an AJAX request to save changes
    $.ajax({
        url: '/book/admin-portal/users/add-user.php', // Use the same endpoint for adding and editing
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            // Display success or error alert
            if (response.message) {
                alert(response.message);
            } else if (response.error) {
                alert('Error: ' + response.error);
            }

            // Refresh the user list after saving changes
            fetchUserList();

            // Show the user list and hide the edit form
            $('#editUserFormSection').hide();
            $('#userList').show();
        },
        error: function (error) {
            console.error('Error saving changes:', error);
        }
    });
}
//////////////////////////////////NEWS MANAGEMENT/////////////////////////////////
// Fetch and display the list of news articles
function fetchNewsList() {
    $.ajax({
        url: '/book/admin-portal/news/fetch-news.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Check if the data is not null or undefined
            if (data !== null && data !== undefined) {
                // Clear existing list
                $('#newsList').empty();

                // Display news articles in the list
                if (Array.isArray(data)) {
                    // Check if data is an array before using forEach
                    data.forEach(function (article) {
                        // Append news articles to the list
                        $('#newsList').append('<li class="list-group-item">' +
                            '<input type="checkbox" class="form-check-input" name="selectedNews[]" value="' + article.id + '">' +
                            ' <strong>' + article.headline + '</strong><br>' +
                            '<small>' + formatDate(article.datetime) + '</small>' +
                            '</li>');
                    });
                } else {
                    console.error('Received unexpected data format from the server.');
                }
            } else {
                console.error('Received null or undefined data from the server.');
            }
        },
        error: function (error) {
            console.error('Error fetching news list:', error);
        }
    });
}
// Add News Section
$(document).ready(function () {
        $('#addNewsForm').submit(function (event) {
            // Prevent the form from submitting in the traditional way
            event.preventDefault();

            // Collect form data
            var formData = new FormData(this);

            // Send an AJAX request to add news
            $.ajax({
                url: '/book/admin-portal/news/add-news.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    // Display success or error alert
                    if (response.message) {
                        alert(response.message);
                    } else if (response.error) {
                        alert('Error: ' + response.error);
                    }

                    // Refresh the news list after adding a news article
                    fetchNewsList();
                },
                error: function (error) {
                    console.error('Error adding news article:', error);
                }
            });
        });
    });
// Edit selected news article
function editSelectedNews() {
        var selectedNews = $("input[name='selectedNews[]']:checked");

        if (selectedNews.length === 1) {
            var newsId = selectedNews.val();

            // Fetch news details for editing
            $.ajax({
                url: '/book/admin-portal/news/fetch-news-details.php',
                method: 'GET',
                data: {news_id: newsId},
                dataType: 'json',
                success: function (newsData) {
                    // Display the news details in the edit form
                    $('#editNewsId').val(newsData.id);

                    // Set values for other fields
                    $.each(newsData, function (key, value) {
                        if (key === 'datetime') {
                            // Format the date and time in yyyy-mm-ddThh:mm format
                            $('#newDatetime').val(value.replace(' ', 'T'));
                        } else if (key === 'article') {
                            // Set the value of newArticle field
                            $('#newArticle').val(value);
                        } else {
                            // Set values for other fields
                            $('#new' + key.charAt(0).toUpperCase() + key.slice(1)).val(value);
                        }
                    });

                    // Hide news list and display the edit form
                    $('#newsList').hide();
                    $('#editNewsFormSection').show();
                },
                error: function (error) {
                    console.error('Error fetching news details:', error);
                }
            });
        } else {
            alert('Please select exactly one news article to edit.');
        }
    }
// Remove selected news article
function removeSelectedNews() {
        var selectedNews = $("input[name='selectedNews[]']:checked");

        if (selectedNews.length > 0) {
            if (confirm('Are you sure you want to remove the selected news article(s)?')) {
                // Proceed with removing the selected news article(s)
                var newsIds = selectedNews.map(function () {
                    return this.value;
                }).get();

                $.ajax({
                    url: '/book/admin-portal/news/remove-news.php',
                    method: 'POST',
                    data: {news_ids: newsIds},
                    dataType: 'json',
                    success: function (response) {
                        // Display success alert
                        alert(response.message);

                        // Refresh the news list after removal
                        fetchNewsList();
                    },
                    error: function (error) {
                        console.error('Error removing news article(s):', error);
                    }
                });
            }
        } else {
            alert('Please select at least one news article to remove.');
        }
    }
// Cancel edit and show the news list
function cancelNewsEdit() {
        $('#editNewsFormSection').hide();
        $('#newsList').show();
    }
// Save changes to news article
function saveNewsChanges() {
        // Collect form data
        var formData = new FormData($('#editNewsForm')[0]);

        // Send an AJAX request to save changes
        $.ajax({
            url: '/book/admin-portal/news/save-news-changes.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                // Display success or error alert
                if (response.message) {
                    alert(response.message);
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }

                // Refresh the news list after saving changes
                fetchNewsList();

                // Show the news list and hide the edit form
                $('#editNewsFormSection').hide();
                $('#newsList').show();
            },
            error: function (error) {
                console.error('Error saving news changes:', error);
            }
        });
    }


fetchUserList();
fetchNewsList();

});
</script>
</div>
</body>
</html>
