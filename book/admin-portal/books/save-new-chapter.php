<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../dbconn.php');

// Collect data from the POST request
$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;
$chapterNumber = isset($_POST['chapter_number']) ? $_POST['chapter_number'] : null;
$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : null;
$affinityRequirement = isset($_POST['affinity_requirement']) ? $_POST['affinity_requirement'] : null;

// Check if any required parameter is missing
if ($bookId !== null && $chapterNumber !== null && $storyline !== null && $affinityRequirement !== null) {
    try {
        // Check if a record already exists for the given chapter number and book ID
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM chapters WHERE book_id = ? AND chapter_number = ?");
        $stmtCheck->execute([$bookId, $chapterNumber]);
        $chapterExists = $stmtCheck->fetchColumn();

        if ($chapterExists) {
            // If the chapter already exists, return an error
            echo json_encode(['error' => 'Chapter with the same number already exists for this book.']);
        } else {
            // If the chapter does not exist, insert a new record
            $stmtInsert = $pdo->prepare("INSERT INTO chapters (book_id, chapter_number, storyline, affinity_requirement) VALUES (?, ?, ?, ?)");
            $stmtInsert->execute([$bookId, $chapterNumber, $storyline, $affinityRequirement]);

            // Return success message
            echo json_encode(['message' => 'New chapter saved successfully.']);
        }
    } catch (PDOException $e) {
        // Return error message
        echo json_encode(['error' => 'Error saving new chapter: ' . $e->getMessage()]);
    }
} else {
    // Return an error response
    echo json_encode(['error' => 'Missing parameters in the request.']);
}
?>
