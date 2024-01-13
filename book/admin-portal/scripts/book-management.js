<!--------------------------- Book Management Section ----------------------------------------------------->
<div id="bookManagement" style="display: none;">
    <h1>Book Management 1.1</h1>

    <!-- Book List Section -->
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
            <button id="selectBookBtn" class="btn btn-primary" onclick="onSelectBookButtonClick()">Select Book</button>
        </div>
    </div>

    <!-- Create Book Section -->
    <div id="createBookSection">
        <button id="createBookBtn" class="btn btn-primary" onclick="showCreateBookForm()">Create a New Book</button>
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
                        <form id="createBookForm">
                            <!-- Form fields as before -->
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
       <!-- Selected Book Editing Section-->
<div id="bookDetailsSection" style="display: none;">

    <!-- Details Section -->
    <div class="card">
        <div class="card-header">
            <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                Details
            </a>
        </div>
        <div id="collapseOne" class="collapse" data-bs-parent="#bookDetailsSection">
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

    <!-- Preferences Section -->
    <div class="card">
        <div class="card-header">
            <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                Preferences
            </a>
        </div>
        <div id="collapseTwo" class="collapse" data-bs-parent="#bookDetailsSection">
            <div class="card-body">
                <form id="editBookPreferencesForm">
                    <!-- Separate table to display and edit book preferences -->
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
                        <input type="hidden" id="bookPreferencesBookId" name="book_id" value="...">
                        <button type="button" id="saveEditedBookPreferencesBtn" class="btn btn-primary" onclick="saveEditedBookPreferences()">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="card">
        <div class="card-header">
            <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseThree">
                Content
            </a>
        </div>
        <div id="collapseThree" class="collapse" data-bs-parent="#bookDetailsSection">
            <div class="card-body">
                <form id="editBookChaptersForm">
                    <!-- Separate table to display and edit book chapterss -->
                    <div class="table-responsive">
                        <table class="table" id="bookChaptersTable">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="bookChaptersTableBody">
                                <!-- Book content will be dynamically added here -->
                            </tbody>
                        </table>
                        <input type="hidden" id="bookChaptersBookId" name="book_id" value="...">
                        <button type="button" onclick="saveEditedBookChapters()" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>

                <!-- Table to display book pages -->
                <form id="editBookPagesForm">
                    <!-- Separate table to display and edit book pages -->
                    <div class="table-responsive">
                        <table class="table" id="bookPagesTable">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="bookPagesTableBody">
                                <!-- Book pages will be dynamically added here -->
                            </tbody>
                        </table>
                        <input type="hidden" id="bookPagesBookId" name="bookId" value="..."> <!-- Change name to 'bookId' -->
                        <button type="button" id="saveEditedBookPagesBtn" class="btn btn-primary" onclick="saveEditedBookPages()">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>
</div>






<script>
// Fetch and display the list of books
function fetchBookList() {
    var endpoint = '/book/admin-portal/books/fetch-books.php';

    $.ajax({
        url: endpoint,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
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

// Function to save a new book
function saveNewBook() {
    var formData = getNewBookFormData();

    $.ajax({
        url: '/book/admin-portal/books/add-book.php',
        method: 'POST',
        dataType: 'json',
        data: formData,
        success: function (response) {
            handleNewBookSaveResponse(response);
        },
        error: function (error) {
            handleNewBookSaveError(error);
        }
    });
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

// Function to show Create Book form
function showCreateBookForm() {
    clearNewBookForm();
    showNewBookModal();
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
    loadChapters(bookId);
    loadPages(bookId);
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
    // Implementation...
}

// Function to load book preferences for editing
function loadBookPreferences(bookId) {
    // Implementation...
}

// Function to load chapters for editing
function loadChapters(bookId) {
    $('#bookChaptersBookId').val(bookId);
    // Implementation...
}

// Function to load pages for editing
function loadPages(bookId) {
    $('#bookPagesBookId').val(bookId);
    // Implementation...
}

// Function to save edited book details
function saveEditedBookDetails() {
    var bookId = $('#bookDetailsBookId').val();
    var formData = $('#editBookDetailsForm').serialize();

    saveEditedData('/book/admin-portal/books/save-edited-book-details.php', bookId, formData);
}

// Function to save edited book preferences
function saveEditedBookPreferences() {
    var bookId = $('#bookPreferencesBookId').val();
    var formData = $('#editBookPreferencesForm').serialize();

    saveEditedData('/book/admin-portal/books/save-edited-book-preferences.php', bookId, formData);
}

// Function to save edited book chapters
function saveEditedBookChapters() {
    var bookId = $('#bookChaptersBookId').val();
    var formData = $('#editBookChaptersForm').serialize();

    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-chapters.php',
        method: 'POST',
        data: { book_id: bookId },
        dataType: 'json',
        success: function (response) {
            handleSaveEditedDataResponse(response);
        },
        error: function (error) {
            handleSaveEditedDataError(error);
        }
    });
}

// Function to save edited book pages
function saveEditedBookPages() {
    var bookId = $('#bookPagesBookId').val();
    var formData = $('#editBookPagesForm').serialize();

    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-pages.php',
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

// Function to be called when "Select Book" button is clicked
function onSelectBookButtonClick() {
    var shouldShowBookSelectionPage = true;

    if (shouldShowBookSelectionPage) {
        showBookSelectionPage();
    } else {
        showBookList();
    }
}

// Function to show book selection page
function showBookSelectionPage() {
    // Implementation...
}

// Load Book For Editing
function loadBookDetailsForEditing(bookId) {
    loadBookDetails(bookId);
    loadBookPreferences(bookId);
    loadChapters(bookId);
    loadPages(bookId);
}

// Function to log book details to the console
function logBookDetails(bookDetails) {
    console.log("Book Details:", bookDetails);
}

// Event handlers
$('#saveEditedBookDetailsBtn').on('click', saveEditedBookDetails);
$('#saveEditedBookPreferencesBtn').on('click', saveEditedBookPreferences);
$('#saveEditedBookChaptersBtn').on('click', saveEditedBookChapters);
$('#saveEditedBookPagesBtn').on('click', saveEditedBookPages);
$('#selectBookBtn').on('click', onSelectBookButtonClick);


</script>
