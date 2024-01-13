<?php
// edit-page.php
//save edited page

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$pageId = isset($_POST['page_id']) ? $_POST['page_id'] : null;
$content = isset($_POST['content']) ? $_POST['content'] : null;

// Check if any required parameter is missing
if ($pageId !== null && $content !== null) {
    try {
        // Update the content of the page
        $stmtUpdate = $pdo->prepare("UPDATE pages SET content = ? WHERE page_id = ?");
        $stmtUpdate->execute([$content, $pageId]);

        // Return success message
        echo json_encode(['message' => 'Page edited successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error editing page: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
