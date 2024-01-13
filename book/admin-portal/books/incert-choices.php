<?php
// insert-choices.php
include_once('../dbconn.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterId = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : null;
$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : null;
$choiceText = isset($_POST['choice_text']) ? $_POST['choice_text'] : null;
$targetPage = isset($_POST['target_page']) ? $_POST['target_page'] : null;
$amountOfChoices = isset($_POST['amount_of_choices']) ? $_POST['amount_of_choices'] : 0;

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $pageId !== null && $choiceText !== null && $targetPage !== null) {
    try {
        // Insert the main choice
        $stmtInsert = $pdo->prepare("INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page, amount_of_choices) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtInsert->execute([$bookId, $chapterId, $pageId, $choiceText, $targetPage, $amountOfChoices]);
        
        // Get the last inserted choice_id
        $choiceId = $pdo->lastInsertId();

        // Insert additional choices
        for ($i = 1; $i <= $amountOfChoices; $i++) {
            $choiceTextKey = "choice_text_$i";
            $targetPageKey = "target_page_$i";
            $additionalChoiceText = isset($_POST[$choiceTextKey]) ? $_POST[$choiceTextKey] : null;
            $additionalTargetPage = isset($_POST[$targetPageKey]) ? $_POST[$targetPageKey] : null;

            $stmtInsertAdditional = $pdo->prepare("INSERT INTO choices_additional (choice_id, choice_text, target_page) VALUES (?, ?, ?)");
            $stmtInsertAdditional->execute([$choiceId, $additionalChoiceText, $additionalTargetPage]);
        }

        // Return success message
        echo json_encode(['message' => 'Choices saved successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving choices: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
