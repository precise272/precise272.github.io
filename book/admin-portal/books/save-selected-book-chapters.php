<?php
// save-edited-book-chapters.php

// Include the database connection file
include_once "../dbconn.php";

// Function to update existing book chapters
function updateBookChapters($bookId, $chapters) {
    global $pdo;

    try {
        $pdo->beginTransaction();

        // Iterate over each chapter
        foreach ($chapters as $chapter) {
            $chapterId = $chapter['chapter_id'];
            $title = $chapter['title'];
            // Add more fields as needed

            // Update the chapters table
            $stmt = $pdo->prepare("UPDATE chapters SET title = ? WHERE chapter_id = ?");
            $stmt->execute([$title, $chapterId]);
            // Add more fields as needed
        }

        $pdo->commit();

        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error updating book chapters: " . $e->getMessage();
    }
}

// Example usage
$response = array();

try {
    // Extract form data
    $bookId = $_POST['book_id'];
    $chapters = $_POST['chapters'];

    // Call the function to update book chapters
    $success = updateBookChapters($bookId, $chapters);

    if ($success === true) {
        $response['message'] = "Book chapters updated successfully!";
    } else {
        $response['error'] = $success;
    }
} catch (PDOException $e) {
    $response['error'] = "Error updating book chapters: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
