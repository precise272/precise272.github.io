<?php
// add-news.php

// Include the database connection file
include_once "../dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $headline = filter_input(INPUT_POST, 'headline', FILTER_SANITIZE_STRING);
    $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING);

    // Get the current date and time in EST
    $dateTime = new DateTime('now', new DateTimeZone('America/New_York'));
    $postDateTime = $dateTime->format('Y-m-d H:i:s');

    // Validate and handle optional file upload (image)
    $imageUploadDir = 'uploads/'; // Change this to your desired upload directory

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageInfo = getimagesize($_FILES['image']['tmp_name']);

        if ($imageInfo === false) {
            echo json_encode(array('error' => 'Invalid image file'));
            exit();
        }

        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo json_encode(array('error' => 'Invalid image file type'));
            exit();
        }

        // Generate a unique filename to prevent overwriting existing files
        $imageName = uniqid('news_image_') . '.' . $fileExtension;
        $imagePath = $imageUploadDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            echo json_encode(array('error' => 'Error uploading image'));
            exit();
        }
    } else {
        // No image provided, handle accordingly (e.g., set $imagePath to null in the database insert query)
        $imagePath = null;
    }

    // Database insert code (use your database connection and query)
    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO news (datetime, headline, article, image) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $postDateTime, PDO::PARAM_STR);
    $stmt->bindParam(2, $headline, PDO::PARAM_STR);
    $stmt->bindParam(3, $article, PDO::PARAM_STR);
    $stmt->bindParam(4, $imagePath, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $response = array('message' => 'News article added successfully');
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Error adding news article'));
    }

    // Close the statement
    $stmt->closeCursor();
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
