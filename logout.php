<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Logout Confirmation</title>
    <link rel="icon" href="assets/images/dietIcon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h3 class="mb-3 text-center">Confirm Logout</h3>
        <p class="text-center">Are you sure you want to logout,
            <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>?
        </p>
        <div class="d-flex justify-content-around mt-4">
            <a href="homepage.php" class="btn btn-danger">Yes, Logout</a>
            <a href="dashboard.php" class="btn btn-secondary">No, Stay Logged In</a>
        </div>
    </div>
</body>

</html>