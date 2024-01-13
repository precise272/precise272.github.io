<?php
// load-pages-for-choice.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Add debug logs at the beginning of the script
error_log('Received POST data: ' . print_r($_POST, true));

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterId = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : null;
$choiceTargetPage = isset($_POST['choice_target_page']) ? $_POST['choice_target_page'] : null;

// Check if any required parameter is missing
if ($bookId !== null && $chapterId !== null && $choiceTargetPage !== null) {
    try {
        // Fetch pages associated with the specific choice
        $sql = "SELECT * FROM pages WHERE book_id = ? AND chapter_id = ? AND choice_id IS NOT NULL AND choice_target_page = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$bookId, $chapterId, $choiceTargetPage]);
        $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the fetched pages as JSON
        echo json_encode(['pages' => $pages]);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error fetching pages for choice: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
