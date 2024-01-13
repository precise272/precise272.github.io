<?php
// edit-book.php

// Include the database connection file
include_once "../dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $bookId = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $imageUrl = filter_input(INPUT_POST, 'imageUrl', FILTER_SANITIZE_STRING);
    $videoUrl = filter_input(INPUT_POST, 'videoUrl', FILTER_SANITIZE_STRING);

    // Validate numeric values
    if ($bookId === false || $year === false) {
        echo json_encode(['error' => 'Invalid book ID or year format']);
        exit;
    }

    // Database update code (use your database connection and query)
    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE books SET title=?, author=?, year=?, description=?, image_url=?, video_url=? WHERE book_id=?";
    $stmt = $pdo->prepare($sql);
	$stmt->bindParam(1, $bookId, PDO::PARAM_INT);
    $stmt->bindParam(2, $title, PDO::PARAM_STR);
    $stmt->bindParam(3, $author, PDO::PARAM_STR);
    $stmt->bindParam(4, $year, PDO::PARAM_INT);
    $stmt->bindParam(5, $description, PDO::PARAM_STR);
    $stmt->bindParam(6, $imageUrl, PDO::PARAM_STR);
    $stmt->bindParam(7, $videoUrl, PDO::PARAM_STR);
	
    if ($stmt->execute()) {
        $response = ['message' => 'Book updated successfully'];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Error updating book']);
    }

    // Close the statement
    $stmt->closeCursor();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
