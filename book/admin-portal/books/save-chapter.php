<?php
// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$chapterNumber = isset($_POST['chapter_number']) ? $_POST['chapter_number'] : null;
$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : null;
$affinityRequirement = isset($_POST['affinity_requirement']) ? $_POST['affinity_requirement'] : null;

// Check if any required parameter is missing
if ($chapterNumber !== null && $storyline !== null && $affinityRequirement !== null) {
    // Prepare the SQL statement for inserting a new chapter
    $sql = "INSERT INTO chapters (book_id, chapter_number, storyline, affinity_requirement)
            VALUES (:book_id, :chapter_number, :storyline, :affinity_requirement)";

    // Bind parameters and execute the statement
    try {
        $stmt = $pdo->prepare($sql);
        // You need to set the book_id accordingly; for now, I assume it's 1
        $stmt->bindParam(':book_id', 1, PDO::PARAM_INT);
        $stmt->bindParam(':chapter_number', $chapterNumber, PDO::PARAM_INT);
        $stmt->bindParam(':storyline', $storyline, PDO::PARAM_STR);
        $stmt->bindParam(':affinity_requirement', $affinityRequirement, PDO::PARAM_STR);
        $stmt->execute();

        // Return success message
        echo json_encode(['message' => 'Chapter saved successfully.']);
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving chapter: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
