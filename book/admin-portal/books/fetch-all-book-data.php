<?php
// Include the database connection file
include_once "../dbconn.php";

try {
    // Fetch book details
    $stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->execute([$_GET['book_id']]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch book preferences
    $stmt = $pdo->prepare("SELECT * FROM book_preferences WHERE book_id = ?");
    $stmt->execute([$book['book_id']]);
    $bookPreferences = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch chapters
    $stmt = $pdo->prepare("SELECT * FROM chapters WHERE book_id = ?");
    $stmt->execute([$book['book_id']]);
    $chapters = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch pages for all chapters
    $pages = [];
    foreach ($chapters as $chapter) {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE chapter_id = ?");
        $stmt->execute([$chapter['chapter_id']]);
        $pages = array_merge($pages, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Fetch choices for all pages
    $choices = [];
    foreach ($pages as $page) {
        $stmt = $pdo->prepare("SELECT * FROM choices WHERE page_id = ?");
        $stmt->execute([$page['page_id']]);
        $choices = array_merge($choices, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Combine all data into one array
    $data = [
        'book' => $book,
        'book_preferences' => $bookPreferences,
        'chapters' => $chapters,
        'pages' => $pages,
        'choices' => $choices
    ];

    // Send data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Handle error
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>