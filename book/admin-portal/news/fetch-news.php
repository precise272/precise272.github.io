<?php
// Include the database connection file
include_once "../dbconn.php";

// Fetch news articles from the database
$sql = "SELECT id, datetime, headline, article, image FROM news ORDER BY id DESC";

// Use prepared statement to prevent SQL injection
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any news articles
if (count($result) > 0) {
    // Replace NULL values in the 'image' column with an empty string
    foreach ($result as &$news) {
        if ($news['image'] === null) {
            $news['image'] = '';
        }
    }

    // Return news data as JSON
    echo json_encode($result);
} else {
    // Return an empty array if no news articles are found
    echo json_encode([]);
}

// Close the statement (PDO doesn't require explicitly closing the connection)
$stmt = null;
?>
