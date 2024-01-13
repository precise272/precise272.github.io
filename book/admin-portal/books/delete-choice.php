<?php
// delete-choice.php

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$choiceId = isset($data['choice_id']) ? $data['choice_id'] : null;
$choiceNumber = isset($data['choice_number']) ? $data['choice_number'] : null;

// Check if the choice ID and choice number are provided
if ($choiceId !== null && $choiceNumber !== null) {
    try {
        // Start a database transaction
        $pdo->beginTransaction();

        // Get the total number of choices
        $stmtGetChoices = $pdo->prepare("SELECT amount_of_choices FROM choices WHERE choice_id = ?");
        $stmtGetChoices->execute([$choiceId]);
        $totalChoices = $stmtGetChoices->fetchColumn();

        // Shift the remaining choices down
for ($i = $choiceNumber; $i < $totalChoices; $i++) {
    $stmtShiftChoices = $pdo->prepare("UPDATE choices SET choice_text_" . ($i + 1) . " = choice_text_" . ($i + 2) . ", target_page_" . ($i + 1) . " = target_page_" . ($i + 2) . " WHERE choice_id = ?");
    $stmtShiftChoices->execute([$choiceId]);
}

// Set the last choice to null
$stmtSetLastChoiceNull = $pdo->prepare("UPDATE choices SET choice_text_" . ($totalChoices + 1) . " = NULL, target_page_" . ($totalChoices + 1) . " = NULL WHERE choice_id = ?");
$stmtSetLastChoiceNull->execute([$choiceId]);
        // Decrement the amount_of_choices
        $stmtDecrementChoices = $pdo->prepare("UPDATE choices SET amount_of_choices = amount_of_choices - 1 WHERE choice_id = ?");
        $stmtDecrementChoices->execute([$choiceId]);

        // Commit the transaction
        $pdo->commit();

        // Return success message
        echo json_encode(['message' => 'Choice deleted successfully.']);
    } catch (PDOException $e) {
        // Roll back the transaction on error
        $pdo->rollBack();

        // Return error message
        echo json_encode(['error' => 'Error deleting choice: ' . $e->getMessage()]);
    }
} else {
    // Return an error response if the choice ID or choice number is missing
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>