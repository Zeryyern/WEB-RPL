<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE feedbacks SET read_by_user = 1 WHERE user_id = ? AND response IS NOT NULL");
$stmt->bind_param("i", $user_id);
$stmt->execute();