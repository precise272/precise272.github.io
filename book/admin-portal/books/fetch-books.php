<?php
// fetch-books.php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

// Include your database connection code or configuration
include_once('../dbconn.php');

// Fetch the list of books from the database
function fetchBooks($pdo) {
    // Use prepared statements for better security
    $query = "SELECT * FROM books";
    $statement = $pdo->prepare($query);

    // Execute the statement
    $statement->execute();

    $books = [];

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $books[] = [
            'book_id' => $row['book_id'],
            'title' => $row['title'],
            'author' => $row['author'],
            'year' => $row['year'],
            'description' => $row['description'],
            'imageUrl' => $row['image_url'],
            'video_url' => $row['video_url'],
            'deleted' => $row['deleted'],
            'live' => $row['live'],
        ];
    }

    return $books;
}

// Fetch and return the list of books as JSON
try {
    $booksList = fetchBooks($pdo); // Assuming $pdo is your PDO instance
    echo json_encode($booksList);
} catch (PDOException $e) {
    // If there is an error, log it and return a 500 response
    error_log("PDOException in fetchBooks: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch books']);
}
?>