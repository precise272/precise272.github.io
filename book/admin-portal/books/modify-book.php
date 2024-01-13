<?php
include '../dbconn.php';

// Retrieve book_id from the URL
$bookId = $_GET['book_id'] ?? 0;

// Fetch book details
$stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = :book_id");
$stmt->bindParam(':book_id', $bookId);
$stmt->execute();
$book = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2>Modify Book</h2>
<!-- Display form with book details for modification -->
