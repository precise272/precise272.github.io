<?php
// remove-user.php

// Initialize the response array
$response = array("success" => false, "message" => "Failed to remove user(s)");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_ids"])) {
    // Include your database connection code here
    include('../dbconn.php');

    // Get user IDs from the POST data
    $userIds = $_POST["user_ids"];

    // Sanitize and validate user IDs (you should perform more validation in a real-world scenario)
    $userIds = array_map('intval', $userIds);

    // Prepare the SQL statement to delete users
    $sql = "DELETE FROM users WHERE user_id IN (" . implode(",", $userIds) . ")";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        $response["success"] = true;
        $response["message"] = "User(s) removed successfully";
    } else {
        $response["message"] = "Error removing user(s): " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle invalid or missing parameters
    $response["message"] = "Invalid request";
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
