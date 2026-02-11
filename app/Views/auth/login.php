<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="login-container">
    <div class="login-card">
        <h1>TravelEasy</h1>
        <p class="login-subtitle">Inloggen op uw account</p>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= APP_URL ?>/login" class="login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-primary">Inloggen</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
