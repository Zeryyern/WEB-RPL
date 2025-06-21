<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "Missing ID.";
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM forum_topics WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Topic deleted.";
} else {
    echo "Delete failed.";
}