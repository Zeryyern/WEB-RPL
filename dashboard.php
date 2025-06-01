<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>YourDietBuddy – Dashboard</title>
  <link rel="icon" href="assets/images/dietIcon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9 0%, #fff 100%);
      min-height: 100vh;
    }

    .dashboard-card {
      border-radius: 18px;
      box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
      background: #fff;
      padding: 2rem;
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

    #content-area>div {
      display: none;
    }

    #content-area>div.active {
      display: block;
    }

    .scrolling-recipes {
      overflow-x: auto;
      white-space: nowrap;
    }

    .recipe-card {
      display: inline-block;
      width: 280px;
      margin-right: 1rem;
    }

    .food-details {
      max-width: 100%;
      overflow-wrap: break-word;
      word-wrap: break-word;
      word-break: break-word;
      box-sizing: border-box;
      background-color: #f8f9fa;
      padding: 1rem;
      border-radius: 0.25rem;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
      transition: max-height 0.3s ease, opacity 0.3s ease, padding 0.3s ease;
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      padding-top: 0;
      padding-bottom: 0;
    }

    .food-details.show {
      max-height: 1000px;
      opacity: 1;
      overflow: visible;
      padding-top: 1rem;
      padding-bottom: 1rem;
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
          <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="homepage.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Dashboard Content -->
  <div class="container py-5">
    <div class="dashboard-card">
      <div class="profile-icon mb-3"><i class="bi bi-person-circle"></i></div>
      <h2 class="text-center mb-3">Welcome, <span class="text-success"><?= $username ?></span>!</h2>
      <p class="lead text-center mb-5">Explore healthy recipes, track your BMI, and manage your diet journey.</p>

      <div class="row">
        <!-- Left: Buttons -->
        <div class="col-md-4 d-grid gap-3">
          <button class="btn btn-outline-success py-3" data-target="recipes">
            <i class="bi bi-basket fs-3 mb-2"></i><br>Healthy Recipes
          </button>
          <button class="btn btn-outline-primary py-3" data-target="bmi">
            <i class="bi bi-calculator fs-3 mb-2"></i><br>BMI Calculator
          </button>
          <button class="btn btn-outline-secondary py-3" data-target="feedback">
            <i class="bi bi-chat-dots fs-3 mb-2"></i><br>Give Feedback
          </button>
          <button class="btn btn-outline-secondary py-3" data-target="history">
            <i class="bi bi-clock-history fs-3 mb-2"></i><br>Track History
          </button>
        </div>

        <!-- Right: Content sections -->
        <div class="col-md-8" id="content-area">
          <div id="recipes" class="content-section">
            <h4 class="mb-4 text-success">Healthy Recipes</h4>
            <div class="scrolling-recipes d-flex">
              <!-- Salad -->
              <div class="card recipe-card shadow-sm">
                <img src="assets/images/salad.jpg" class="card-img-top" alt="Salad">
                <div class="card-body">
                  <h5 class="card-title">Healthy Salad</h5>
                  <p class="card-text">Calories: 150 kcal</p>
                  <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                    View Details
                  </button>
                  <div class="food-details mt-3" style="display: none;">
                    <p><strong>Ingredients:</strong> Lettuce, tomato, cucumber, olive oil, lemon juice.</p>
                    <p><strong>Kalori:</strong> 280 kcal | <strong>Protein:</strong> 6g | <strong>Lemak:</strong> 7g | <strong>Karbohidrat:</strong> 45g | <strong>Serat:</strong> 5g</p>
                    <p><strong>Instructions:</strong> Chop all vegetables, mix in a bowl, drizzle with dressing.</p>
                  </div>
                </div>
              </div>

              <!-- Grilled Chicken -->
              <div class="card recipe-card shadow-sm">
                <img src="assets/images/grilled_chicken.jpg" class="card-img-top" alt="Grilled Chicken">
                <div class="card-body">
                  <h5 class="card-title">Grilled Chicken</h5>
                  <p class="card-text">Calories: 220 kcal</p>
                </div>
              </div>

              <!-- Pizza Bread -->
              <div class="card recipe-card shadow-sm">
                <img src="assets/images/pizza.jpg" class="card-img-top" alt="Pizza Bread">
                <div class="card-body">
                  <h5 class="card-title">Pizza Bread</h5>
                  <p class="card-text">Calories: 270 kcal</p>
                </div>
              </div>

              <!-- Orange Juice -->
              <div class="card recipe-card shadow-sm">
                <img src="assets/images/orange_juice.jpg" class="card-img-top" alt="Orange Juice">
                <div class="card-body">
                  <h5 class="card-title">Orange Juice</h5>
                  <p class="card-text">Calories: 110 kcal</p>
                </div>
              </div>
            </div>
          </div>

          <div id="bmi" class="content-section">
            <h4>BMI Calculator</h4>
            <p>Calculate your Body Mass Index and track your health progress.</p>
          </div>

          <div id="feedback" class="content-section">
            <h4>Give Feedback</h4>
            <p>We value your feedback to improve YourDietBuddy.</p>
          </div>

          <div id="history" class="content-section">
            <h4>Track History</h4>
            <p>Review your past diet and health records here.</p>
          </div>
        </div>
      </div>

      <hr class="my-4" />
      <div class="text-center">
        <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center p-4 mt-5">
    <p class="mb-2">Follow us:</p>
    <a href="#" class="text-white me-3 fs-4"><i class="bi bi-facebook"></i></a>
    <a href="#" class="text-white me-3 fs-4"><i class="bi bi-instagram"></i></a>
    <a href="#" class="text-white me-3 fs-4"><i class="bi bi-twitter"></i></a>
    <a href="#" class="text-white me-3 fs-4"><i class="bi bi-github"></i></a>
    <p class="mt-3 mb-0">© 2025 YourDietBuddy. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const buttons = document.querySelectorAll('.btn[data-target]');
    const sections = document.querySelectorAll('#content-area > div');

    function showSection(id) {
      sections.forEach(section => {
        section.classList.remove('active');
        if (section.id === id) section.classList.add('active');
      });
    }

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const target = button.getAttribute('data-target');
        showSection(target);
      });
    });
  </script>
  <script src="js/script.js"></script>
</body>

</html>