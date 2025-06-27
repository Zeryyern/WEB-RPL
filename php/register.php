<?php
session_start();
require_once 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    // Check if username or email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $check->close();
        $conn->close();
        header("Location: ../register.php?error=username");
        exit;
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $username, $email, $password);

    if ($stmt->execute()) {
        $stmt->close();
        $check->close();
        $conn->close();
        header("Location: ../register.php?registered=1");
        exit;
    } else {
        $stmt->close();
        $check->close();
        $conn->close();
        header("Location: ../register.php?error=server");
        exit;
    }
} else {
    header("Location: ../register.php");
    exit();
}
?>
