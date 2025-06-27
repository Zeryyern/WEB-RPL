<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Not logged in');
}

$user_id = $_SESSION['user_id'];
$height = floatval($_POST['height'] ?? 0);
$weight = floatval($_POST['weight'] ?? 0);
$bmi = floatval($_POST['bmi'] ?? 0);
$status = $_POST['status'] ?? '';
$food = trim($_POST['food'] ?? '');
$exercise = trim($_POST['exercise'] ?? '');

$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
if ($conn->connect_error) {
    http_response_code(500);
    exit('Database connection error');
}

// 🔹 Step 1: Simpan ke tabel bmi_history
$stmt = $conn->prepare("INSERT INTO bmi_history (user_id, height, weight, bmi, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iddds", $user_id, $height, $weight, $bmi, $status);

if (!$stmt->execute()) {
    http_response_code(500);
    exit('Failed to save BMI history');
}

$bmi_history_id = $stmt->insert_id; // ambil ID-nya untuk relasi
$stmt->close();

// 🔹 Step 2: Simpan ke tabel recommendations dengan relasi ke bmi_history
$rec_content = "Food: $food | Exercise: $exercise";
$type = "BMI Recommendation";

$stmt = $conn->prepare("INSERT INTO recommendations (user_id, type, content, bmi_history_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $user_id, $type, $rec_content, $bmi_history_id);

if (!$stmt->execute()) {
    http_response_code(500);
    exit('Failed to save recommendation');
}
$stmt->close();

$conn->close();
echo "Saved!";
?>