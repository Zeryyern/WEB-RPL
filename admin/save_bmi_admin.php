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

// ==== List Recommendations (AJAX) ====
if ($action === 'list') {
    $result = $conn->query("SELECT * FROM bmi_recommendations ORDER BY id DESC");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'recommendations' => $data]);
    exit;
}

// ==== Add Recommendation (AJAX or Form) ====
if ($action === 'add' || isset($_POST['bmiCategory'])) {
    // Support both naming schemes (form & ajax)
    $category = $_POST['category'] ?? $_POST['bmiCategory'] ?? '';
    $food = $_POST['food'] ?? $_POST['foodName'] ?? '';
    $calory = $_POST['calory'] ?? '';
    $exercise = $_POST['exercise'] ?? '';
    $imagePath = '';

    // Image handling for AJAX or Form
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

    // Insert into DB (only the original fields)
    $stmt = $conn->prepare("INSERT INTO bmi_recommendations 
        (category, food, calory, exercise, image)
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $category, $food, $calory, $exercise, $imagePath);

    if (!$stmt->execute()) {
        if ($action === 'add') {
            echo json_encode(['success' => false, 'message' => $stmt->error]);
            exit;
        } else {
            die("Database error: " . $stmt->error);
        }
    }

    $stmt->close();
    $conn->close();

    // AJAX or form redirection
    if ($action === 'add') {
        echo json_encode(['success' => true]);
        exit;
    } else {
        header("Location: ../admin/admin.html?success=1");
        exit;
    }
}

// ==== Delete Recommendation (AJAX only) ====
if ($action === 'delete') {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM bmi_recommendations WHERE id=$id");
    echo json_encode(['success' => true]);
    exit;
}

// ==== Invalid Action ====
echo json_encode(['success' => false, 'message' => 'Invalid action']);
$conn->close();