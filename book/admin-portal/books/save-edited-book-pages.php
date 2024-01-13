<?php
// save-book-pages.php

// Include the database connection file
include_once "../dbconn.php";


// Function to fetch book details by book ID
function fetchBookDetails($bookId) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE book_id = ?");
        $stmt->execute([$bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching book details: " . $e->getMessage());
    }
}
// Example usage
$response = array();

try {
    // Function to save or update book pages in the database
    function saveBookPages($bookId, $pageId, $chapterId, $pageNumber, $content, $choices) {
        global $pdo;

        try {
            // Check if the book_id exists in the books table
            $stmtCheckBook = $pdo->prepare("SELECT COUNT(*) FROM books WHERE book_id = ?");
            $stmtCheckBook->execute([$bookId]);
            $bookExists = $stmtCheckBook->fetchColumn();

            if ($bookExists) {
                // Continue with saving or updating book pages
                $stmtCheckPage = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE book_id = ?");
                $stmtCheckPage->execute([$bookId]);
                $pageExists = $stmtCheckPage->fetchColumn();

                if ($pageExists) {
                    // If a record exists, update it
                    $stmtUpdate = $pdo->prepare("UPDATE pages SET chapter_id = ?, page_number = ?, content = ?, choices = ? WHERE book_id = ?");
                    $stmtUpdate->execute([$chapterId, $pageNumber, $content, $choices, $bookId]);
                    return "Book pages updated successfully!";
                } else {
                    // If no record exists, insert a new one
                    $stmtInsert = $pdo->prepare("INSERT INTO pages (book_id, chapter_id, page_number, content, choices) VALUES (?, ?, ?, ?, ?)");
                    $stmtInsert->execute([$bookId, $chapterId, $pageNumber, $content, $choices]);
                    return "New book pages inserted successfully!";
                }
            } else {
                return "Error: The specified book_id does not exist in the books table. Book ID: " . $bookId;
            }
        } catch (PDOException $e) {
            return "Error saving or updating book pages: " . $e->getMessage();
        }
    }

    // Extract book ID from the request
    $bookId = isset($_POST['bookId']) ? $_POST['bookId'] : null;

    // Extract other form data
    $pageId = $_POST['pageId'];
    $chapterId = $_POST['chapterId'];
    $pageNumber = $_POST['pageNumber'];
    $content = $_POST['content'];
    $choices = $_POST['choices'];

    // Call the function and get the result message
    $resultMessage = saveBookPages($bookId, $pageId, $chapterId, $pageNumber, $content, $choices);
    $response['message'] = $resultMessage;

    // If book ID is available, fetch book details for editing
    if ($bookId) {
        $bookDetails = fetchBookDetails($bookId);
        $response['bookDetails'] = $bookDetails;
    }
} catch (PDOException $e) {
    $response['error'] = "Error saving book pages: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
