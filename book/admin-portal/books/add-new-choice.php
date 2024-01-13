<?php
// add-new-choice.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Get the JSON data from the request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Add debug logs at the beginning of the script
error_log('Received POST data: ' . print_r($data, true));

// Collect data from the POST request
$choiceId = isset($data['choiceId']) ? $data['choiceId'] : null;
$choiceIndex = isset($data['choiceIndex']) ? $data['choiceIndex'] : null;
$choiceText = isset($data['choiceText']) ? $data['choiceText'] : null;
$targetPage = isset($data['targetPage']) ? $data['targetPage'] : null;

// Check if any required parameter is missing
if ($choiceId !== null && $choiceIndex !== null && $choiceText !== null && $targetPage !== null) {
    try {
        // Update the record in the choices table
        $stmtUpdateChoice = $pdo->prepare("UPDATE choices SET choice_text_$choiceIndex = ?, target_page_$choiceIndex = ?, amount_of_choices = amount_of_choices + 1 WHERE choice_id = ?");
        $stmtUpdateChoice->execute([$choiceText, $targetPage, $choiceId]);

        // Return success message
        echo json_encode(['message' => 'Choice updated successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error updating choice: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>