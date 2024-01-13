<?php
// add-choices.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Add debug logs at the beginning of the script
error_log('Received POST data: ' . print_r($_POST, true));

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterId = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : null;
$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : null;
$choiceText = isset($_POST['choice_text']) ? $_POST['choice_text'] : null;
$targetPage = isset($_POST['target_page']) ? $_POST['target_page'] : null;

// Check if any required parameter is missing
if ($pageId !== null && $targetPage !== null) {
    try {
        // Check if there's an existing entry with a NULL or default choice text for the same page ID
        $existingEntrySql = "SELECT * FROM choices WHERE page_id = ?";
        $stmtExistingEntry = $pdo->prepare($existingEntrySql);
        $stmtExistingEntry->execute([$pageId]);
        $existingEntries = $stmtExistingEntry->fetchAll(PDO::FETCH_ASSOC);

        if (count($existingEntries) > 0) {
            // Find the first column with NULL or default choice text
            $firstNullOrDefaultColumn = null;
            foreach ($existingEntries[0] as $column => $value) {
                if (strpos($column, 'choice_text') === 0 && ($value === null || $value === 'Default Choice')) {
                    $firstNullOrDefaultColumn = $column;
                    break;
                }
            }

            if ($firstNullOrDefaultColumn !== null) {
                // Update the existing entry with the new choice
                $updateSql = "UPDATE choices SET $firstNullOrDefaultColumn = ?, target_page = ? WHERE page_id = ?";
                $stmtUpdate = $pdo->prepare($updateSql);
                $stmtUpdate->execute([$choiceText, $targetPage, $pageId]);
            } else {
                // Return an error message indicating max choices are used for the page
                echo json_encode(['error' => 'Max choices used for the page.']);
                exit;
            }
        } else {
            // Return an error message indicating max choices are used for the page
            echo json_encode(['error' => 'Max choices used for the page.']);
            exit;
        }

        // Return success message
        echo json_encode(['message' => 'New choice saved successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving new choice: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
