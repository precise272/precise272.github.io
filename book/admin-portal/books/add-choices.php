<?php
// add-choices.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Add debug logs at the beginning of the script
error_log('Received POST data: ' . print_r($_POST, true));

// Collect data from the POST request
$choiceId = isset($_POST['choiceId']) ? $_POST['choiceId'] : null;
$choiceIndex = isset($_POST['choiceIndex']) ? $_POST['choiceIndex'] : null;
$choiceText = isset($_POST['choiceText']) ? $_POST['choiceText'] : null;
$targetPage = isset($_POST['targetPage']) ? $_POST['targetPage'] : null;

// Check if any required parameter is missing
if ($choiceId !== null && $choiceIndex !== null && $choiceText !== null && $targetPage !== null) {
    try {
        // Update the choices table
        $stmtUpdateChoice = $pdo->prepare("UPDATE choices SET choice_text_" . $choiceIndex . " = ?, target_page_" . $choiceIndex . " = ?, amount_of_choices = amount_of_choices + 1 WHERE choice_id = ?");
        $stmtUpdateChoice->execute([$choiceText, $targetPage, $choiceId]);

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