<?php
// fetch-book-data.php

// Include the database connection file
include_once "../dbconn.php";

header('Content-Type: application/json'); // Set content type to JSON

function fetchBookDetails($pdo, $bookId) {
    $sql = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $bookId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchBookPreferences($pdo, $bookId) {
    $sql = "SELECT * FROM book_preferences WHERE book_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $bookId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchChapters($pdo, $bookId) {
    $sql = "SELECT * FROM chapters WHERE book_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $bookId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchPagesAndChoices($pdo, $bookId) {
    $sql = "SELECT pages.*, GROUP_CONCAT(choices.choice_id) as choice_ids, GROUP_CONCAT(choices.text) as choices_text 
            FROM pages 
            LEFT JOIN choices ON pages.page_id = choices.page_id 
            WHERE pages.book_id = ? 
            GROUP BY pages.page_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $bookId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate and sanitize input data
    $bookId = filter_input(INPUT_GET, 'book_id', FILTER_VALIDATE_INT);

    if ($bookId !== false && $bookId !== null) {
        try {
            $bookDetails = fetchBookDetails($pdo, $bookId);

            if ($bookDetails) {
                $bookPreferences = fetchBookPreferences($pdo, $bookId);
                $chapters = fetchChapters($pdo, $bookId);
                $pagesAndChoices = fetchPagesAndChoices($pdo, $bookId);

                // Combine results from all tables
                $combinedResult = array(
                    'book_details' => $bookDetails,
                    'book_preferences' => $bookPreferences,
                    'book_chapters' => $chapters,
                    'book_pages_and_choices' => $pagesAndChoices
                );

                echo json_encode($combinedResult);
            } else {
                echo json_encode(['error' => 'Book not found']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid book ID']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>