<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEasy | Reisbureau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/home">
                <i class="bi bi-airplane-engines"></i>
                TravelEasy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/home">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/trips">
                            <i class="bi bi-suitcase"></i> Reizen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/accommodations">
                            <i class="bi bi-building"></i> Accommodaties
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/extras">
                            <i class="bi bi-plus-circle"></i> Extra's
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">
                            <i class="bi bi-envelope"></i> Contact
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a class="btn btn-login" href="/login">
                        <i class="bi bi-box-arrow-in-right"></i> Inloggen
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Ontdek de wereld met TravelEasy</h1>
                    <p class="lead mb-4">Jouw avontuur begint hier. Vind de beste reizen, accommodaties en meer.</p>
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">125+</span>
                            <span class="stat-label">Reizen</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">850+</span>
                            <span class="stat-label">Klanten</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1.2k+</span>
                            <span class="stat-label">Boekingen</span>
                        </div>
                    </div>
                    <div class="hero-buttons mt-4">
                        <a href="/trips" class="btn btn-primary btn-lg">
                            Bekijk reizen <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="/login" class="btn btn-outline-primary btn-lg ms-3">
                            <i class="bi bi-person"></i> Medewerker login
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-end">
                    <i class="bi bi-globe-americas hero-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-content">
        <div class="section-header">
            <h2 class="section-title">Populaire bestemmingen</h2>
            <p class="section-subtitle">Laat je inspireren voor je volgende reis</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="destination-card">
                    <div class="destination-image" style="background-image: url('https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=400&q=80');">
                        <div class="destination-overlay">
                            <span class="destination-price">vanaf €499</span>
                        </div>
                    </div>
                    <div class="destination-content">
                        <h3>Italië</h3>
                        <p>Rome, Venetië, Florence</p>
                        <div class="destination-meta">
                            <span><i class="bi bi-calendar"></i> 7 dagen</span>
                            <span><i class="bi bi-star-fill text-warning"></i> 4.8</span>
                        </div>
                        <a href="/trips/italie" class="btn-view">
                            Bekijk reis <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="destination-card">
                    <div class="destination-image" style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=400&q=80');">
                        <div class="destination-overlay">
                            <span class="destination-price">vanaf €699</span>
                        </div>
                    </div>
                    <div class="destination-content">
                        <h3>Thailand</h3>
                        <p>Bangkok, Phuket, Chiang Mai</p>
                        <div class="destination-meta">
                            <span><i class="bi bi-calendar"></i> 10 dagen</span>
                            <span><i class="bi bi-star-fill text-warning"></i> 4.9</span>
                        </div>
                        <a href="/trips/thailand" class="btn-view">
                            Bekijk reis <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="destination-card">
                    <div class="destination-image" style="background-image: url('https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=400&q=80');">
                        <div class="destination-overlay">
                            <span class="destination-price">vanaf €599</span>
                        </div>
                    </div>
                    <div class="destination-content">
                        <h3>Japan</h3>
                        <p>Tokio, Kyoto, Osaka</p>
                        <div class="destination-meta">
                            <span><i class="bi bi-calendar"></i> 8 dagen</span>
                            <span><i class="bi bi-star-fill text-warning"></i> 4.9</span>
                        </div>
                        <a href="/trips/japan" class="btn-view">
                            Bekijk reis <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="destination-card">
                    <div class="destination-image" style="background-image: url('https://images.unsplash.com/photo-1533105079780-92b9be482077?w=400&q=80');">
                        <div class="destination-overlay">
                            <span class="destination-price">vanaf €449</span>
                        </div>
                    </div>
                    <div class="destination-content">
                        <h3>Griekenland</h3>
                        <p>Santorini, Athene, Kreta</p>
                        <div class="destination-meta">
                            <span><i class="bi bi-calendar"></i> 6 dagen</span>
                            <span><i class="bi bi-star-fill text-warning"></i> 4.7</span>
                        </div>
                        <a href="/trips/griekenland" class="btn-view">
                            Bekijk reis <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="bi bi-calendar-week"></i>
                        <h4>Waarom TravelEasy?</h4>
                    </div>
                    <div class="feature-list">
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Beste prijsgarantie</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>24/7 klantenservice</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Flexibel annuleren</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Veilig betalen</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="bi bi-stars"></i>
                        <h4>Klantbeoordelingen</h4>
                    </div>
                    <div class="review-list">
                        <div class="review-item">
                            <div class="review-stars">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p>"Geweldige reis naar Thailand, alles perfect geregeld!"</p>
                            <span class="review-author">- Familie Jansen</span>
                        </div>
                        <div class="review-item">
                            <div class="review-stars">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p>"Prachtig hotel in Rome, zeer behulpzaam personeel."</p>
                            <span class="review-author">- Lisa de Vries</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="footer-brand">
                        <i class="bi bi-airplane-engines"></i>
                        TravelEasy
                    </span>
                    <span class="copyright">
                        &copy; <?php echo date('Y'); ?> Alle rechten voorbehouden
                    </span>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="made-with">
                        <i class="bi bi-heart-fill"></i>
                        Jouw reis, onze passie
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>