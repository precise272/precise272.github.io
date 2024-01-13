<?php
// fetch-news-details.php

// Include the database connection file
include_once "../dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate and sanitize input data
    $newsId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($newsId !== false && $newsId !== null) {
        // Database select code (use your database connection and query)
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM news WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $newsId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $newsDetails = $result->fetch_assoc();
            echo json_encode($newsDetails);
        } else {
            echo json_encode(array('error' => 'News article not found'));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array('error' => 'Invalid news ID'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
