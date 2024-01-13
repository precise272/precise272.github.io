<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$bookId = $_POST['book_id'];
$targetAge = $_POST['target_age'];
$genre = $_POST['genre'];
$bookSize = $_POST['book_size'];
$difficulty = $_POST['difficulty'];
$containsMiniGames = $_POST['contains_mini_games'];

// Prepare the SQL statement
$sql = "INSERT INTO book_preferences (book_id, target_age, genre, book_size, difficulty, contains_mini_games)
        VALUES (:book_id, :target_age, :genre, :book_size, :difficulty, :contains_mini_games)";

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
    echo json_encode(['message' => 'Book preferences added successfully.']);
} catch (PDOException $e) {
    // Return error message
    echo json_encode(['error' => 'Error adding book preferences: ' . $e->getMessage()]);
}
?>
