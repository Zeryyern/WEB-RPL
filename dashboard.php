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
                    <li class="nav-item"><a class="nav-link active" href="#">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="homepage.html">
                            <i class="bi bi-house-door-fill me-1"></i>Home
                        </a></li>
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

    function toggleDetails(button) {
        const allCards = document.querySelectorAll('.recipe-card');

        allCards.forEach(card => {
            const image = card.querySelector('.recipe-image');
            const details = card.querySelector('.food-details');
            const btn = card.querySelector('button');

            if (card === button.closest('.recipe-card')) {
                // Toggle clicked card
                const isShowing = details.classList.contains('show');
                if (isShowing) {
                    image.classList.remove('hidden');
                    details.classList.remove('show');
                    btn.textContent = 'View Details';
                } else {
                    image.classList.add('hidden');
                    details.classList.add('show');
                    btn.textContent = 'Hide Details';
                }
            } else {
                // Close all other cards
                image.classList.remove('hidden');
                details.classList.remove('show');
                btn.textContent = 'View Details';
            }
        });
    }
    </script>
</body>

</html>