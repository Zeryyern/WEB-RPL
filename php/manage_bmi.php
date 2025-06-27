<?php
$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
if ($conn->connect_error) die(json_encode(['success'=>false, 'message'=>'DB error']));

$action = $_POST['action'] ?? '';

if ($action === 'list') {
    $result = $conn->query("SELECT * FROM bmi_recommendations ORDER BY id DESC");
    $data = [];
    while ($row = $result->fetch_assoc()) $data[] = $row;
    echo json_encode(['success'=>true, 'recommendations'=>$data]);
    exit;
}

if ($action === 'add') {
    $category = $_POST['category'] ?? '';
    $food = $_POST['food'] ?? '';
    $calory = $_POST['calory'] ?? '';
    $exercise = $_POST['exercise'] ?? '';
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/';
        $filename = uniqid('bmi_') . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'assets/images/' . $filename;
        }
    }

    $stmt = $conn->prepare("INSERT INTO bmi_recommendations 
        (category, food, calory, exercise, image)
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $category, $food, $calory, $exercise, $imagePath);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success'=>true]);
    exit;
}

if ($action === 'delete') {
    $id = intval($_POST['id']);
    // Optionally, delete the image file from server here
    $conn->query("DELETE FROM bmi_recommendations WHERE id=$id");
    echo json_encode(['success'=>true]);
    exit;
}

echo json_encode(['success'=>false, 'message'=>'Invalid action']);