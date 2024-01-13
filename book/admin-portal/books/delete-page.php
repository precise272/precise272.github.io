<?php
// delete-page.php

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : null;

// Check if the page ID is provided
if ($pageId !== null) {
    try {
        // Start a database transaction
        $pdo->beginTransaction();

        // Delete choices for the specified page
        $stmtDeleteChoices = $pdo->prepare("DELETE FROM choices WHERE page_id = ?");
        $stmtDeleteChoices->execute([$pageId]);

        // Delete the specified page
        $stmtDeletePage = $pdo->prepare("DELETE FROM pages WHERE page_id = ?");
        $stmtDeletePage->execute([$pageId]);

        // Commit the transaction
        $pdo->commit();

        // Return success message
        echo json_encode(['message' => 'Page and choices deleted successfully.']);
    } catch (PDOException $e) {
        // Roll back the transaction on error
        $pdo->rollBack();

        // Return error message
        echo json_encode(['error' => 'Error deleting page and choices: ' . $e->getMessage()]);
    }
} else {
    // Return an error response if the page ID is missing
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
