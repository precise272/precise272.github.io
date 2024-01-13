<?php
// Include the necessary database connection logic
include '../dbconn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve chapter information from the form
    $bookId = $_POST['book_id'] ?? '';
    $chapterNumber = $_POST['chapter_number'] ?? '';
    $storyline = $_POST['storyline'] ?? '';
    $affinityRequirement = $_POST['affinity_requirement'] ?? '';

    // Perform validation if needed

    // Save chapter data to the database
    $stmt = $pdo->prepare("INSERT INTO chapters (book_id, chapter_number, storyline, affinity_requirement) VALUES (:bookId, :chapterNumber, :storyline, :affinityRequirement)");
    $stmt->bindParam(':bookId', $bookId);
    $stmt->bindParam(':chapterNumber', $chapterNumber);
    $stmt->bindParam(':storyline', $storyline);
    $stmt->bindParam(':affinityRequirement', $affinityRequirement);
    $stmt->execute();

    // Redirect to a success page or do further processing
    header('Location: success.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chapters</title>
</head>
<body>

    <h2>Add Chapter</h2>

    <form method="post" action="add-chapters-form.php">
        <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
        <label for="chapter_number">Chapter Number:</label>
        <input type="text" name="chapter_number" required><br>

        <label for="storyline">Storyline:</label>
        <textarea name="storyline" required></textarea><br>

        <label for="affinity_requirement">Affinity Requirement:</label>
        <input type="text" name="affinity_requirement"><br>

        <input type="submit" value="Add Chapter">
    </form>

</body>
</html>
