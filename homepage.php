<?php
include 'php/social_links_fetch.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>YourDietBuddy – Home</title>
    <link rel="icon" href="assets/images/dietIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">YourDietBuddy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-house-door-fill me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">
                            <i class="bi bi-info-circle-fill me-1"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Home Content -->
    <header class="bg-success hero-section text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Welcome to YourDietBuddy 🍽️</h1>
            <p class="lead">Eat Smart. Live Healthy. Personalized Diet & Fitness Plans.</p>
        </div>
    </header>

    <section class="container py-5">
        <div class="row text-center">
            <div class="col-md-6">
                <a href="#order" class="btn btn-primary btn-lg w-100 mb-3">
                    <i class="bi bi-basket me-2"></i> Resep Sehat
                </a>
            </div>
            <div class="col-md-6">
                <a href="#bmi" class="btn btn-outline-success btn-lg w-100 mb-3">
                    <i class="bi bi-calculator me-2"></i> Order Based on BMI
                </a>
            </div>
        </div>
    </section>

    <!-- Resep Sehat -->
    <section class="container py-4" id="order">
        <h2 class="text-center mb-4">Resep Sehat</h2>
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/salad.jpg" class="card-img-top" alt="Salad">
                    <div class="card-body">
                        <h5 class="card-title">Healthy Salad</h5>
                        <p class="card-text">Fresh vegetable salad with light dressing.</p>
                        <p class="card-text">Calories: 150 kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Lettuce, tomato, cucumber, olive oil, lemon juice.</p>
                            <p><strong>Kalori:</strong> 280 kcal | <strong>Protein:</strong> 6g |
                                <strong>Lemak:</strong> 7g | <strong>Karbohidrat:</strong> 45g | <strong>Serat:</strong>
                                5g
                            </p>
                            <p><strong>Instructions:</strong> Chop all vegetables, mix in a bowl, drizzle with dressing.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/grilled_chicken.jpg" class="card-img-top" alt="Grilled Chicken">
                    <div class="card-body">
                        <h5 class="card-title">Grilled Chicken</h5>
                        <p class="card-text">Low-fat protein meal served with greens.</p>
                        <p class="card-text">Calories : 220 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Chicken breast, olive oil, garlic, black pepper, salt,
                                lemon juice, parsley.</p>
                            <p><strong>Kalori:</strong> 220 kcal | <strong>Protein:</strong> 28g |
                                <strong>Lemak:</strong> 8g | <strong>Karbohidrat:</strong> 1g | <strong>Serat:</strong>
                                0g
                            </p>
                            <p><strong>Instructions:</strong> Marinate chicken with olive oil, garlic, pepper, salt, and
                                lemon juice. Grill until cooked through. Garnish with parsle.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/pizza.jpg" class="card-img-top" alt="Pizza Bread">
                    <div class="card-body">
                        <h5 class="card-title">Pizza Bread</h5>
                        <p class="card-text">Savory, satisfying bread topped with rich flavors and protein.</p>
                        <p class="card-text">Calories : 270 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Whole wheat bread, tomato sauce, mozzarella cheese, bell
                                pepper, oregano.</p>
                            <p><strong>Kalori:</strong> 270 kcal | <strong>Protein:</strong> 10g |
                                <strong>Lemak:</strong> 9g | <strong>Karbohidrat:</strong> 35g | <strong>Serat:</strong>
                                4g
                            </p>
                            <p><strong>Instructions:</strong> Spread tomato sauce on bread, add cheese and toppings.
                                Bake until cheese melts.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/orange_juice.jpg" class="card-img-top" alt="Orange Juice">
                    <div class="card-body">
                        <h5 class="card-title">Orange Juice</h5>
                        <p class="card-text">Refreshing juice rich in vitamin C and antioxidants.</p>
                        <p class="card-text">Calories: 110 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Fresh oranges.</p>
                            <p><strong>Kalori:</strong> 110 kcal | <strong>Protein:</strong> 2g |
                                <strong>Lemak:</strong> 0g | <strong>Karbohidrat:</strong> 25g | <strong>Serat:</strong>
                                1g
                            </p>
                            <p><strong>Instructions:</strong> Squeeze oranges. Serve juice chilled.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/pineapple_salad.jpg" class="card-img-top" alt="Pineapple Salad">
                    <div class="card-body">
                        <h5 class="card-title">Pineapple Salad</h5>
                        <p class="card-text">Tropical salad rich in vitamin C and enzymes.</p>
                        <p class="card-text">Calories: 90 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Pineapple, cucumber, mint leaves, lime juice.</p>
                            <p><strong>Kalori:</strong> 90 kcal | <strong>Protein:</strong> 1g | <strong>Lemak:</strong>
                                0g | <strong>Karbohidrat:</strong> 22g | <strong>Serat:</strong> 2g</p>
                            <p><strong>Instructions:</strong> Chop pineapple and cucumber. Toss with mint and lime
                                juice.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/fruit_smoothie.jpg" class="card-img-top" alt="Smoothie">
                    <div class="card-body">
                        <h5 class="card-title">Fruit Smoothie</h5>
                        <p class="card-text">Blended fruits packed with vitamins.</p>
                        <p class="card-text">Calories : 180 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Banana, strawberry, yogurt, honey.</p>
                            <p><strong>Kalori:</strong> 180 kcal | <strong>Protein:</strong> 5g |
                                <strong>Lemak:</strong> 2g | <strong>Karbohidrat:</strong> 38g | <strong>Serat:</strong>
                                3g
                            </p>
                            <p><strong>Instructions:</strong> Blend all ingredients until smooth.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/shrimp_egg.jpg" class="card-img-top" alt="Shrimp & Egg">
                    <div class="card-body">
                        <h5 class="card-title">Shrimp & Egg</h5>
                        <p class="card-text">Protein-packed shrimp and egg combo.</p>
                        <p class="card-text">Calories : 200 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Shrimp, eggs, spring onion, olive oil, pepper.</p>
                            <p><strong>Kalori:</strong> 200 kcal | <strong>Protein:</strong> 18g |
                                <strong>Lemak:</strong> 10g | <strong>Karbohidrat:</strong> 2g | <strong>Serat:</strong>
                                0g
                            </p>
                            <p><strong>Instructions:</strong> Sauté shrimp in olive oil, add beaten eggs and spring
                                onion, cook until set.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/nasi_goreng.jpg" class="card-img-top" alt="Nasi Goreng">
                    <div class="card-body">
                        <h5 class="card-title">Nasi Goreng</h5>
                        <p class="card-text">Spicy, savory fried rice with bold flavors.</p>
                        <p class="card-text">Calories : 350 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Cooked rice, egg, shallot, garlic, soy sauce, chili,
                                carrot.</p>
                            <p><strong>Kalori:</strong> 350 kcal | <strong>Protein:</strong> 8g |
                                <strong>Lemak:</strong> 9g | <strong>Karbohidrat:</strong> 58g | <strong>Serat:</strong>
                                3g
                            </p>
                            <p><strong>Instructions:</strong> Stir-fry shallot, garlic, and carrot. Add rice, egg, soy
                                sauce, and chili. Cook until well mixed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <img src="assets/images/broccoli_egg.jpg" class="card-img-top" alt="Broccoli & Egg">
                    <div class="card-body">
                        <h5 class="card-title">Broccoli & Egg</h5>
                        <p class="card-text">Nutritious combo of steamed broccoli and boiled egg.</p>
                        <p class="card-text">Calories : 160 Kcal</p>
                        <button class="btn btn-outline-success w-100 mt-2" onclick="toggleDetails(this)">
                            View Details
                        </button>
                        <div class="food-details mt-3" style="display: none;">
                            <p><strong>Ingredients:</strong> Broccoli, boiled eggs, olive oil, pepper, garlic.</p>
                            <p><strong>Kalori:</strong> 160 kcal | <strong>Protein:</strong> 12g |
                                <strong>Lemak:</strong> 8g | <strong>Karbohidrat:</strong> 6g | <strong>Serat:</strong>
                                4g
                            </p>
                            <p><strong>Instructions:</strong> Steam broccoli. Serve with sliced boiled egg and a dash of
                                olive oil and pepper.</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        </div>
    </section>

    <!-- Testimonial  -->
    <section id="testimonials" class="my-5 text-center">
        <h2>From our Customers</h2>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/saidah.jpg" class="rounded-circle mx-auto d-block mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;" alt="Saidah Profile">
                    <h5>Usrotun Saidah</h5>
                    <p class="text-muted px-3">YourDietBuddy didn’t just help me lose weight, it helped me gain confidence.</p>
                </div>
                <div class="carousel-item">
                    <img src="assets/images/zayn.jpeg" class="rounded-circle mx-auto d-block mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;" alt="Zeryyern Profile">
                    <h5>Zeryyern Awwerl </h5>
                    <p class="text-muted px-3">No crash diets. Just smart food choices with YourDietBuddy.</p>
                </div>
                <div class="carousel-item">
                    <img src="assets/images/lia.jpg" class="rounded-circle mx-auto d-block mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;" alt="Safira Profile">
                    <h5>Safira Aulia Azzahra </h5>
                    <p class="text-muted px-3">The food suggestions are delicious, healthy, and fit my goals perfectly!</p>
                </div>

            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
    </section>

    <!-- BMI Form -->
    <section class="container py-5" id="bmi">
        <h2 class="mb-4">Order Based on BMI</h2>
        <form>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="height" class="form-label">Height (in cm)</label>
                    <input type="number" class="form-control" id="height" placeholder="e.g. 170">
                </div>
                <div class="col-md-6">
                    <label for="weight" class="form-label">Weight (in kg)</label>
                    <input type="number" class="form-control" id="weight" placeholder="e.g. 70">
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="calculateBMI()">Get Recommendations</button>
        </form>

        <div class="mt-4" id="bmiResult" style="display:none;">
            <h4>Your BMI Result:</h4>
            <p id="bmiValue"></p>
            <div id="recommendations"></div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="container my-5" id="feedbackForm">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white">
                <h2 class="mb-0 text-center">We Value Your Feedback</h2>
            </div>
            <div class="card-body">
                <form id="feedbackFormElement" action="php/send_feedback.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject"
                            placeholder="Subject of your feedback" required>
                    </div>
                    <div class="mb-3">
                        <label for="feedback" class="form-label">Your Feedback</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="4"
                            placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Submit Feedback</button>
                </form>
                <div id="feedbackSuccess" class="alert alert-success mt-3 text-center" style="display: none;">
                    ✅ Thank you! Your feedback was submitted successfully.
                </div>
            </div>
    </section>

    <!-- VIDEO CAROUSEL -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Healthy Culinary Videos</h2>
        <div id="videoCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#videoCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#videoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#videoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner rounded shadow">
                <div class="carousel-item active">
                    <video class="d-block w-100" autoplay muted playsinline>
                        <source src="assets/videos/culinary.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="carousel-item">
                    <video class="d-block w-100" muted playsinline>
                        <source src="assets/videos/exercise1.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="carousel-item">
                    <video class="d-block w-100" muted playsinline>
                        <source src="assets/videos/bmivid.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <!-- Carousel controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <?php include 'php/social_links_fetch.php'; ?>
    <?php include 'php/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/feedback.js"></script>
</body>

</html>