<?php
// Include the database connection file (dbconn.php)
require_once 'dbconn.php';

// Check if data is provided in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract user_id and other fields from the POST data
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $newUsername = mysqli_real_escape_string($conn, $_POST['new_username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['new_email']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
	$newGender = mysqli_real_escape_string($conn, $_POST['new_gender']);
    $newFullName = mysqli_real_escape_string($conn, $_POST['new_full_name']);
    $newDateOfBirth = mysqli_real_escape_string($conn, $_POST['new_date_of_birth']);
    $newCountry = mysqli_real_escape_string($conn, $_POST['new_country']);

    // Initialize an array to store the fields to be updated
    $updateFields = [];

    // Check if each field is set and not empty, add to the updateFields array
    if (!empty($newUsername)) {
        $updateFields[] = "username = '$newUsername'";
    }

    if (!empty($newEmail)) {
        $updateFields[] = "email = '$newEmail'";
    }

    if (!empty($newPassword)) {
        $updateFields[] = "password_hash = '$newPassword'";
    }
	
	 if (!empty($newGender)) {
        $updateFields[] = "gender = '$newGender'";
    }

    if (!empty($newFullName)) {
        $updateFields[] = "name = '$newFullName'";
    }

    if (!empty($newDateOfBirth)) {
        $updateFields[] = "age = '$newDateOfBirth'";
    }

    if (!empty($newCountry)) {
        $updateFields[] = "country = '$newCountry'";
    }

    // Build the SQL query based on the fields to be updated
    $updateQuery = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE user_id = $userId";

    // Execute the update query
    if (mysqli_query($conn, $updateQuery)) {
        echo "Changes saved successfully!";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If not a POST request, respond with an error
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
