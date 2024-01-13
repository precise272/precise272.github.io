<?php
//add-pages.php
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

error_log('Received bookId: ' . $bookId);
error_log('Received chapterId: ' . $chapterId);
error_log('Received pageNumber: ' . $pageNumber);
error_log('Received content: ' . $content);

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $pageNumber !== null && $content !== null) {
    try {
        // Check if a record already exists for the given page number, chapter ID, and book ID
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE book_id = ? AND chapter_id = ? AND page_number = ?");
        $stmtCheck->execute([$bookId, $chapterId, $pageNumber]);
        $pageExists = $stmtCheck->fetchColumn();

        if ($pageExists) {
            // If the page already exists, increment the page number until a unique page number is found
            do {
                $pageNumber++;
                $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE book_id = ? AND chapter_id = ? AND page_number = ?");
                $stmtCheck->execute([$bookId, $chapterId, $pageNumber]);
                $pageExists = $stmtCheck->fetchColumn();
            } while ($pageExists);

            // Return the updated page number
            echo json_encode(['message' => 'Page number incremented.', 'page_number' => $pageNumber]);
        } else {
            // If the page does not exist, insert a new record
            $stmtInsert = $pdo->prepare("INSERT INTO pages (book_id, chapter_id, page_number, content) VALUES (?, ?, ?, ?)");
            $stmtInsert->execute([$bookId, $chapterId, $pageNumber, $content]);

            // Get the last inserted page ID
            $pageId = $pdo->lastInsertId();

            // Insert into the choices table
            $stmtChoice = $pdo->prepare("INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page) VALUES (?, ?, ?, 'Default Choice', ?)");
            $stmtChoice->execute([$bookId, $chapterId, $pageId, $pageId]);

            // Return success message
            echo json_encode(['message' => 'New page and choices saved successfully.']);
        }
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving new page: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
