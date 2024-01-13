<?php
// save-news-changes.php

// Include database connection code here if not included already

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $newsId = filter_input(INPUT_POST, 'news_id', FILTER_VALIDATE_INT);
    $newHeadline = filter_input(INPUT_POST, 'new_headline', FILTER_SANITIZE_STRING);
    $newArticle = filter_input(INPUT_POST, 'new_article', FILTER_SANITIZE_STRING);

    // Handle file upload (new image)
    $newImageUploadDir = 'uploads/'; // Change this to your desired upload directory
    $newImageName = $_FILES['new_image']['name'];
    $newImagePath = $newImageUploadDir . $newImageName;

    if (move_uploaded_file($_FILES['new_image']['tmp_name'], $newImagePath)) {
        // Database update code (use your database connection and query)
        // Update the news article with the given $newsId
        // Example: $query = "UPDATE news SET headline = '$newHeadline', article = '$newArticle', image = '$newImagePath' WHERE id = $newsId";
        // executeQuery($query);

        $response = array('message' => 'News changes saved successfully');
    } else {
        $response = array('error' => 'Error uploading new image');
    }

    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
