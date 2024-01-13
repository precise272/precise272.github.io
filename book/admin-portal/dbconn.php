<?php
// dbconn.php

$host = "precise26.netfirmsmysql.com";
$username = "preciseauthor";
$password = "Time4@book";
$dbname = "precision_destiny_books";

// Check if the connection is not already established
if (!isset($pdo)) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Log the error
        error_log("PDO Connection Error: " . $e->getMessage(), 3, "file.log");

        // Display a generic error message to the user
        die("Error connecting to the database. Please try again later.");
    }
}
?>