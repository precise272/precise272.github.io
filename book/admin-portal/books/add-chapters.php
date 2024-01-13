<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$bookId = $_POST['book_id'];
$chapterNumber = $_POST['chapter_number'];
$storyline = $_POST['storyline'];
$affinityRequirement = $_POST['affinity_requirement'];

// Prepare the SQL statement
$sql = "INSERT INTO chapters (book_id, chapter_number, storyline, affinity_requirement)
        VALUES (:book_id, :chapter_number, :storyline, :affinity_requirement)";

// Bind parameters and execute the statement
try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindParam(':chapter_number', $chapterNumber, PDO::PARAM_INT);
    $stmt->bindParam(':storyline', $storyline, PDO::PARAM_STR);
    $stmt->bindParam(':affinity_requirement', $affinityRequirement, PDO::PARAM_STR);
    $stmt->execute();

    // Return success message
    echo json_encode(['message' => 'Chapters added successfully.']);
} catch (PDOException $e) {
    // Return error message
    echo json_encode(['error' => 'Error adding chapters: ' . $e->getMessage()]);
}
?>
