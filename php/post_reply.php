<?php
session_start();
include 'config.php';

$topic_id = intval($_POST['topic_id']);
$content = trim($_POST['content']);

// Make sure user is logged in
if (!isset($_SESSION['user_id']) || !$content || !$topic_id) {
    echo "Invalid input or user not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Insert into forum_replies with user_id
$stmt = $conn->prepare("INSERT INTO forum_replies (topic_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $topic_id, $user_id, $content);
$stmt->execute();
$stmt->close();

header("Location: forum_topic.php?id=$topic_id");
exit;
?>
