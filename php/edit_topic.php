<?php
include 'config.php';

if (!isset($_POST['id'], $_POST['title'], $_POST['description'])) {
    echo "Missing data.";
    exit;
}

$id = intval($_POST['id']);
$title = trim($_POST['title']);
$description = trim($_POST['description']);

$stmt = $conn->prepare("UPDATE forum_topics SET title = ?, description = ? WHERE id = ?");
$stmt->bind_param("ssi", $title, $description, $id);

if ($stmt->execute()) {
    echo "Topic updated.";
} else {
    echo "Update failed.";
}