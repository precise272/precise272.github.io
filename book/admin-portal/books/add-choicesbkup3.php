<?php
// add-choices.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterId = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : null;
$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : null;
$choiceText = isset($_POST['choice_text']) ? $_POST['choice_text'] : null;

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $pageId !== null && $choiceText !== null) {
    try {
        // Insert into the choices table
        $stmtChoice = $pdo->prepare("INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page) VALUES (?, ?, ?, ?, ?)");
        $stmtChoice->execute([$bookId, $chapterId, $pageId, $choiceText, 0]); // Assuming target_page is 0 for now

        // Get the last inserted choice ID
        $choiceId = $pdo->lastInsertId();

        // Return success message with choice_id
        $response = ['error' => null, 'message' => 'Choice saved successfully.', 'choice_id' => $choiceId];
        echo json_encode($response);
    } catch (PDOException $e) {
        // Return error message
        $response = ['error' => 'Error saving new choice: ' . $e->getMessage(), 'message' => null, 'choice_id' => null];
        echo json_encode($response);
    }
} else {
    // Return an error response
    $response = ['error' => 'Missing parameters in the request.', 'message' => null, 'choice_id' => null];
    echo json_encode($response);
}
?>
