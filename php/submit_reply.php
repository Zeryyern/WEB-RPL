<?php
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $response = $_POST['response'];

    $stmt = $conn->prepare("UPDATE feedbacks SET response = ?, responded_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $response, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../admin.html");
    exit;
}
?>