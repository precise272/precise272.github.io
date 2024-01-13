<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }

        .content {
            padding: 20px;
        }
    </style>
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
                    <a class="nav-link" href="#" onclick="loadContent('book-management')">Book Management</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
    <h2>Book Management</h2>

    <?php
    // Check if the form for entering book content should be displayed
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Display the form for adding book content (chapters)
        include '/book/admin-portal/books/add-chapter-form.php';
    } else {
        // Display the initial book creation form
        include '/book/admin-portal/add-book-form.php';
    }
    ?>



<!-- Step 1: Book Creation Form (Collapsible) -->
    <div class="mb-5">
        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#addBookFormCollapse" aria-expanded="false" aria-controls="addBookFormCollapse">
            Create a New Book
        </button>
        <div class="collapse" id="addBookFormCollapse">
            <form id="addBookForm" action="/book/admin-portal/books/add-book.php" method="post">
                <!-- Form fields for adding a book -->
                <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="coverImage" class="form-label">Cover Image</label>
                <input type="file" class="form-control" id="coverImage" name="coverImage" accept="image/*">
            </div>
 <input type="hidden" id="bookId" name="bookId" value="">
                <button type="submit" class="btn btn-primary">Next: Add Book Content</button>
            </form>
        </div>
    </div>



 <!-- Step 2: Book Preferences Form -->
    <div class="mb-5">
        <h2>Book Preferences</h2>
        <form id="bookPreferencesForm" style="display: none;">
            <!-- Form fields for book preferences -->
  <div class="mb-3">
                <label for="targetAge" class="form-label">Target Age</label>
                <select class="form-select" id="targetAge" name="targetAge" required>
                    <option value="0-5">0-5 years</option>
                    <option value="6-10">6-10 years</option>
                    <option value="11-15">11-15 years</option>
                    <option value="16-18">16-18 years</option>
                    <option value="18+">18+ years</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="mb-3">
                <label for="bookSize" class="form-label">Intended Size of the Book</label>
                <select class="form-select" id="bookSize" name="bookSize" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="difficulty" class="form-label">Difficulty</label>
                <select class="form-select" id="difficulty" name="difficulty" required>
                    <option value="easy">Easy</option>
                    <option value="normal">Normal</option>
                    <option value="hard">Hard</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="containsMiniGames" class="form-label">Contains Mini Games</label>
                <select class="form-select" id="containsMiniGames" name="containsMiniGames" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
<input type="hidden" id="bookIdPreferences" name="bookId" value="">

            <button type="button" class="btn btn-primary" onclick="saveBookPreferences()">Save Preferences</button>
        </form>
    </div>
 
 <!-- Step 3: Add Chapter Form (Collapsible) -->
    <div class="mb-5">
        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#addChapterFormCollapse" aria-expanded="false" aria-controls="addChapterFormCollapse">
            Add Book Content
        </button>
        <div class="collapse" id="addChapterFormCollapse">
           <form id="addChapterForm" action="/path/to/add-chapter.php" method="post">
    <input type="hidden" name="book_id" value="1"> <!-- Replace with your book_id -->
    <input type="hidden" name="chapter_number" value="1"> <!-- Replace with your chapter_number -->
    <textarea name="storyline">Your chapter storyline here.</textarea>
    <input type="text" name="affinity_requirement" value="neutral"> <!-- Replace with your affinity_requirement -->
    <button type="submit">Add Chapter</button>
</form>

        </div>
    </div>	
	 
	 <!-- Step 4: Book List -->
    <div class="mb-5">
        <h2>Book List</h2>
        <ul id="bookList" class="list-group">
            <!-- Book list items will be dynamically added here -->
        </ul>
        <div class="mt-3">
            <button type="button" class="btn btn-danger" onclick="removeSelectedBook()">Remove Selected Books</button>
            <button type="button" class="btn btn-primary" onclick="editSelectedBook()">Edit/Continue Selected Book</button>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
     // Define the loadContent function
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
    
///////////////////////////////////USER MANAGEMENT////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
	
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

 // Call the fetchList function on page load
    $(document).ready(function () {
        fetchUserList();
        fetchNewsList();
        fetchBookList();
    });

// Add User Section
$(document).ready(function () {
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
    function cancelEdit() {
        $('#editUserFormSection').hide();
        $('#userList').show();
    }

// Save changes
function saveChanges() {
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
//////////////////////////////////////////////////////////////////////////  
  
  
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
    function cancelEdit() {
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

//////////////////////////////BOOK MANAGEMENT////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

// Add Book Form
$(document).ready(function () {
    $('#addBookForm').submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '/book/admin-portal/books/add-book.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.message) {
                    alert(response.message);

                    if (response.bookId) {
                        // Debugging: Check if showBookPreferencesAfterAdd is called with the correct bookId
                        console.log('Book added successfully. BookId:', response.bookId);

                        showBookPreferencesAfterAdd(response.bookId);
                        fetchBookDetailsForEditing(response.bookId);
                    }
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }

                fetchBookList();
            },
            error: function (error) {
                console.error('Error adding book:', error);
            }
        });
    });
});

// Function to hide the add book form and show the book preferences form
function showBookPreferencesAfterAdd(bookId) {
    // Debugging: Check if showBookPreferencesAfterAdd is called with the correct bookId
    console.log('showBookPreferencesAfterAdd called with BookId:', bookId);

    // Hide the add book form
    $('#addBookFormCollapsible').collapse('hide');

    // Show the book preferences form
    showBookPreferencesForm(bookId);
}

// Function to show the book preferences form
function showBookPreferencesForm(bookId) {
    // Set the book ID in the bookPreferencesForm
    $('#bookPreferencesForm').data('bookId', bookId);

    // Remove the "display" style property to show the element
    $('#bookPreferencesForm').css('display', '');

    // Hide other sections
    $('#home, #userManagement, #newsManagement').hide();

    // Show book preferences form and book management
    $('#bookPreferencesForm, #bookManagement').show();
}


 // Fetch and display the list of books///////////////////////////////////
    function fetchBookList() {
        $.ajax({
            url: '/book/admin-portal/books/fetch-books.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Clear existing list
                $('#bookList').empty();

                // Display books in the list
                data.forEach(function (book) {
                    $('#bookList').append('<li class="list-group-item">' +
                        '<input type="checkbox" class="form-check-input" name="selectedBooks[]" value="' + book.book_id + '">' +
                        ' ' + book.title +
                        '</li>');
                });
            },
            error: function (error) {
                console.error('Error fetching book list:', error);
            }
        });
    }

// Function to fetch book details for editing
// Edit selected book////////////////////////////////////////////////////
function editSelectedBook() {
    // Get the selected book ID
    var selectedBookId = $("input[name='selectedBooks[]']:checked").val();

    if (selectedBookId !== undefined) {
        // Call the function to fetch book details for editing
        fetchBookDetailsForEditing(selectedBookId);

        // Note: Do not call the function to save book preferences here
    } else {
        alert("Please select a book to edit/continue.");
    }
}


// Function to fetch book details for editing////////////////////////////
function fetchBookDetailsForEditing(bookId) {
    $.ajax({
        url: '/book/admin-portal/books/fetch-book-details.php',
        method: 'GET',
        data: { book_id: bookId },
        dataType: 'json',
        success: function (bookData) {
            // Display the book details in the edit form
            $('#bookId').val(bookData.book_id);
            $('#title').val(bookData.title);
            $('#author').val(bookData.author);
            $('#year').val(bookData.year);
            $('#description').val(bookData.description);
            $('#imageUrl').val(bookData.image_url);
            $('#videoUrl').val(bookData.video_url);

            // Display the book preferences form
            showBookPreferencesForm(bookData.book_id);

            // Populate the book preferences form
            $('#targetAge').val(bookData.target_age);
            $('#genre').val(bookData.genre);
            $('#bookSize').val(bookData.book_size);
            $('#difficulty').val(bookData.difficulty);
            $('#containsMiniGames').val(bookData.contains_mini_games);
        },
        error: function (error) {
            console.error('Error fetching book details:', error);
        }
    });
}

// Remove selected book//////////////////////////////////////////////////
    function removeSelectedBook() {
        var selectedBooks = $("input[name='selectedBooks[]']:checked");

        if (selectedBooks.length > 0) {
            if (confirm('Are you sure you want to remove the selected book(s)?')) {
                // Proceed with removing the selected book(s)
                var bookIds = selectedBooks.map(function () {
                    return this.value;
                }).get();

                $.ajax({
                    url: '/book/admin-portal/books/remove-book.php',
                    method: 'POST',
                    data: {book_ids: bookIds},
                    dataType: 'json',
                    success: function (response) {
                        // Display success alert
                        alert(response.message);

                        // Refresh the book list after removal
                        fetchBookList();
                    },
                    error: function (error) {
                        console.error('Error:', xhr, status, error);
                    }
                });
            }
        } else {
            alert('Please select at least one book to remove.');
        }
    }


// Save changes to book preferences
function saveBookPreferences() {
    var bookId = $('#bookPreferencesForm').data('bookId');

    if (bookId !== undefined) {
        var formData = $('#bookPreferencesForm').serialize();
        formData += '&bookId=' + bookId;

        $.ajax({
            url: '/book/admin-portal/books/save-book-preferences.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.message) {
                    alert(response.message);
                    // Show the add chapter form after book preferences are saved
                    showAddChapterForm(bookId);
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }

                fetchBookList();
            },
            error: function (xhr, status, error) {
                console.error('Error saving book preferences:', xhr, status, error);
            }
        });
    } else {
        alert('Book ID is missing. Please select a book and try again.');
    }
}
// Function to show the add chapter form
function showAddChapterForm(bookId) {
    // Hide other sections
    $('#home, #userManagement, #newsManagement, #bookManagement').hide();

    // Show the add chapter form
    $('#addChapterFormSection').show();

    // Set the book ID in the add chapter form
    $('#addChapterForm').data('bookId', bookId);

    // Update any other elements in the add chapter form if needed
}

</script>
</div>
</body>
</html>
