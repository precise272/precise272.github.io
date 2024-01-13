<?php
// fetch-user-details.php

// Include the database connection file
include_once "../dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate and sanitize input data
    $userId = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);

    if ($userId !== false && $userId !== null) {
        // Database select code (use your database connection and query)
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array('error' => 'User not found'));
        }

        // Close the statement
        $stmt->closeCursor();
    } else {
        echo json_encode(array('error' => 'Invalid user ID'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
