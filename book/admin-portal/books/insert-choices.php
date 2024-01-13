<?php
// insert-choices.php
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
$amountOfChoices = isset($_POST['amount_of_choices']) ? $_POST['amount_of_choices'] : null;
$choices = isset($_POST['choices']) ? $_POST['choices'] : null;

// Display received data in the console
echo "<script>";
echo "console.log('Received bookId: " . $bookId . "');";
echo "console.log('Received chapterId: " . $chapterId . "');";
echo "console.log('Received pageId: " . $pageId . "');";
echo "console.log('Received amountOfChoices: " . $amountOfChoices . "');";
echo "console.log('Received choices: " . json_encode($choices) . "');";
echo "</script>";

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $pageId !== null && $amountOfChoices !== null && $choices !== null) {
    try {
        // Prepare the SQL statement based on the number of choices
        $sql = "INSERT INTO choices (book_id, chapter_id, page_id, choice_text, target_page";
        for ($i = 1; $i <= $amountOfChoices; $i++) {
            $sql .= ", choice_text_$i, target_page_$i";
        }
        $sql .= ") VALUES (?, ?, ?, ?";
        for ($i = 1; $i <= $amountOfChoices; $i++) {
            $sql .= ", ?, ?";
        }
        $sql .= ")";

        // Insert choices into the database
        $stmtInsert = $pdo->prepare($sql);
        $params = array_merge([$bookId, $chapterId, $pageId], array_column($choices, 'text'), array_column($choices, 'targetPage'));
        $stmtInsert->execute($params);

        // Return success message
        echo json_encode(['message' => 'New choices saved successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving new choices: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
