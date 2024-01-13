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

// Convert choice ID to int if it's not already
$choiceId = is_numeric($choiceId) ? (int)$choiceId : null;

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

        if ($pageExists) {
            // If the page already exists, increment the page number until a unique page number is found
            do {
                $pageNumber++;
                $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE book_id = ? AND chapter_id = ? AND page_number = ?");
                $stmtCheck->execute([$bookId, $chapterId, $pageNumber]);
                $pageExists = $stmtCheck->fetchColumn();
            } while ($pageExists);
        }

        // Insert a new record into the pages table
        $stmtInsert = $pdo->prepare("INSERT INTO pages (book_id, chapter_id, page_number, content, choice_id) VALUES (?, ?, ?, ?, ?)");
        $stmtInsert->execute([$bookId, $chapterId, $pageNumber, $content, $choiceId]);

        // Get the last inserted page ID
        $pageId = $pdo->lastInsertId();

        // Find the next null or 'Default Choice' choice text field for the given page
        $stmtFindChoice = $pdo->prepare("SELECT choice_id FROM choices WHERE book_id = ? AND chapter_id = ? AND page_id = ? AND (choice_text IS NULL OR choice_text = 'Default Choice') ORDER BY choice_id LIMIT 1");
        $stmtFindChoice->execute([$bookId, $chapterId, $pageId]);
        $row = $stmtFindChoice->fetch(PDO::FETCH_ASSOC);

        // Insert into the choices table
        if ($row) {
            $existingChoiceId = $row['choice_id'];
            $stmtChoice = $pdo->prepare("UPDATE choices SET choice_text = ? WHERE choice_id = ?");
            $stmtChoice->execute([$content, $existingChoiceId]);
        } else {
            $stmtChoice = $pdo->prepare("INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page) VALUES (?, ?, ?, ?, ?)");
            $stmtChoice->execute([$bookId, $chapterId, $pageId, $content, $pageNumber]);
            $existingChoiceId = $pdo->lastInsertId();
        }

        // Return success message along with the choice ID
        echo json_encode(['message' => 'New page and choice saved successfully.', 'choice_id' => $existingChoiceId]);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving new page: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
