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

    <!-- Book List Section -->
	<div id="bookListSection">
        <h2>Book List</h2>
        <table id="bookListTable" class="table table-striped table-bordered">
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
            <button id="selectBookBtn" class="btn btn-primary" onclick="selectBook()">Select Book</button>
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
					<button type="button" id="saveEditedBookDetailsBtn" class="btn btn-primary">Save Changes</button>
					</form>
                </div>
      </div>
    </div>
  </div>

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
       <button type="button" id="saveEditedBookPreferencesBtn" class="btn btn-primary">Save Changes</button>

    </form>
        </div>
		
      </div>
    </div>
  </div>

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
            <table class="table-responsive" id="bookChaptersTable">
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
    </form>
</div>
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
        <button type="button" id="saveEditedBookPagesBtn" class="btn btn-primary" >Save Changes</button>
    </div>
</form>

                </div>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

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
//////////////////////////////BOOK MANAGEMENT/////////////////////////////////////////////

// Fetch and display the list of books
window.fetchBookList = function () {
    var endpoint = '/book/admin-portal/books/fetch-books.php';

    $.ajax({
        url: endpoint,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Clear existing table rows
            $('#bookListTable tbody').empty();

            data.forEach(function (book) {
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

                // Append the row to the book list table
                $("#bookListTable tbody").append(row);
            });
        },
        error: function (error) {
            console.error('Error fetching book list:', error);
        }
    });
};

// Function to refresh the book list
window.refreshBookList = function () {
        // Implement logic to refresh the book list
        // Make an AJAX request to fetch the book list from the server
        fetchBookList();
    };

// Function to save a new book
window.saveNewBook = function () {
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
            // Check if the server responded with success
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
        },
        error: function (error) {
            console.error('Error saving new book:', error);
            alert("Error saving new book. Please try again.");
        }
    });
};

// Function to select a book
window.selectBook = function () {
    // Find the selected radio button
    var selectedRadio = $('input[name="bookRadio"]:checked');

    // Check if a book is selected
    if (selectedRadio.length > 0) {
        // Get the book ID from the data attribute
        var bookId = selectedRadio.data('book-id');

        // Show the edit sections for the selected book
        showEditSections(bookId);
    } else {
        alert("Please select a book.");
    }
};// Function to show Create Book form

// function to create
window.showCreateBookForm = function () {
            // Reset the form values
            $("#createBookForm")[0].reset();
            // Open the modal
            $("#createBookModal").modal("show");
        };

// Function to show Edit sections
window.showEditSections = function (bookId) {
        // Hide book list and show edit sections
        $("#bookListSection").hide();
        $("#bookDetailsSection, #bookPreferencesSection, #chapterListSection").show();
 // Load book details, preferences, and chapters for the selected book
    loadBookDetails(bookId);
    loadBookPreferences(bookId);
    loadChapters(bookId);
    loadPages(bookId); 
    };

// Function to load book details for editing
function loadBookDetails(bookId) {
            // Implement logic to load book details from the database based on bookId
            // Populate the editBookForm with the loaded details
            // ...
        }

// Function to load book preferences for editing
function loadBookPreferences(bookId) {
            // Implement logic to load book preferences from the database based on bookId
            // Populate the editBookPreferencesForm with the loaded preferences
            // ...
        }

// Function to load chapters for editing
function loadChapters(bookId) {

 $('#bookChaptersBookId').val(bookId);
 
    $.ajax({
        url: '/book/admin-portal/books/fetch-selected-book-chapters.php',
        method: 'GET',
        data: { book_id: bookId },  // Pass the bookId
        dataType: 'json',
        success: function (bookChapters) {
            // Clear existing rows
            $('#bookChaptersTableBody').empty();

            $.each(bookChapters, function (key, value) {
                // Create input fields for editing
                var inputField;
                if (key === 'book_size') {
                    // Create a dropdown for Book Size
                    inputField = '<select class="form-control" name="' + key + '">' +
                        '<option value="Small">Small</option>' +
                        '<option value="Normal">Normal</option>' +
                        '<option value="Large">Large</option>' +
                        '</select>';
                } else if (key === 'difficulty') {
                    // Create a dropdown for Difficulty
                    inputField = '<select class="form-control" name="' + key + '">' +
                        '<option value="Easy">Easy</option>' +
                        '<option value="Normal">Normal</option>' +
                        '<option value="Hard">Hard</option>' +
                        '</select>';
                } else {
                    inputField = '<input type="text" class="form-control" value="' + value + '" name="' + key + '">';
                }
                // Create a row for book chapters with input fields
                var chaptersRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';
                // Append the row to the table
                $('#bookChaptersTableBody').append(chaptersRow);
            });
        },
        error: function (error) {
            console.error('Error fetching book chapters:', error);
        }
    });
}

// Function to load pages for editing 
/*
function loadPages(bookId) {

  $('#bookPagesBookId').val(bookId);
    $.ajax({
        url: '/book/admin-portal/books/fetch-selected-book-pages.php',
        method: 'GET',
        data: { book_id: bookId },  // Pass the bookId
        dataType: 'json',
        success: function (bookPages) {
            // Clear existing rows
            $('#bookPagesTableBody').empty();

            $.each(bookPages, function (key, value) {
                // Create input fields for editing
                var inputField;
                if (key === 'choices') {
                    // Create a dropdown for Book Size
                    inputField = '<select class="form-control" name="' + key + '">' +
                        '<option value="Small">2</option>' +
                        '<option value="Normal">3</option>' +
                        '<option value="Large">4</option>' +
                        '</select>';
                } 
				else {
                    inputField = '<input type="text" class="form-control" value="' + value + '" name="' + key + '">';
                }
                // Create a row for book pages with input fields
                var pagesRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';
                // Append the row to the table
                $('#bookPagesTableBody').append(pagesRow);
            });
        },
        error: function (error) {
            console.error('Error fetching book pages:', error);
        }
    });
}

*/
// Function to save edited book details
window.saveEditedBook = function () {
            // Implement logic to save the edited book details to the database
            // Update the UI accordingly
            // ...

            // For demonstration purposes, let's assume the book list is reloaded here
            refreshBookList();
        };

// Function to save edited book preferences
window.saveEditedBookPreferences = function () {
            // Implement logic to save the edited book preferences to the database
            // Update the UI accordingly
            // ...
        };

// Function to save edited chapters
window.saveEditedBookChapters = function () {
	 // Fetch the bookId from the hidden input field
    var bookId = $('#bookChaptersBookId').val();
    
    // Serialize the form data, including the chapters key
    var formData = $('#editBookChaptersForm').serialize() + '&chapters=' + JSON.stringify(/* chapters data here */);

    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-chapters.php',
        method: 'POST',
        data: { book_id: bookId },
        dataType: 'json',
        success: function (response) {
            if (response && response.message) {
                alert(response.message);
            } else if (response && response.error) {
                alert('Error: ' + response.error);
            } else {
                alert('An unknown error occurred while saving book chapters.');
            }
        },
        error: function (error) {
            console.error('Error saving book chapters:', error);
            alert('An error occurred while saving book chapters. Please try again.');
        }
    });
}

		

// Function to show book list and hide other sections
function showBookList() {
    $('#bookSelectionPage, #createBookSection, #chapterListSection, #bookDetailsSection, #bookPreferencesSection, #bookChapterssSection')
        .hide();
    $('#bookListSection').show();
}

// Function to be called when "Select Book" button is clicked
function selectBook() {
    // Assuming you have logic to determine when to show the book selection page
    // You can replace this condition with your actual logic
    var shouldShowBookSelectionPage = true;

    if (shouldShowBookSelectionPage) {
        showBookSelectionPage();
    } else {
        // Show other sections or perform other actions
        showBookList(); // For example, show book list as a default
    }
}
 
 // Load Book For Editing
 function loadBookDetails(bookId) {
        // Fetch book details from the server
$.ajax({
    url: '/book/admin-portal/books/fetch-selected-book.php',
    method: 'GET',
    data: { book_id: bookId },
    dataType: 'json',
    success: function (bookDetails) {
        // Clear existing table rows
        $('#bookDetailsTableBody').empty();

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
                $('#bookDetailsBookId').val(bookId);
            });
        } else {
            console.error('Received null or undefined book details from the server.');
        }
    },
    error: function (error) {
        console.error('Error fetching book details:', error);
    }
});

     // Fetch book preferences from the server
$.ajax({
    url: '/book/admin-portal/books/fetch-selected-book-preferences.php',
    method: 'GET',
    data: { book_id: bookId },
    dataType: 'json',
    success: function (bookPreferences) {
        // Clear existing rows
        $('#bookPreferencesTableBody').empty();

        // Iterate over each key-value pair in book preferences
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
            } else if (key == 'difficulty') {
                // Create a dropdown for Book Size
                inputField = '<select class="form-control" id="' + inputId + '" name="' + key + '">' +
                    '<option value="Easy">Easy</option>' +
                    '<option value="Normal">Normal</option>' +
                    '<option value="Hard">Hard</option>' +
                    '</select>';
            } else {
                inputField = '<input type="text" class="form-control" id="' + inputId + '" value="' + value + '" name="' + key + '">';
            }

            // Create a row for book preferences with input fields
            var preferencesRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';

            // Append the row to the table
            $('#bookPreferencesTableBody').append(preferencesRow);
				}
        });

        // Set the value of the hidden input field with the book ID
        $('#bookPreferencesBookId').val(bookId);
    },
    error: function (error) {
        console.error('Error fetching book preferences:', error);
    }
});

		
// Fetch book chapters from the server
 $.ajax({
    url: '/book/admin-portal/books/fetch-selected-book-chapters.php',
    method: 'GET',
    data: { book_id: $('#bookChaptersBookId').val() },  // Use the hidden input field
    dataType: 'json',
    success: function (bookChapters) {
                // Clear existing rows
                $('#bookChaptersTableBody').empty();

               $.each(bookChapters, function (key, value) {
                    // Create input fields for editing
                    var inputField;
                    if (key === 'book_size'){
                        // Create a dropdown for Book Size
                        inputField = '<select class="form-control" name="' + key + '">' +
                            '<option value="Small">Small</option>' +
                            '<option value="Normal">Normal</option>' +
                            '<option value="Large">Large</option>' +
                            '</select>';
                    } else if
					(key == 'difficulty'){
                        // Create a dropdown for Book Size
                        inputField = '<select class="form-control" name="' + key + '">' +
                            '<option value="Small">Easy</option>' +
                            '<option value="Normal">Normal</option>' +
                            '<option value="Large">Hard</option>' +
                            '</select>';
                    } else
					
					{
                        inputField = '<input type="text" class="form-control" value="' + value + '" name="' + key + '">';
                    }
                    // Create a row for book chapters with input fields
                    var chaptersRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';
                    // Append the row to the table
                    $('#bookChaptersTableBody').append(chaptersRow);
                });
            },
            error: function (error) {
                console.error('Error fetching book chapters:', error);
            }
		});
				
// Fetch book pages from the server
 $.ajax({
    url: '/book/admin-portal/books/fetch-selected-book-pages.php',
    method: 'GET',
    data: { book_id: $('#bookPagesBookId').val() },  // Use the hidden input field
    dataType: 'json',
    success: function (bookPages) {
                // Clear existing rows
                $('#bookPagesTableBody').empty();

               $.each(bookPages, function (key, value) {
                    // Create input fields for editing
                    var inputField;
                    if (key === 'book_size'){
                        // Create a dropdown for Book Size
                        inputField = '<select class="form-control" name="' + key + '">' +
                            '<option value="Small">Small</option>' +
                            '<option value="Normal">Normal</option>' +
                            '<option value="Large">Large</option>' +
                            '</select>';
                    } else if
					(key == 'difficulty'){
                        // Create a dropdown for Book Size
                        inputField = '<select class="form-control" name="' + key + '">' +
                            '<option value="Small">Easy</option>' +
                            '<option value="Normal">Normal</option>' +
                            '<option value="Large">Hard</option>' +
                            '</select>';
                    } else
					
					{
                        inputField = '<input type="text" class="form-control" value="' + value + '" name="' + key + '">';
                    }
                    // Create a row for book chapters with input fields
                    var pagesRow = '<tr class="table-active"><td>' + key + '</td><td>' + inputField + '</td></tr>';
                    // Append the row to the table
                    $('#bookPagesTableBody').append(pagesRow);
                });
            },
            error: function (error) {
                console.error('Error fetching book pages:', error);
            }
		});
		
 }
 
$('#saveEditedBookDetailsBtn').on('click', saveEditedBookDetails);

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
            if (response && response.message) {
                // Display a success message
                alert(response.message);
            } else if (response && response.error) {
                // Display an error message
                alert('Error: ' + response.error);
            } else {
                // Display a generic error message
                alert('An unknown error occurred while saving book details.');
            }
        },
        error: function (error) {
            console.error('Error saving book details:', error);
            alert('An error occurred while saving book details. Please try again.');
        }
    });
}

$('#saveEditedBookPreferencesBtn').on('click', saveEditedBookPreferences);
// Function to save edited book preferences
function saveEditedBookPreferences() {
    // Fetch the book ID from the hidden input field
    var bookId = $('#bookPreferencesBookId').val();

console.log('Save button clicked!');

    // Prepare data for the AJAX request
    var formData = $('#editBookPreferencesForm').serialize();
	
    // Send AJAX request to save edited book preferences
    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-preferences.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response && response.message) {
                // Display a success message
                alert(response.message);
            } else if (response && response.error) {
                // Display an error message
                alert('Error: ' + response.error);
            } else {
                // Display a generic error message
                alert('An unknown error occurred while saving book preferences.');
            }
        },
        error: function (error) {
            console.error('Error saving book preferences:', error);
            alert('An error occurred while saving book preferences. Please try again.');
        }
    });
}

$('#saveEditedBookPagesBtn').on('click', saveEditedBookPages);
// Function to save edited book pages
function saveEditedBookPages() {
    // Fetch the book ID from the hidden input field
    var bookId = $('#bookPagesBookId').val();

    console.log('Book ID: ' + bookId);

    // Prepare data for the AJAX request
    var formData = $('#editBookPagesForm').serialize();

    // Send AJAX request to save edited book pages
    $.ajax({
        url: '/book/admin-portal/books/save-edited-book-pages.php', 
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response && response.message) {
                // Display a success message
                alert(response.message);
            } else if (response && response.error) {
                // Display an error message
                alert('Error: ' + response.error);
            } else {
                // Display a generic error message
                alert('An unknown error occurred while saving book pages.');
            }
        },
        error: function (error) {
            
            alert('An error occurred while saving book pages. Please try again.');
        }
    });
}


// Call the fetchList function on page load
fetchUserList();
fetchNewsList();
fetchBookList();
});
</script>
</div>
</body>
</html>
