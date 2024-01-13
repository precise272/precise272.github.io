<?php
// fetch-book-chapters.php

// Check if the book_id parameter is set
if (isset($_GET['book_id'])) {
    // Sanitize the input (to prevent SQL injection, etc.)
    $bookId = filter_var($_GET['book_id'], FILTER_SANITIZE_NUMBER_INT);
	
	include_once('../dbconn.php');
    
	$query = "SELECT * FROM chapters WHERE book_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$bookId]);

    // Fetch the details
    $bookChapterss = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the details as JSON
    header('Content-Type: application/json');
    echo json_encode($bookChapterss);
} else {
    // If book_id parameter is not set, return an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request. Please provide a book_id parameter.']);
}
?>
