<?php
// filepath: c:\xampp\htdocs\yourDietBuddy\php\manage_social_links.php

header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

$action = $_POST['action'] ?? '';
$platform = trim($_POST['platform'] ?? '');
$url = trim($_POST['url'] ?? '');
$id = intval($_POST['id'] ?? 0);

if ($action === 'add') {
    if ($platform && $url) {
        $stmt = $conn->prepare("INSERT INTO social_links (platform, url) VALUES (?, ?)");
        $stmt->bind_param("ss", $platform, $url);
        $success = $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing data']);
    }
} elseif ($action === 'edit') {
    if ($id && $platform && $url) {
        $stmt = $conn->prepare("UPDATE social_links SET platform=?, url=? WHERE id=?");
        $stmt->bind_param("ssi", $platform, $url, $id);
        $success = $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing data']);
    }
} elseif ($action === 'delete') {
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM social_links WHERE id=?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing ID']);
    }
} elseif ($action === 'list') {
    $result = $conn->query("SELECT * FROM social_links");
    $links = [];
    while ($row = $result->fetch_assoc()) {
        $links[] = $row;
    }
    echo json_encode(['success' => true, 'links' => $links]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();