<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register – YourDietBuddy</title>
    <link rel="icon" href="assets/images/dietIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
    body {
        background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
    }

    .card {
        border-radius: 1.5rem;
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

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill fs-1 text-success"></i>
                <h2 class="mt-2 mb-0">Create Account</h2>
            </div>
            <form action="php/register.php" method="POST" autocomplete="off">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'username'): ?>
            <div class="alert alert-danger text-center">Username or Email already exists.</div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] === 'server'): ?>
            <div class="alert alert-danger text-center">Server error. Please try again.</div>
            <?php elseif (isset($_GET['registered'])): ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            Swal.fire('Success!', 'Registration successful! You can now login.', 'success');
            </script>
            <?php endif; ?>

                <div class="mb-3 icon-input">
                    <label for="name" class="form-label">Full Name</label>
                    <i class="bi bi-person-fill"></i>
                    <input type="text" class="form-control" id="name" name="fullname" placeholder="Your full name"
                        required>
                </div>
                <div class="mb-3 icon-input">
                    <label for="reg-username" class="form-label">Username</label>
                    <i class="bi bi-person-badge"></i>
                    <input type="text" class="form-control" id="reg-username" name="username"
                        placeholder="Choose a username" required>
                </div>
                <div class="mb-3 icon-input">
                    <label for="reg-email" class="form-label">Email</label>
                    <i class="bi bi-envelope-fill"></i>
                    <input type="email" class="form-control" id="reg-email" name="email" placeholder="Your email"
                        required>
                </div>
                <div class="mb-3 icon-input">
                    <label for="reg-password" class="form-label">Password</label>
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" class="form-control" id="reg-password" name="password"
                        placeholder="Create a password" required>
                </div>
                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </button>
                </div>
                <p class="text-center mb-0">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>