<?php
include 'dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if Edit Selected Users button is clicked
    if (isset($_POST['editUsers'])) {
        $selectedUsers = $_POST['selectedUsers'];

        // Redirect to edit-user.php with selected user ID
        header("Location: edit-user.php?userId=" . implode(',', $selectedUsers));
        exit();
    }

    // Check if Remove Selected Users button is clicked
    if (isset($_POST['removeUsers'])) {
        $selectedUsers = $_POST['selectedUsers'];

        // Remove selected users from the database
        $sql = "DELETE FROM users WHERE user_id IN (" . implode(',', $selectedUsers) . ")";
        $conn->query($sql);
        
        // Redirect back to the main admin portal
        header("Location: admin-portal.html");
        exit();
    }
}

$conn->close();
?>
