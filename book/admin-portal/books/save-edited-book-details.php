<?php
// save-edited-book-details.php

// database connection file
include_once "../dbconn.php";

// Function to fetch book details by book ID
function fetchBookDetails($bookId) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
        $stmt->execute([$bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching book details: " . $e->getMessage());
    }
}

// Function to update existing book details
function updateBookDetails($bookId, $title, $author, $year, $description, $image_url, $video_url, $deleted, $live) {
    global $pdo;

    try {
        // Update the books table
        $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, year = ?, description = ?, image_url = ?, video_url = ?, deleted = ?, live = ? WHERE book_id = ?");
        $stmt->execute([$title, $author, $year, $description, $image_url, $video_url, $deleted, $live, $bookId]);

        // Return the updated book ID
        return $bookId;
    } catch (PDOException $e) {
        return "Error updating book details: " . $e->getMessage();
    }
}
// Example usage
$response = array();

try {
    // Extract form data
    $bookId = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $video_url = $_POST['video_url'];
	$deleted = $_POST['deleted'];
    $live = $_POST['live'];

    // Call the function to update book details
    $updatedBookId = updateBookDetails($bookId, $title, $author, $year, $description, $image_url, $video_url, $deleted, $live);

    // If the book details were updated successfully, fetch its details for confirmation
    if (is_numeric($updatedBookId) && $updatedBookId > 0) {
        $bookDetails = fetchBookDetails($updatedBookId);
        $response['bookDetails'] = $bookDetails;
        $response['message'] = "Book details updated successfully!";
    } else {
        $response['error'] = "Error updating book details. Invalid book ID.";
    }
} catch (PDOException $e) {
    $response['error'] = "Error updating book details: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
