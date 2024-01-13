<?php
// fetch-book-preferences.php

// Include your database connection code or configuration
include_once('../dbconn.php');

// Fetch the list of book preferences from the database
function fetchBookPreferences($pdo) {
    $query = "SELECT * FROM book_preferences";
    $statement = $pdo->query($query);

    $bookPreferences = [];

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $bookPreferences[] = [
            'book_id' => $row['book_id'],
            'target_age' => $row['target_age'],
            'genre' => $row['genre'],
            'book_size' => $row['book_size'],
            'difficulty' => $row['difficulty'],
            'contains_mini_games' => $row['contains_mini_games'],
            'create_at' => $row['create_at'],
        ];
    }

    return $bookPreferences;
}

// Fetch and return the list of books as JSON
$bookPreferencesList = fetchBookPreferences($pdo); // Assuming $pdo is your PDO instance
echo json_encode($bookPreferencesList);
?>
