<?php
// Include the database connection file (dbconn.php)
require_once 'dbconn.php';

// Check if user_id is provided in the query string
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch user details from the database based on user_id
    $query = "SELECT * FROM users WHERE user_id = $userId";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Display the user details for editing
        // (You need to implement the HTML form for editing here)
        // ...

    } else {
        // If the query failed, redirect to the admin portal with an error message
        header('Location: admin-portal.html?error=edit_failed');
        exit();
    }
} else {
    // If user_id is not provided, redirect to the admin portal
    header('Location: admin-portal.html');
    exit();
}
?>
