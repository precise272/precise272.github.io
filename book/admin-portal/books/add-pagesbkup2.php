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
$choiceId = isset($_POST['choice_id']) ? $_POST['choice_id'] : null;

error_log('Received bookId: ' . $bookId);
error_log('Received chapterId: ' . $chapterId);
error_log('Received pageNumber: ' . $pageNumber);
error_log('Received content: ' . $content);
error_log('Received choiceId: ' . $choiceId);

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $pageNumber !== null && $content !== null && $choiceId !== null) {
    try {
        // Check if a record already exists for the given page number, chapter ID, and book ID
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE book_id = ? AND chapter_id = ? AND page_number = ?");
        $stmtCheck->execute([$bookId, $chapterId, $pageNumber]);
        $pageExists = $stmtCheck->fetchColumn();

        if (!$pageExists) {
            // If the page does not exist, create a new page
            $stmtPage = $pdo->prepare("INSERT INTO pages (book_id, chapter_id, page_number, content) VALUES (?, ?, ?, ?)");
            $stmtPage->execute([$bookId, $chapterId, $pageNumber, $content]);

            // Get the last inserted page ID
            $pageId = $pdo->lastInsertId();

            // Find the next null or 'Default Choice' choice text field
            $stmtFindChoice = $pdo->prepare("SELECT choice_id FROM choices WHERE book_id = ? AND chapter_id = ? AND page_id = ? AND (choice_text IS NULL OR choice_text = 'Default Choice') ORDER BY choice_id LIMIT 1");
            $stmtFindChoice->execute([$bookId, $chapterId, $pageId]);
            $row = $stmtFindChoice->fetch(PDO::FETCH_ASSOC);

            // Insert into the choices table
            if ($row) {
                $existingChoiceId = $row['choice_id'];
                $stmtChoice = $pdo->prepare("UPDATE choices SET choice_text = ? WHERE choice_id = ?");
                $stmtChoice->execute([$choiceId, $existingChoiceId]);
            } else {
                $stmtChoice = $pdo->prepare("INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page) VALUES (?, ?, ?, ?, ?)");
                $stmtChoice->execute([$bookId, $chapterId, $pageId, $choiceId, $pageNumber]);
            }

            // Return success message
            $response = ['error' => null, 'message' => 'New page and choice saved successfully.', 'page_number' => (int)$pageNumber];
            error_log('Response to client: ' . json_encode($response)); // Log the response to the server error log
            echo json_encode($response);
        } else {
            // Page already exists, return an error response
            $response = ['error' => 'Page already exists for the given book, chapter, and page number.', 'message' => null, 'page_number' => null];
            error_log('Response to client: ' . json_encode($response)); // Log the response to the server error log
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Return error message
        $response = ['error' => 'Error saving new page: ' . $e->getMessage(), 'message' => null, 'page_number' => null];
        error_log('Response to client: ' . json_encode($response)); // Log the response to the server error log
        echo json_encode($response);
    }
} else {
    // Return an error response
    $response = ['error' => 'Missing parameters in the request.', 'message' => null, 'page_number' => null];
    error_log('Response to client: ' . json_encode($response)); // Log the response to the server error log
    echo json_encode($response);
}
?>
