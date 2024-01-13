<?php
// save-edited-book-pages.php

// Include the database connection file
include_once "../dbconn.php";

// Function to update existing book pages
function updateBookPages($bookId, $pages) {
    global $pdo;

    try {
        $pdo->beginTransaction();

        // Iterate over each page
        foreach ($pages as $page) {
            $pageId = $page['page_id'];
            $title = $page['title'];
            // Add more fields as needed

            // Update the pages table
            $stmt = $pdo->prepare("UPDATE pages SET title = ? WHERE page_id = ?");
            $stmt->execute([$title, $pageId]);
            // Add more fields as needed
        }

        $pdo->commit();

        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        return "Error updating book pages: " . $e->getMessage();
    }
}

// Example usage
$response = array();

try {
    // Extract form data
    $bookId = $_POST['book_id'];
    $pages = $_POST['pages'];

    // Call the function to update book pages
    $success = updateBookPages($bookId, $pages);

    if ($success === true) {
        $response['message'] = "Book pages updated successfully!";
    } else {
        $response['error'] = $success;
    }
} catch (PDOException $e) {
    $response['error'] = "Error updating book pages: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
