<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Not logged in');
}

$user_id = $_SESSION['user_id'];
$bmi = $_POST['bmi'] ?? '';
$status = $_POST['status'] ?? '';
$food = $_POST['food'] ?? '';
$exercise = $_POST['exercise'] ?? '';

$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
if ($conn->connect_error) {
    http_response_code(500);
    exit('Database error');
}

// Save to bmi_history table
$stmt = $conn->prepare("INSERT INTO bmi_history (user_id, bmi, status) VALUES (?, ?, ?)");
$stmt->bind_param("ids", $user_id, $bmi, $status);
$stmt->execute();
$stmt->close();

// Save to recommendations table
$rec_content = "Food: $food | Exercise: $exercise";
$stmt = $conn->prepare("INSERT INTO recommendations (user_id, type, content) VALUES (?, ?, ?)");
$type = "BMI Recommendation";
$stmt->bind_param("iss", $user_id, $type, $rec_content);
$stmt->execute();
$stmt->close();

$conn->close();
echo "Saved!";
?>