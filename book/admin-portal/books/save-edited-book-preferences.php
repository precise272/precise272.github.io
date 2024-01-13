<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$targetAge = isset($_POST['target_age']) ? $_POST['target_age'] : null;
$genre = isset($_POST['genre']) ? $_POST['genre'] : null;
$bookSize = isset($_POST['book_size']) ? $_POST['book_size'] : null;
$difficulty = isset($_POST['difficulty']) ? $_POST['difficulty'] : null;
$containsMiniGames = isset($_POST['contains_mini_games']) ? $_POST['contains_mini_games'] : null;

// Check if any required parameter is missing
if ($bookId !== null && $targetAge !== null && $genre !== null && $bookSize !== null && $difficulty !== null && $containsMiniGames !== null) {
    // Prepare the SQL statement for updating an existing row
    $sql = "UPDATE book_preferences 
            SET target_age = :target_age, 
                genre = :genre, 
                book_size = :book_size, 
                difficulty = :difficulty, 
                contains_mini_games = :contains_mini_games
            WHERE book_id = :book_id";

    // Bind parameters and execute the statement
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':target_age', $targetAge, PDO::PARAM_STR);
        $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
        $stmt->bindParam(':book_size', $bookSize, PDO::PARAM_STR);
        $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
        $stmt->bindParam(':contains_mini_games', $containsMiniGames, PDO::PARAM_STR);
        $stmt->execute();

        // Return success message
        echo json_encode(['message' => 'Book preferences updated successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error updating book preferences: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
