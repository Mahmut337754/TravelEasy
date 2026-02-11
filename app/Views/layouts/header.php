<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TravelEasy' ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <header class="header">
        <div class="header-content">
            <h1 class="logo">TravelEasy</h1>
            <nav class="header-nav">
                <span>Welkom, <?= $_SESSION['user_naam'] ?></span>
                <a href="<?= APP_URL ?>/logout" class="btn-logout">Uitloggen</a>
            </nav>
        </div>
    </header>
    <?php endif; ?>
