<?php
// delete-book.php
// Include the database connection file
include_once "../dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $bookId = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);

    // Validate numeric values
    if ($bookId === false) {
        echo json_encode(['error' => 'Invalid book ID']);
        exit;
    }

    // Database delete code (use your database connection and query)
    // Use prepared statements to prevent SQL injection
    $sql = "DELETE FROM books WHERE book_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $bookId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $response = ['message' => 'Book deleted successfully'];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Error deleting book']);
    }

    // Close the statement
    $stmt->closeCursor();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
