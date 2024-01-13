<?php
require_once('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editUserId = $_POST['editUserId'];

    $sql = "SELECT * FROM users WHERE user_id = $editUserId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();

        // Display user details in a form for editing
        echo "<form id='saveChangesForm' action='save-changes.php' method='post'>";
        echo "<div class='mb-3'><label for='editUsername' class='form-label'>Username</label>";
        echo "<input type='text' class='form-control' id='editUsername' name='editUsername' value='{$userDetails['username']}' required></div>";
        // Add more fields as needed
        echo "<button type='submit' class='btn btn-success'>Save Changes</button>";
        echo "<input type='hidden' name='editUserId' value='$editUserId'>";
        echo "</form>";
    } else {
        echo "User not found!";
    }
} else {
    echo "Invalid request!";
}
?>
