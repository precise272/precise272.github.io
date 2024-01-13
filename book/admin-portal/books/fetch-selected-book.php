<?php
//fetch-selected-book.php
// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Log errors to a custom file
ini_set('log_errors', 1);
ini_set('error_log', 'error.log'); // Adjust the filename and path as needed

try {
    // Check if the book_id parameter is set
    if (isset($_GET['book_id'])) {
        // Sanitize the input (to prevent SQL injection, etc.)
        $bookId = filter_var($_GET['book_id'], FILTER_SANITIZE_NUMBER_INT);

        include_once('../dbconn.php');

        $query = "SELECT * FROM books WHERE book_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$bookId]);

        // Fetch the details
        $bookDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($bookDetails) {
            // Return the details as JSON
            header('Content-Type: application/json');
            echo json_encode($bookDetails);
        } else {
            // If no details are found, return an error message
            http_response_code(404); // Not Found
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Book details not found.']);
        }
    } else {
        // If book_id parameter is not set, return an error message
        http_response_code(400); // Bad Request
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid request. Please provide a book_id parameter.']);
    }
} catch (PDOException $e) {
    // Log detailed error information for PDOException
    error_log("PDOException in fetch-selected-book.php: " . $e->getMessage(), 3, '../error.log');

    // Return a JSON error response to the client for PDOException
    http_response_code(500); // Internal Server Error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'An error occurred.']);
} catch (Exception $e) {
    // Log detailed error information for generic Exception
    error_log("Exception in fetch-selected-book.php: " . $e->getMessage(), 3, '../error.log');

    // Return a JSON error response to the client for generic Exception
    http_response_code(500); // Internal Server Error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'An error occurred.']);
}
?>
