<?php
//save-book-preferences.php//

// Include the database connection file
include_once "../dbconn.php";

// Function to fetch book details by book ID
function fetchBookDetails($bookId) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
        $stmt->execute([$bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching book details: " . $e->getMessage());
    }
}

// Example usage
$response = array();

try {
    // Function to save or update book preferences in the database
    function saveBookPreferences($bookId, $targetAge, $genre, $bookSize, $difficulty, $containsMiniGames) {
        global $pdo;

        try {
            // Check if the book_id exists in the books table
            $stmtCheckBook = $pdo->prepare("SELECT COUNT(*) FROM books WHERE book_id = ?");
            $stmtCheckBook->execute([$bookId]);
            $bookExists = $stmtCheckBook->fetchColumn();

            if ($bookExists) {
                // Continue with saving or updating book preferences
                $stmtCheckPref = $pdo->prepare("SELECT COUNT(*) FROM book_preferences WHERE book_id = ?");
                $stmtCheckPref->execute([$bookId]);
                $prefExists = $stmtCheckPref->fetchColumn();

                if ($prefExists) {
                    // If a record exists, update it
                    $stmtUpdate = $pdo->prepare("UPDATE book_preferences SET target_age = ?, genre = ?, book_size = ?, difficulty = ?, contains_mini_games = ? WHERE book_id = ?");
                    $stmtUpdate->execute([$targetAge, $genre, $bookSize, $difficulty, $containsMiniGames, $bookId]);
                    return "Book preferences updated successfully!";
                } else {
                    // If no record exists, insert a new one
                    $stmtInsert = $pdo->prepare("INSERT INTO book_preferences (book_id, target_age, genre, book_size, difficulty, contains_mini_games) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmtInsert->execute([$bookId, $targetAge, $genre, $bookSize, $difficulty, $containsMiniGames]);
                    return "Book preferences saved successfully!";
                }
            } else {
                return "Error: The specified book_id does not exist in the books table. Book ID: " . $bookId;
            }
        } catch (PDOException $e) {
            return "Error saving or updating book preferences: " . $e->getMessage();
        }
    }

    // Extract book ID from the request
    $bookId = isset($_POST['bookId']) ? $_POST['bookId'] : null;

    // Extract other form data
    $targetAge = $_POST['targetAge'];
    $genre = $_POST['genre'];
    $bookSize = $_POST['bookSize'];
    $difficulty = $_POST['difficulty'];
    $containsMiniGames = $_POST['containsMiniGames'];

    // Call the function and get the result message
    $resultMessage = saveBookPreferences($bookId, $targetAge, $genre, $bookSize, $difficulty, $containsMiniGames);
    $response['message'] = $resultMessage;

    // If book ID is available, fetch book details for editing
    if ($bookId) {
        $bookDetails = fetchBookDetails($bookId);
        $response['bookDetails'] = $bookDetails;
    }
} catch (PDOException $e) {
    $response['error'] = "Error saving book preferences: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
