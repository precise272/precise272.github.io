<?php
// add-book.php

// Database connection file
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

// Function to save a new book, add chapter 1, and page 1
function addNewBook($title, $author, $year, $description, $image_url, $video_url) {
    global $pdo;

    try {
        $pdo->beginTransaction();

        // Insert into the books table
        $stmt = $pdo->prepare("INSERT INTO books (title, author, year, description, image_url, video_url, deleted, live) VALUES (?, ?, ?, ?, ?, ?,'0','0')");
        $stmt->execute([$title, $author, $year, $description, $image_url, $video_url]);

        // Get the last inserted book ID
        $bookId = $pdo->lastInsertId();

        // Insert into the chapters table
        $stmt = $pdo->prepare("INSERT INTO chapters (book_id, chapter_number) VALUES (?, 1)");
        $stmt->execute([$bookId]);

        // Get the last inserted chapter ID
        $chapterId = $pdo->lastInsertId();

        // Insert into the pages table
        $stmt = $pdo->prepare("INSERT INTO pages (book_id, chapter_id, page_number) VALUES (?, ?, 1)");
        $stmt->execute([$bookId, $chapterId]);

        // Get the last inserted page ID
        $pageId = $pdo->lastInsertId();

        // Insert into the choices table
        $stmt = $pdo->prepare("INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page) VALUES (?, ?, ?, 'Default Choice', ?)");
        $stmt->execute([$bookId, $chapterId, $pageId, $pageId]);

        // Insert into the book_preferences table
        $stmt = $pdo->prepare("INSERT INTO book_preferences (book_id) VALUES (?)");
        $stmt->execute([$bookId]);

        $pdo->commit();

        // Return the last inserted book ID
        return $bookId;
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error adding new book: " . $e->getMessage();
    }
}

// Example usage
$response = array();

try {
    // Extract form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $video_url = $_POST['video_url'];

    // Call the function to save the new book
    $bookId = addNewBook($title, $author, $year, $description, $image_url, $video_url);

    // If the new book was added successfully, fetch its details for editing
    if (is_numeric($bookId) && $bookId > 0) {
        $bookDetails = fetchBookDetails($bookId);
        $response['bookDetails'] = $bookDetails;
        $response['message'] = "New book added successfully!";
    } else {
        $response['error'] = "Error adding new book. Invalid book ID.";
    }
} catch (PDOException $e) {
    $response['error'] = "Error adding new book: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
