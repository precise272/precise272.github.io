<?php
// test-database.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

try {
    // Example: Fetch all books
    $stmtBooks = $pdo->query("SELECT * FROM books");
    $books = $stmtBooks->fetchAll(PDO::FETCH_ASSOC);

    // Example: Fetch all chapters for a specific book (replace 'your_book_id' with an actual book ID)
    $bookId = '171';
    $stmtChapters = $pdo->prepare("SELECT * FROM chapters WHERE book_id = ?");
    $stmtChapters->execute([$bookId]);
    $chapters = $stmtChapters->fetchAll(PDO::FETCH_ASSOC);

    // Example: Fetch all pages for a specific chapter (replace 'your_chapter_id' with an actual chapter ID)
    $chapterId = '116';
    $stmtPages = $pdo->prepare("SELECT * FROM pages WHERE chapter_id = ?");
    $stmtPages->execute([$chapterId]);
    $pages = $stmtPages->fetchAll(PDO::FETCH_ASSOC);

    // Output the results
    echo json_encode(['books' => $books, 'chapters' => $chapters, 'pages' => $pages]);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage(), 'trace' => $e->getTrace()]);
}
?>
