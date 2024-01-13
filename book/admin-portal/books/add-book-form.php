<!-- add-book-form.php -->
<!-- Your initial book creation form HTML here -->
<form id="addBookForm">
    <!-- Form fields go here -->
    <input type="text" name="title" id="bookTitle" placeholder="Book Title" required>
    <!-- Other fields go here -->

    <!-- Next button to trigger form display -->
    <button type="button" onclick="displayChapterForm()">Next</button>
</form>

<!-- add-chapter-form.php -->
<!-- Your chapter form HTML here -->
<form id="addChapterForm" style="display: none;">
    <!-- Chapter form fields go here -->
    <input type="text" name="chapterTitle" id="chapterTitle" placeholder="Chapter Title" required>
    <!-- Other chapter fields go here -->

    <!-- Save button to submit the chapter form -->
    <button type="submit">Save Chapter</button>
</form>

<script>
    function displayChapterForm() {
        // Display the chapter form
        document.getElementById('addBookForm').style.display = 'none';
        document.getElementById('addChapterForm').style.display = 'block';
    }
</script>
