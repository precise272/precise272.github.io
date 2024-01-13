<?php
// Include the database connection file
include_once "../dbconn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from the form
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $name = $_POST["fullName"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $country = $_POST["country"];
    $favoriteGenre = $_POST["favoriteGenre"];

    // Server-side validation (replace with your validation logic)
    // Example: Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email format']);
        exit;
    }

    // SQL query to insert user data into the users table
    $sql = "INSERT INTO users (username, password_hash, name, age, gender, email, country, favorite_genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);
    $stmt->bindParam(3, $name, PDO::PARAM_STR);
    $stmt->bindParam(4, $dateOfBirth, PDO::PARAM_STR);
    $stmt->bindParam(5, $gender, PDO::PARAM_STR);
    $stmt->bindParam(6, $email, PDO::PARAM_STR);
    $stmt->bindParam(7, $country, PDO::PARAM_STR);
    $stmt->bindParam(8, $favoriteGenre, PDO::PARAM_STR);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['message' => 'User added successfully']);
    } else {
        echo json_encode(['error' => 'Error adding user']);
    }

    // Close the statement
    $stmt->closeCursor();
}

// Close the database connection
$pdo = null;
?>
