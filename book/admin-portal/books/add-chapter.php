<?php
file_put_contents('log.txt', print_r($_POST, true));
// Include database connection
include '../dbconn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $bookId = $_POST['book_id'];
    $chapterNumber = $_POST['chapter_number'];
    $storyline = $_POST['storyline'];
    $affinityRequirement = $_POST['affinity_requirement'];

    // Validate data (add your validation logic here)

    // Insert chapter into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO chapters (book_id, chapter_number, storyline, affinity_requirement) VALUES (:bookId, :chapterNumber, :storyline, :affinityRequirement)");
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':chapterNumber', $chapterNumber, PDO::PARAM_INT);
        $stmt->bindParam(':storyline', $storyline, PDO::PARAM_STR);
        $stmt->bindParam(':affinityRequirement', $affinityRequirement, PDO::PARAM_STR);
        $stmt->execute();

        // Send a response (you can customize the response based on your needs)
        $response = ['message' => 'Chapter added successfully.'];
        echo json_encode($response);
    } catch (PDOException $e) {
        // Handle database error
        $response = ['error' => 'Error adding chapter: ' . $e->getMessage()];
        echo json_encode($response);
    }
} else {
    // If the form is not submitted, send an error response
    $response = ['error' => 'Invalid request.'];
    echo json_encode($response);
}
?>
