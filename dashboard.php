<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$username = htmlspecialchars($_SESSION['username']);
$user_id = $_SESSION['user_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch BMI history
$bmi_history = [];
$sql = "SELECT * FROM bmi_history WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $bmi_history[] = $row;
}
$stmt->close();

// Fetch recommendations (if stored)
$recommendations = [];
$sql = "SELECT * FROM recommendations WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recommendations[] = $row;
}
$stmt->close();

// Fetch feedback sent by user
$feedbacks = [];
$sql = "SELECT * FROM feedbacks WHERE user_id = ? ORDER BY submitted_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $feedbacks[] = $row;
}
$stmt->close();

// Fetch social links from DB
$social_links = [];
$result = $conn->query("SELECT * FROM social_links");
while ($row = $result->fetch_assoc()) {
    $social_links[] = $row;
}

// Fetch admin-added BMI recommendations
$bmi_recs = [];
$result = $conn->query("SELECT * FROM bmi_recommendations ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    $bmi_recs[] = $row;
}

$conn->close();
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
        position: relative;
        display: flex;
        gap: 1em;
        overflow: hidden;
        white-space: nowrap;
        animation: scroll-recipes 20s linear infinite;
        width: fit-content;
    }

    @keyframes scroll-recipes {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .recipe-card {
        flex: 0 0 220px;
        min-width: 220px;
        max-width: 220px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        overflow: hidden;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: height 0.3s ease;
        word-wrap: break-word;
    }

    .recipe-card img {
        height: 120px;
        object-fit: cover;
    }

    .recipes-container {
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        position: relative;
        margin-left: auto;
    }

    .food-details {
        width: 100%;
        box-sizing: border-box;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, opacity 0.4s ease, padding 0.4s ease;
        padding-top: 0;
        padding-bottom: 0;
        word-wrap: break-word;
        white-space: normal;
    }

    .food-details.show {
        max-height: 1000px;
        opacity: 1;
        overflow: visible;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .scrolling-recipes:hover,
    .scrolling-recipes:has(.recipe-card:hover) {
        animation-play-state: paused;
    }

    .forum-table th,
    .forum-table td {
        vertical-align: middle;
    }

    .forum-table a.text-dark:hover {
        color: #0d6efd !important;
        text-decoration: underline !important;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">YourDietBuddy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-danger rounded-pill" id="notif-count"
                                style="font-size: 0.6rem;">!</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown"
                            style="min-width: 300px;">
                            <li class="dropdown-header">Notifications</li>
                            <li>
                                <div id="notif-items" class="px-3 small text-muted">
                                    No new notifications.
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a></li>
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
                <div class="col-md-8" id="content-area" style="overflow: hidden">
                    <div id="recipes" class="content-section active">
                        <h4 class="mb-4 text-success">Healthy Recipes</h4>
                        <div class="recipes-container">
                            <div class="scrolling-recipes d-flex">
                                <!-- Salad -->
                                <div class="card recipe-card shadow-sm">
                                    <div class="recipe-image">
                                        <img src="assets/images/salad.jpg" class="card-img-top" alt="Salad">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Healthy Salad</h5>
                                        <p class="card-text">Calories: 150 kcal</p>
                                        <button class="btn btn-outline-success w-100 mt-2"
                                            onclick="toggleDetails(this)">
                                            View Details
                                        </button>
                                        <div class="food-details mt-3">
                                            <p><strong>Ingredients:</strong> Lettuce, tomato, cucumber, olive oil, lemon
                                                juice.</p>
                                            <p><strong>Kalori:</strong> 280 kcal | <strong>Protein:</strong> 6g |
                                                <strong>Lemak:</strong> 7g | <strong>Karbohidrat:</strong> 45g |
                                                <strong>Serat:</strong> 5g
                                            </p>
                                            <p><strong>Instructions:</strong> Chop all vegetables, mix in a bowl,
                                                drizzle with dressing.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Grilled Chicken -->
                                <div class="card recipe-card shadow-sm">
                                    <div class="recipe-image">
                                        <img src="assets/images/grilled_chicken.jpg" class="card-img-top"
                                            alt="Grilled Chicken">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Grilled Chicken</h5>
                                        <p class="card-text">Calories: 220 kcal</p>
                                        <button class="btn btn-outline-success w-100 mt-2"
                                            onclick="toggleDetails(this)">
                                            View Details
                                        </button>
                                        <div class="food-details mt-3">
                                            <p><strong>Ingredients:</strong> Chicken breast, olive oil, garlic, black
                                                pepper, salt, lemon juice, parsley.</p>
                                            <p><strong>Kalori:</strong> 220 kcal | <strong>Protein:</strong> 28g |
                                                <strong>Lemak:</strong> 8g | <strong>Karbohidrat:</strong> 1g |
                                                <strong>Serat:</strong> 0g
                                            </p>
                                            <p><strong>Instructions:</strong> Marinate chicken with olive oil, garlic,
                                                pepper, salt, and lemon juice. Grill until cooked through. Garnish with
                                                parsle.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pizza Bread-->
                                <div class="card recipe-card shadow-sm">
                                    <div class="recipe-image">
                                        <img src="assets/images/pizza.jpg" class="card-img-top" alt="Pizza Bread">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Pizza Bread</h5>
                                        <p class="card-text">Calories: 270 kcal</p>
                                        <button class="btn btn-outline-success w-100 mt-2"
                                            onclick="toggleDetails(this)">
                                            View Details
                                        </button>
                                        <div class="food-details mt-3">
                                            <p><strong>Ingredients:</strong> Bread slices, pizza sauce, mozzarella
                                                cheese, bell peppers, onions, olives, oregano, red chili flakes.</p>
                                            <p><strong>Calories:</strong> 270 kcal | <strong>Protein:</strong> approx.
                                                12g | <strong>Fat:</strong> approx. 8g | <strong>Carbohydrates:</strong>
                                                approx. 35g | <strong>Fiber:</strong> approx. 3g</p>
                                            <p><strong>Instructions:</strong> Spread pizza sauce on bread slices, add
                                                toppings and cheese, bake in preheated oven at 450°F (230°C) for 10-15
                                                minutes until cheese melts and edges are crispy. Serve hot.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Orange Juice -->
                                <div class="card recipe-card shadow-sm">
                                    <div class="recipe-image">
                                        <img src="assets/images/orange_juice.jpg" class="card-img-top"
                                            alt="Orange Juice">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Orange Juice</h5>
                                        <p class="card-text">Calories: 110 kcal</p>
                                        <button class="btn btn-outline-success w-100 mt-2"
                                            onclick="toggleDetails(this)">
                                            View Details
                                        </button>
                                        <div class="food-details mt-3">
                                            <p><strong>Ingredients:</strong> 8 to 10 large oranges (Valencia,
                                                tangerines, satsuma or navel), optional 1 inch organic ginger or
                                                turmeric root.</p>
                                            <p><strong>Calories:</strong> 110 kcal | <strong>Protein:</strong> approx.
                                                2g | <strong>Fat:</strong> approx. 0g | <strong>Carbohydrates:</strong>
                                                approx. 26g | <strong>Fiber:</strong> approx. 0.5g</p>
                                            <p><strong>Instructions:</strong>
                                            <ul>
                                                <li>Rinse oranges well and wipe dry.</li>
                                                <li>Cut oranges in halves and juice using a manual or electric juicer.
                                                </li>
                                                <li>Alternatively, peel and blend oranges with optional ginger or
                                                    turmeric, strain if desired.</li>
                                                <li>Serve fresh immediately. Add ice cubes if preferred.</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($bmi_recs as $rec): ?>
                                <div class="card recipe-card shadow-sm">
                                    <div class="recipe-image">
                                        <img src="<?= htmlspecialchars($rec['image']) ? htmlspecialchars($rec['image']) : 'assets/images/default_food.jpg' ?>"
                                            class="card-img-top" alt="<?= htmlspecialchars($rec['food']) ?>">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($rec['food']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($rec['category']) ?></p>
                                        <button class="btn btn-outline-success w-100 mt-2"
                                            onclick="toggleDetails(this)">
                                            View Details
                                        </button>
                                        <div class="food-details mt-3">
                                            <p><strong>Exercise:</strong>
                                                <?= nl2br(htmlspecialchars($rec['exercise'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!--BMI session-->
                    <div id="bmi" class="content-section">
                        <section class="container py-5" id="bmi">
                            <h2 class="mb-4 text-center">BMI Calculator & Personalized Food Recommendations</h2>
                            <form id="bmiForm">
                                <div class=" row mb-3">
                                    <div class="col-md-6">
                                        <label for="height" class="form-label">Height (cm)</label>
                                        <input type="number" class="form-control" id="height" placeholder="e.g. 170"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Weight (kg)</label>
                                        <input type="number" class="form-control" id="weight" placeholder="e.g. 70"
                                            required>
                                    </div>
                                </div>
                                <div class=" text-center">
                                    <button type="submit" class="btn btn-success">Calculate & Get Food Plan</button>
                                </div>
                            </form>
                            <div id="bmiResult" style="display:none;" class="mt-4">
                                <p id="bmiValue" class="text-center fw-bold text-info"></p>
                                <div id="recommendations" class="container mt-4"></div>
                            </div>
                        </section>
                    </div>

                    <!-- Feedback Sesssion-->
                    <div id="feedback" class="content-section">
                        <section class="container my-5" id="feedback">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 col-md-9">
                                    <div class="card shadow-lg border-0">
                                        <div class="card-header bg-success text-white text-center py-4">
                                            <h2 class="mb-0"><i class="bi bi-chat-dots me-2"></i>We Value Your Feedback
                                            </h2>
                                            <p class="mb-0 small">Let us know how we can improve your experience</p>
                                        </div>
                                        <div class="card-body p-4">
                                            <!-- Success/Error message placeholder -->
                                            <div id="feedbackMessage" style="display:none;" class="alert" role="alert">
                                            </div>
                                            <form id="feedbackForm" action="php/send_feedback.php" method="POST"
                                                autocomplete="off">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Your Name" required>
                                                    <label for="username"><i class="bi bi-person-fill me-1"></i>Your
                                                        Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="you@example.com" required>
                                                    <label for="email"><i class="bi bi-envelope-fill me-1"></i>Email
                                                        Address</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="subject" name="subject"
                                                        placeholder="Subject" required>
                                                    <label for="subject"><i
                                                            class="bi bi-tag-fill me-1"></i>Subject</label>
                                                </div>
                                                <div class="form-floating mb-4">
                                                    <textarea class="form-control" id="feedback" name="feedback"
                                                        placeholder="Write your message here..." style="height: 120px;"
                                                        required></textarea>
                                                    <label for="feedback"><i class="bi bi-pencil-fill me-1"></i>Your
                                                        Feedback</label>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                                                    <i class="bi bi-send-fill me-2"></i>Submit Feedback
                                                </button>
                                            </form>

                                            <div id="feedbackSuccess" class="alert alert-success mt-3 text-center"
                                                style="display: none;">
                                                ✅ Thank you! Your feedback was submitted successfully.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!--Track history Session-->
                    <div id="history" class="content-section">
                        <h4>Track History</h4>
                        <p>Review your past diet and health records here.</p>
                        <section class="container my-5">
                            <div id="historyOutput" class="table-responsive">
                                <table class="table table-bordered table-striped mt-3">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Height (cm)</th>
                                            <th>Weight (kg)</th>
                                            <th>BMI</th>
                                            <th>Status</th>
                                            <th>Recommended Food</th>
                                            <th>Suggested Exercise</th>
                                        </tr>
                                    </thead>
                                    <tbody id="historyBody">
                                        <tr>
                                            <td colspan="5">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                    </div>
                </div>
            </div>

            <hr class="my-4" />
            <div class="text-center">
                <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
            </div>
        </div>
    </div>

    <!-- Forum Container -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class=" fw-bold text-primary mb-4">Community Forum</h2>
                <p class="lead text-secondary mb-0">Discuss ideas, share feedback, and connect with others.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 forum-table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 56px;"></th>
                            <th>Topic</th>
                            <th class="text-center d-none d-sm-table-cell" style="width: 90px;">Topics</th>
                            <th class="text-center d-none d-sm-table-cell" style="width: 90px;">Posts</th>
                            <th class="d-none d-md-table-cell" style="width: 220px;">Last Post</th>
                        </tr>
                    </thead>
                    <tbody id="forumTopicsBody">
                        <!-- Topics will be loaded here dynamically by the admin-->
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <!-- VIDEO CAROUSEL -->
    <section class="container my-5">
        <h2 class="text-center fw-bold text-primary mb-4">🌿 Healthy Culinary Inspiration</h2>

        <div id="videoCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
            <div class="carousel-inner rounded-4 shadow-lg overflow-hidden">

                <!-- First Video -->
                <div class="carousel-item active position-relative">
                    <video class="d-block w-100 rounded" autoplay muted loop playsinline>
                        <source src="assets/videos/culinary.mp4" type="video/mp4">
                    </video>
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                        <h5 class="text-white fw-bold">Delicious & Nutritious Meals</h5>
                        <p class="mb-0 text-light">Learn how to cook healthy dishes at home</p>
                    </div>
                </div>

                <!-- Second Video -->
                <div class="carousel-item position-relative">
                    <video class="d-block w-100 rounded" muted loop playsinline>
                        <source src="assets/videos/exercise1.mp4" type="video/mp4">
                    </video>
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                        <h5 class="text-white fw-bold">Stay Fit with Easy Exercises</h5>
                        <p class="mb-0 text-light">Combine food with simple workouts for better results</p>
                    </div>
                </div>

                <!-- Third Video -->
                <div class="carousel-item position-relative">
                    <video class="d-block w-100 rounded" muted loop playsinline>
                        <source src="assets/videos/bmivid.mp4" type="video/mp4">
                    </video>
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                        <h5 class="text-white fw-bold">Understand Your BMI</h5>
                        <p class="mb-0 text-light">A guide to tracking your health through BMI</p>
                    </div>
                </div>

            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded-circle p-2"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded-circle p-2"></span>
            </button>
        </div>
    </section>


    <!-- Footer -->
    <?php include 'php/social_links_fetch.php'; ?>
    <?php include 'php/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
    <script>
    const scrollingRecipes = document.querySelector('.scrolling-recipes');
    if (scrollingRecipes) {
        document.querySelectorAll('.recipe-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                scrollingRecipes.style.animationPlayState = 'paused';
            });
            card.addEventListener('mouseleave', () => {
                scrollingRecipes.style.animationPlayState = 'running';
            });
        });
    }
    </script>
    <script src="js/forum_topic.js"></script>
    <script src="js/load_forum_topics.js"></script>
    <script src="js/notification.js"></script>

</body>

</html>