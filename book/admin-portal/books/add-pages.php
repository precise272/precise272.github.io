<?php
// add-pages.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Add debug logs at the beginning of the script
error_log('Received POST data: ' . print_r($_POST, true));

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterId = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : null;
$pageNumber = isset($_POST['page_number']) ? $_POST['page_number'] : null;
$content = isset($_POST['content']) ? $_POST['content'] : null;

// Additional error logs for data verification
error_log('Received bookId: ' . $bookId);
error_log('Received chapterId: ' . $chapterId);
error_log('Received pageNumber: ' . $pageNumber);
error_log('Received content: ' . $content);

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $pageNumber !== null && $content !== null) {
    try {
        // Insert a new record into the pages table
        $stmtInsertPage = $pdo->prepare("INSERT INTO pages (book_id, chapter_id, page_number, content) VALUES (?, ?, ?, ?)");
        $stmtInsertPage->execute([$bookId, $chapterId, $pageNumber, $content]);

        // Get the last inserted page ID
        $pageId = $pdo->lastInsertId();

        // Return success message along with the page ID
        echo json_encode(['message' => 'New page saved successfully.', 'page_id' => $pageId]);
    } catch (PDOException $e) {
        // Return error message
        $errorMessage = 'Error saving new page: ' . $e->getMessage();
        echo json_encode(['error' => $errorMessage]);

        // Additional error logs
        error_log($errorMessage);
        error_log('Error in file: ' . $e->getFile());
        error_log('Error on line: ' . $e->getLine());
        error_log('Trace: ' . $e->getTraceAsString());
    }
} else {
    // Return an error response
    $errorMessage = 'Missing parameters in the request.';
    echo json_encode(['error' => $errorMessage]);

    // Additional error log
    error_log($errorMessage);
}
?>
