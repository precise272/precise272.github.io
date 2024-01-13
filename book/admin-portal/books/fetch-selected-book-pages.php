<?php
// fetch-selected-book-pages.php
include_once('../dbconn.php');

// Check if the book_id, chapter_id, and page_id parameters are set
if (isset($_GET['book_id']) && isset($_GET['chapter_id'])) {
    // Sanitize the input (to prevent SQL injection, etc.)
    $bookId = filter_var($_GET['book_id'], FILTER_SANITIZE_NUMBER_INT);
    $chapterId = filter_var($_GET['chapter_id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM pages WHERE book_id = ? AND chapter_id = ?";
    
    // If page_id parameter is set, add it to the query
    if (isset($_GET['page_id'])) {
        $pageId = filter_var($_GET['page_id'], FILTER_SANITIZE_NUMBER_INT);
        $query .= " AND page_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$bookId, $chapterId, $pageId]);
    } else {
        // If page_id parameter is not set, execute the query without it
        $stmt = $pdo->prepare($query);
        $stmt->execute([$bookId, $chapterId]);
    }

    // Fetch the details
    $bookPages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the details as JSON
    header('Content-Type: application/json');
    echo json_encode($bookPages);
} else {
    // If book_id or chapter_id parameters are not set, return an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request. Please provide book_id and chapter_id parameters.']);
}
?>
