<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        // Logged-in user
        $user_id = $_SESSION['user_id'];
        // You can optionally get username/email from session if needed
    } else {
        // Guest user - get name and email from POST
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($username) || empty($email)) {
            header("Location: ../homepage.php?feedback=error&message=missing_user_info");
            exit;
        }

        // Check if guest user already exists by email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // If user does not exist, create new guest user
        if (!$user_id) {
            $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $email);
            if (!$stmt->execute()) {
                $stmt->close();
                header("Location: ../homepage.php?feedback=error&message=user_insert_failed");
                exit;
            }
            $user_id = $stmt->insert_id;
            $stmt->close();
        }
    }

    // Get feedback and subject
    $subject = trim($_POST['subject'] ?? '');
    $feedback = trim($_POST['feedback'] ?? '');

    if (empty($subject) || empty($feedback)) {
        header("Location: ../homepage.php?feedback=error&message=missing_feedback");
        exit;
    }

    // Insert feedback
    $stmt = $conn->prepare("INSERT INTO feedbacks (user_id, feedback) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $feedback);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../homepage.php?feedback=success");
        exit;
    } else {
        $stmt->close();
        header("Location: ../homepage.php?feedback=error&message=feedback_insert_failed");
        exit;
    }
} else {
    // Invalid request method
    header("Location: ../homepage.php");
    exit;
}
?>