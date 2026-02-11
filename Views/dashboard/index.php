<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="layout-content">
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
    
    <main class="main-content">
        <h2>Dashboard</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Totaal Boekingen</h3>
                <p class="stat-value"><?= $totaalBoekingen ?></p>
            </div>
            
            <div class="dashboard-card">
                <h3>Totale Omzet</h3>
                <p class="stat-value">€<?= number_format($totaalOmzet, 2, ',', '.') ?></p>
            </div>
            
            <div class="dashboard-card">
                <h3>Actieve Klanten</h3>
                <p class="stat-value"><?= $actieveKlanten ?></p>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
