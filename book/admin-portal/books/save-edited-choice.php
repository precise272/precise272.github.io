<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Get the JSON data from the input stream
$jsonData = file_get_contents('php://input');

// Decode the JSON data to an associative array
$data = json_decode($jsonData, true);

// Log received data to the console
error_log('Received POST data: ' . print_r($data, true));

// Collect data from the POST request
$choiceId = isset($data['choiceId']) ? $data['choiceId'] : null;
$choiceText = isset($data['choiceText']) ? $data['choiceText'] : null;
$choiceNumber = isset($data['choiceNumber']) ? $data['choiceNumber'] : null;

// Check if any required parameter is missing
if ($choiceId !== null && $choiceText !== null && $choiceNumber !== null) {
    try {
        // Determine the correct column to update
        $choiceColumn = 'choice_text';
        if ($choiceNumber > 0) {
            $choiceColumn .= '_' . $choiceNumber;
        }

        // Update the existing entry with the new choice text
        $updateSql = "UPDATE choices SET $choiceColumn = ? WHERE choice_id = ?";

        // Log the SQL query
        error_log('SQL Query: ' . $updateSql);

        $stmtUpdate = $pdo->prepare($updateSql);
        $stmtUpdate->execute([$choiceText, $choiceId]);

        // Check if the update was successful
        $rowCount = $stmtUpdate->rowCount();
        if ($rowCount > 0) {
            // Return success message
            echo json_encode(['message' => 'Choice text updated successfully']);
        } else {
            // Return an error message if no rows were affected
            echo json_encode(['error' => 'No rows were affected']);
            // Log the choiceId, choiceText, and choiceNumber for debugging
            error_log('choiceId: ' . $choiceId . ', choiceText: ' . $choiceText . ', choiceNumber: ' . $choiceNumber);
        }
    } catch (PDOException $e) {
        // Log the exception details
        error_log('Error updating choice text: ' . $e->getMessage());

        // Log the sent data
        error_log('Sent Data: ' . print_r($data, true));

        // Return error message
        echo json_encode(['error' => 'Error updating choice text']);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request']);
}
?>