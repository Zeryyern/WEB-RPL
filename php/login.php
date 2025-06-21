<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'config.php'; // Connecting file to my database (Config.php)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Prepare statement to fetch user
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if password matches before allowing user access to dashboard.php
        if (password_verify($password, $user["password"])) {
            // Correct credentials
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: ../dashboard.php");
            exit();
        } else {
            // Wrong password
            $_SESSION["login_error"] = "Incorrect username/email or password.";
            header("Location: ../login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION["login_error"] = "Incorrect username/email or password.";
        header("Location: ../login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../login.php");
    exit();
}