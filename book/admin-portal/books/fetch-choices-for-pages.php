<?php
// fetch-choices-for-pages.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Add debug logs at the beginning of the script
error_log('Received POST data: ' . print_r($_POST, true));

// Collect data from the POST request
$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : null;

// Check if the required parameter is present
if ($pageId !== null) {
    try {
        // Fetch choices for the specified page
        $stmt = $pdo->prepare("SELECT choice_id, choice_text, target_page, choice_text_1, target_page_1, choice_text_2, target_page_2, choice_text_3, target_page_3, choice_text_4, target_page_4 FROM choices WHERE page_id = ?");
        $stmt->execute([$pageId]);
        $choices = $stmt->fetch(PDO::FETCH_ASSOC);

        // Log success message
        error_log('Choices fetched successfully for page ' . $pageId);

        // Return choices as JSON
        echo json_encode(['choices' => $choices]);
    } catch (PDOException $e) {
        // Log error message
        $errorMessage = 'Error fetching choices: ' . $e->getMessage();
        error_log($errorMessage);
        echo json_encode(['error' => $errorMessage]);
    }
} else {
    // Log error message
    $errorMessage = 'Missing parameters in the request.';
    error_log($errorMessage);
    echo json_encode(['error' => $errorMessage]);
}
?>
