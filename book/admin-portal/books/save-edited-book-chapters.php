<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterNumbers = isset($_POST['chapter_number']) ? $_POST['chapter_number'] : null;
$storylines = isset($_POST['storyline']) ? $_POST['storyline'] : null;
$affinityRequirements = isset($_POST['affinity_requirement']) ? $_POST['affinity_requirement'] : null;

// Check if any required parameter is missing
if ($bookId !== null && $chapterNumbers !== null && $storylines !== null && $affinityRequirements !== null) {
    try {
        $pdo->beginTransaction();

        foreach ($chapterNumbers as $index => $chapterNumber) {
            // Check if a record already exists for the given chapter number and book ID
            $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM chapters WHERE book_id = ? AND chapter_number = ?");
            $stmtCheck->execute([$bookId, $chapterNumber]);
            $chapterExists = $stmtCheck->fetchColumn();

            if ($chapterExists) {
                // If the chapter already exists, update it
                $stmtUpdate = $pdo->prepare("UPDATE chapters SET storyline = ?, affinity_requirement = ? WHERE book_id = ? AND chapter_number = ?");
                $stmtUpdate->execute([$storylines[$index], $affinityRequirements[$index], $bookId, $chapterNumber]);
            } else {
                // If the chapter does not exist, insert a new record
                $stmtInsert = $pdo->prepare("INSERT INTO chapters (book_id, chapter_number, storyline, affinity_requirement) VALUES (?, ?, ?, ?)");
                $stmtInsert->execute([$bookId, $chapterNumber, $storylines[$index], $affinityRequirements[$index]]);
            }
        }

        $pdo->commit();

        // Return success message
        echo json_encode(['message' => 'Book chapters updated successfully.']);
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        // Return error message
        echo json_encode(['error' => 'Error updating book chapters: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
