<?php
include 'config.php';

$result = $conn->query("SELECT id, title, description FROM forum_topics ORDER BY created_at DESC");
$topics = [];

while ($row = $result->fetch_assoc()) {
    $topics[] = $row;
}

header('Content-Type: application/json');
echo json_encode($topics);
?>