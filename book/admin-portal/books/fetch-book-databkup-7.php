<?php
// fetch-book-data.php

// Include the database connection file
include_once "../dbconn.php";

header('Content-Type: application/json'); // Set content type to JSON

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate and sanitize input data
    $bookId = filter_input(INPUT_GET, 'book_id', FILTER_VALIDATE_INT);

    if ($bookId !== false && $bookId !== null) {
        // Database select code (use your database connection and query)
        // Use prepared statements to prevent SQL injection
        $bookSql = "SELECT * FROM books WHERE book_id = ?";
        $bookStmt = $pdo->prepare($bookSql);
        $bookStmt->bindParam(1, $bookId, PDO::PARAM_INT);
        $bookStmt->execute();
        $bookResult = $bookStmt->fetch(PDO::FETCH_ASSOC);

        if ($bookResult) {
            // Now, fetch preferences data
            $prefSql = "SELECT * FROM book_preferences WHERE book_id = ?";
            $prefStmt = $pdo->prepare($prefSql);
            $prefStmt->bindParam(1, $bookId, PDO::PARAM_INT);
            $prefStmt->execute();
            $prefResult = $prefStmt->fetch(PDO::FETCH_ASSOC);

            // Now, fetch chapters data along with pages
            $chaptersSql = "SELECT chapters.*, pages.* FROM chapters
                LEFT JOIN pages ON chapters.chapter_id = pages.chapter_id
                WHERE chapters.book_id = ?";
            $chaptersStmt = $pdo->prepare($chaptersSql);
            $chaptersStmt->bindParam(1, $bookId, PDO::PARAM_INT);
            $chaptersStmt->execute();
            $chaptersResult = $chaptersStmt->fetchAll(PDO::FETCH_ASSOC);

            // Combine results from all tables
            $combinedResult = array(
                'book_details' => $bookResult,
                'book_preferences' => $prefResult,
                'book_chapters' => $chaptersResult
            );

            echo json_encode($combinedResult);
        } else {
            echo json_encode(['error' => 'Book not found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid book ID']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
