<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Optional: Fetch more user info from DB if needed
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>YourDietBuddy – Dashboard</title>
  <link rel="icon" href="assets/images/dietIcon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9 0%, #fff 100%);
      min-height: 100vh;
    }

    .dashboard-card {
      border-radius: 18px;
      box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
      background: #fff;
    }

    .profile-icon {
      width: 64px;
      height: 64px;
      background: #e0f7fa;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: #00796b;
      margin: 0 auto 1rem auto;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="homepage.html">YourDietBuddy</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <i class="bi bi-speedometer2 me-1 active"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="homepage.html">
              <i class="bi bi-house-door-fill me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Dashboard Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="dashboard-card p-5 text-center">
          <div class="profile-icon mb-3">
            <i class="bi bi-person-circle"></i>
          </div>
          <h2 class="mb-3">Welcome, <span class="text-success"><?= $username ?></span>!</h2>
          <p class="lead mb-4">This is your personalized dashboard. Explore healthy recipes, track your BMI, and manage your diet journey with YourDietBuddy.</p>

          <div class="row g-4">
            <div class="col-md-4">
              <a href="homepage.html#order" class="btn btn-outline-success w-100 py-3">
                <i class="bi bi-basket fs-3 mb-2"></i><br>
                Healthy Recipes
              </a>
            </div>
            <div class="col-md-4">
              <a href="homepage.html#bmi" class="btn btn-outline-primary w-100 py-3">
                <i class="bi bi-calculator fs-3 mb-2"></i><br>
                BMI Calculator
              </a>
            </div>
            <div class="col-md-4">
              <a href="homepage.html#feedback" class="btn btn-outline-secondary w-100 py-3">
                <i class="bi bi-chat-dots fs-3 mb-2"></i><br>
                Give Feedback
              </a>
            </div>
            <div class="row mt-4">
              <div class="col text-center">
                <a href="homepage.html#feedback" class="btn btn-outline-secondary px-5 py-3">
                  <i class="bi bi-clock-history fs-3 mb-2"></i><br>
                  Track History
                </a>
              </div>
            </div>
          </div>
          <hr class="my-4">
          <a href="logout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center p-4 mt-5">
    <p class="mb-2">Follow us:</p>
    <a href="#" class="text-white me-3 fs-4" aria-label="Facebook">
      <i class="bi bi-facebook"></i>
    </a>
    <a href="#" class="text-white me-3 fs-4" aria-label="Instagram">
      <i class="bi bi-instagram"></i>
    </a>
    <a href="#" class="text-white me-3 fs-4" aria-label="Twitter">
      <i class="bi bi-twitter"></i>
    </a>
    <a href="#" class="text-white me-3 fs-4" aria-label="Github">
      <i class="bi bi-github"></i>
    </a>
    <p class="mt-3 mb-0">© 2025 YourDietBuddy. All rights reserved.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>