<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
if ($conn->connect_error) {
    if (isset($_POST['action'])) {
        echo json_encode(['success' => false, 'message' => 'DB connection error']);
        exit;
    } else {
        die("Database connection error");
    }
}

$action = $_POST['action'] ?? '';

// ==== List Recommendations ====
if ($action === 'list') {
    $result = $conn->query("SELECT * FROM bmi_recommendations ORDER BY id DESC");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'recommendations' => $data]);
    exit;
}

// ==== Add Recommendation (Form or AJAX) ====
if ($action === 'add' || isset($_POST['bmiCategory'])) {
    $category = $_POST['category'] ?? $_POST['bmiCategory'] ?? $_REQUEST['category'] ?? $_REQUEST['bmiCategory'] ?? '';
    $food = $_POST['food'] ?? $_POST['foodName'] ?? $_REQUEST['food'] ?? $_REQUEST['foodName'] ?? '';
    // Force calory to integer, fallback to 0 if not set
    $calory = isset($_POST['calory']) ? intval($_POST['calory']) : (isset($_REQUEST['calory']) ? intval($_REQUEST['calory']) : 0);
    $exercise = $_POST['exercise'] ?? $_REQUEST['exercise'] ?? '';

    $imagePath = '';

    // Handle image upload for both image and foodImage fields
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/';
        $filename = uniqid('bmi_') . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'assets/images/' . $filename;
        }
    } elseif (isset($_FILES['foodImage']) && $_FILES['foodImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = realpath(__DIR__ . '/../assets/images/') . '/';
        $filename = basename($_FILES['foodImage']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['foodImage']['tmp_name'], $targetFile)) {
            $imagePath = $filename;
        }
    }

    // Use "ssiss" for bind_param: s=string, i=integer
    $stmt = $conn->prepare("INSERT INTO bmi_recommendations (category, food, calory, exercise, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $category, $food, $calory, $exercise, $imagePath);

    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        if ($action === 'add') {
            echo json_encode(['success' => false, 'message' => $error]);
            exit;
        } else {
            die("Database error: " . $error);
        }
    }

    $stmt->close();
    $conn->close();

    if ($action === 'add') {
        echo json_encode(['success' => true]);
        exit;
    } else {
        header("Location: ../admin/admin.html?success=1");
        exit;
    }
}

// ==== Delete Recommendation ====
if ($action === 'delete') {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM bmi_recommendations WHERE id=$id");
    echo json_encode(['success' => true]);
    exit;
}

// ==== Invalid Action ====
echo json_encode(['success' => false, 'message' => 'Invalid action']);
$conn->close();
?>
