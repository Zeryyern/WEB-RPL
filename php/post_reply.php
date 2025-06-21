<?php
session_start();
include 'config.php';

$topic_id = $_POST['topic_id'];
$content = trim($_POST['content']);
$username = $_SESSION['username'] ?? 'guest';

if (!$content || !$topic_id) {
    echo "Invalid input.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO forum_replies (topic_id, username, content, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iss", $topic_id, $username, $content);
$stmt->execute();

header("Location: forum_topic.php?id=$topic_id");
exit;
?>