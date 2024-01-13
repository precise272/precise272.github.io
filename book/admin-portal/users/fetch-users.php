<?php
// Include the database connection file (dbconn.php)
require_once '../dbconn.php';

// Fetch the list of users from the database
$query = "SELECT * FROM users";
$result = $pdo->query($query);

// Check if the query was successful
if ($result) {
    $users = [];

    // Fetch user data and add to the users array
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }

    // Send the users array as JSON response
    header('Content-Type: application/json');
    echo json_encode($users);
} else {
    // If the query failed, send an error response
    http_response_code(500);
    echo json_encode(['error' => 'Error fetching users.']);
}
?>

