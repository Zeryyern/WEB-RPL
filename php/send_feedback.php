<?php
session_start();
include 'config.php'; 

header('Content-Type: application/json'); // JSON response

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$user_id = null;

// Check if guest
if (!empty($_POST['username']) && !empty($_POST['email'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // Create guest if not found
    if (!$user_id) {
        $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $email);
        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "User creation failed."]);
            exit;
        }
        $user_id = $stmt->insert_id;
        $stmt->close();
    }
} elseif (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing user info."]);
    exit;
}

$subject = trim($_POST['subject'] ?? '');
$feedback = trim($_POST['feedback'] ?? '');

if (empty($subject) || empty($feedback)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Subject and feedback are required."]);
    exit;
}

// Insert feedback
$stmt = $conn->prepare("INSERT INTO feedbacks (user_id, feedback) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $feedback);
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Feedback submitted successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Could not save feedback."]);
}
$stmt->close();
?>