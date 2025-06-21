<?php
include 'config.php';

if (!isset($_POST['title']) || !isset($_POST['description'])) {
    echo "Missing fields.";
    exit;
}

$title = trim($_POST['title']);
$description = trim($_POST['description']);

// Debug: show what's being received
file_put_contents("debug_log.txt", "Title: $title | Description: $description\n", FILE_APPEND);

$stmt = $conn->prepare("INSERT INTO forum_topics (title, description, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("ss", $title, $description);

if ($stmt->execute()) {
    echo "Topic added.";
} else {
    echo "Failed to add topic.";
}