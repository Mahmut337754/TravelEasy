<aside class="sidebar">
    <nav class="sidebar-nav">
        <a href="<?= APP_URL ?>/dashboard" class="nav-item">Dashboard</a>
        <a href="<?= APP_URL ?>/boekingen" class="nav-item">Boekingen</a>
        <a href="<?= APP_URL ?>/klanten" class="nav-item">Klanten</a>
        <a href="<?= APP_URL ?>/bestemmingen" class="nav-item">Bestemmingen</a>
        
        <?php if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'manager'): ?>
        <a href="<?= APP_URL ?>/rapportages" class="nav-item">Rapportages</a>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'administrator'): ?>
        <a href="<?= APP_URL ?>/gebruikers" class="nav-item">Gebruikers</a>
        <a href="<?= APP_URL ?>/logs" class="nav-item">Technische Logs</a>
        <?php endif; ?>
    </nav>
</aside>
