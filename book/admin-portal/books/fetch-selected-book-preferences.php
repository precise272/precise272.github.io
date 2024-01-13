<?php
// fetch-selected-book-preferences.php

// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 if you want errors to be displayed on the page
ini_set('log_errors', 1);
ini_set('error_log', 'error.log'); // Adjust the filename and path as needed

// Check if the book_id parameter is set
if (isset($_GET['book_id'])) {
    // Sanitize the input (to prevent SQL injection, etc.)
    $bookId = filter_var($_GET['book_id'], FILTER_SANITIZE_NUMBER_INT);

    include_once('../dbconn.php');

    try {
        // Use a prepared statement to fetch book details
        $query = "SELECT * FROM book_preferences WHERE book_id = ?";
        $stmt = $pdo->prepare($query);

        if (!$stmt) {
            // Log to error log for server-side debugging
            error_log("Failed to prepare statement: " . print_r($pdo->errorInfo(), true));
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to prepare statement.']);
            http_response_code(500);
            exit();
        }

        $stmt->execute([$bookId]);

        if ($stmt->errorCode() !== '00000') {
            // Log to error log for server-side debugging
            error_log("Failed to execute statement: " . print_r($stmt->errorInfo(), true));
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to execute statement.']);
            http_response_code(500);
            exit();
        }

        // Fetch the details
        $bookDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($bookDetails) {
            // Return the details as JSON
            header('Content-Type: application/json');
            echo json_encode($bookDetails);
        } else {
            // If no details are found, return an error message
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Book details not found.']);
        }
    } catch (PDOException $e) {
        // Log detailed error information for PDOException
        error_log("PDOException in fetch-selected-book-preferences.php: " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If book_id parameter is not set, return an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request. Please provide a book_id parameter.']);
}
?>
