<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">TravelEasy</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Welkom, <?= $_SESSION['user_name'] ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users">Gebruikers beheren</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Uitloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Dashboard</h1>
        <p>Welkom op het dashboard, <?= $_SESSION['user_name'] ?>.</p>
        <a href="/users" class="btn btn-primary">Ga naar gebruikersbeheer</a>
    </div>
</body>

</html>