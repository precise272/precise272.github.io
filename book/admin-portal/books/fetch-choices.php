<?php
// Include the database connection file
include_once "../dbconn.php";

try {
    // Fetch choices for the specified page
    $stmt = $pdo->prepare("SELECT * FROM choices WHERE page_id = ?");
    $stmt->execute([$_GET['page_id']]);
    $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send data as JSON
    header('Content-Type: application/json');
    echo json_encode($choices);
} catch (PDOException $e) {
    // Handle error
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>