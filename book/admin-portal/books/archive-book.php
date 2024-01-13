<?php
include '../dbconn.php';

// Retrieve book_id from the URL
$bookId = $_GET['book_id'] ?? 0;

// Archive the book (update 'archived' column to 1)
$stmt = $pdo->prepare("UPDATE books SET archived = 1 WHERE book_id = :book_id");
$stmt->bindParam(':book_id', $bookId);
$stmt->execute();

// Redirect back to the book list
header("Location: list-books.php");
exit();
?>
