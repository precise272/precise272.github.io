<?php
include '../dbconn.php';

// Fetch the list of books
$stmt = $pdo->query("SELECT * FROM books WHERE archived = 0");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Book List</h2>
<ul>
    <?php foreach ($books as $book): ?>
        <li>
            <?php echo $book['title']; ?>
            <a href="modify-book.php?book_id=<?php echo $book['book_id']; ?>">Modify</a>
            <a href="add-chapter.php?book_id=<?php echo $book['book_id']; ?>">Continue</a>
            <a href="archive-book.php?book_id=<?php echo $book['book_id']; ?>">Archive</a>
        </li>
    <?php endforeach; ?>
</ul>
