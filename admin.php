<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';

    if (str_ends_with($username, '@student.uns.ac.id')) {
        header('Location: admin/admin.html');
        exit();
    } else {
        $_SESSION['admin_login_error'] = 'Username Error';
        header('Location: admin.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Login – YourDietBuddy</title>
    <link rel="icon" href="assets/images/dietIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
    body {
        background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
    }

    .card {
        border-radius: 1.5rem;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .15);
    }

    .icon-input {
        position: relative;
    }

    .icon-input .bi {
        position: absolute;
        left: 12px;
        top: 70%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .icon-input input {
        padding-left: 2.2rem;
    }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 w-100" style="max-width: 400px;">
            <div class="text-center mb-4">
                <i class="bi bi-person-circle fs-1 text-primary"></i>
                <h2 class="mt-2 mb-0">Admin Login</h2>
            </div>
            <?php
                if (isset($_SESSION['admin_login_error'])) {
                    echo '<div class="alert alert-danger text-center">' . $_SESSION['admin_login_error'] . '</div>';
                    unset($_SESSION['admin_login_error']);
                }
            ?>
            <form method="POST" action="">
                <div class="mb-3 icon-input">
                    <label for="username" class="form-label">Username or Email</label>
                    <i class="bi bi-person-fill"></i>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="mb-3 icon-input">
                    <label for="password" class="form-label">Password</label>
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                </div>
                <div class="text-center">
                    <a href="homepage.php" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-house-door me-1"></i> Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'php/social_links_fetch.php'; ?>
    <?php include 'php/footer.php'; ?>
</body>

</html>