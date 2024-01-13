<?php
// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Log errors to a custom file
ini_set('log_errors', 1);
ini_set('error_log', 'error.log'); // Adjust the filename and path as needed

try {
    // Include the database connection file
    include_once('../dbconn.php');

    // Example debugging statement
    error_log("Debug: Something happened with the db include.", 3, "error.log");

    // Your existing code here
    if (isset($_GET['book_id'])) {
        $bookId = filter_var($_GET['book_id'], FILTER_SANITIZE_NUMBER_INT);

        // Example debugging statement
        error_log("Debug: Something happened setting book id. Book ID: $bookId", 3, "error.log");

        $query = "SELECT * FROM chapters WHERE book_id = ?";
        // Example debugging statement
        error_log("Debug: Something happened with the query. Query: $query", 3, "error.log");

        $stmt = $pdo->prepare($query);
        if (!$stmt) {
            // Log to console for client-side debugging
            echo json_encode(['error' => 'Failed to prepare statement.']);
            echo "<script>console.error('Failed to prepare statement.');</script>";
            http_response_code(500);
            exit();
        }

        // Example debugging statement
        error_log("Debug: Something happened at preparing the statement.", 3, "error.log");

        $stmt->execute([$bookId]);
        if ($stmt->errorCode() !== '00000') {
            // Log to console for client-side debugging
            echo json_encode(['error' => 'Failed to execute statement.']);
            echo "<script>console.error('Failed to execute statement.');</script>";
            http_response_code(500);
            exit();
        }
        error_log("Debug: Something happened at executing the statement.", 3, "error.log");

        // Fetch the details
        $bookChapters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Debug: Something happened at fetching the chapters. Chapters: " . json_encode($bookChapters), 3, "error.log");

        // Return the details as JSON
        header('Content-Type: application/json');
        echo json_encode($bookChapters);
    } else {
        // If book_id parameter is not set, return an error message
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid request. Please provide a book_id parameter.']);
    }
} catch (PDOException $e) {
    // Log detailed error information for PDOException
    error_log("PDOException in fetch-selected-book-chapters.php: " . $e->getMessage(), 3, 'error.log');

    // Log to console for client-side debugging
    echo json_encode(['error' => 'An error occurred. Check server logs for details.']);
    echo "<script>console.error('PDOException in fetch-selected-book-chapters.php: " . addslashes($e->getMessage()) . "');</script>";
    http_response_code(500);
} catch (Exception $e) {
    // Log detailed error information for generic Exception
    error_log("Exception in fetch-selected-book-chapters.php: " . $e->getMessage(), 3, 'error.log');

    // Log to console for client-side debugging
    echo json_encode(['error' => 'An error occurred. Check server logs for details.']);
    echo "<script>console.error('Exception in fetch-selected-book-chapters.php: " . addslashes($e->getMessage()) . "');</script>";
    http_response_code(500);
}
?>
