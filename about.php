<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - YourDietBuddy</title>
    <link rel="icon" href="assets/images/dietIcon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #fff;
        color: #333;
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .feature-image {
        width: 100%;
        border-radius: 12px;
        object-fit: cover;
        aspect-ratio: 16/10;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .feature-block {
        padding: 40px 0;
    }

    .feature-heading {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #212529;
    }

    .feature-description {
        font-size: 1rem;
        color: #555;
    }

    footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        color: #6c757d;
    }

    footer a {
        color: #6c757d;
        transition: color 0.3s ease;
    }

    footer a:hover {
        color: #0d6efd;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php">YourDietBuddy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="homepage.php"><i class="bi bi-house-door me-1"></i>
                            Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-info-circle me-1"></i>
                            About</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php"><i
                                class="bi bi-box-arrow-in-right me-1"></i> Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Intro -->
    <section class="py-5 text-center">
        <div class="container">
            <h2 class="section-title">Tentang YourDietBuddy</h2>
            <p class="lead text-muted">Platform pintar yang membantu Anda mengelola pola makan sehat dan hidup lebih
                aktif.</p>
        </div>
    </section>

    <!-- Feature Block 1 -->
    <section class="feature-block">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1605296867304-46d5465a13f1" class="feature-image"
                        alt="Healthy Food Choices">
                </div>
                <div class="col-md-6">
                    <h3 class="feature-heading">Rekomendasi Makanan Sehat</h3>
                    <p class="feature-description">
                        Kami menyediakan rekomendasi makanan berdasarkan status BMI Anda, dirancang oleh ahli gizi.
                        Rekomendasi ini dipersonalisasi dan membantu Anda memilih makanan yang sehat tanpa merasa
                        terbatas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Block 2 -->
    <section class="feature-block">
        <div class="container">
            <div class="row align-items-center g-5 flex-md-row-reverse">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092" class="feature-image"
                        alt="BMI Calculator Feature">
                </div>
                <div class="col-md-6">
                    <h3 class="feature-heading">Kalkulator BMI Cerdas</h3>
                    <p class="feature-description">
                        Hitung indeks massa tubuh Anda secara instan dan akurat. Fitur ini membantu Anda mengetahui
                        kategori tubuh
                        dan memberikan rekomendasi langkah selanjutnya untuk gaya hidup yang lebih sehat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'php/social_links_fetch.php'; ?>
    <?php include 'php/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>