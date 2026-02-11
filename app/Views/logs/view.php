<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="layout-content">
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2>Log Details</h2>
            <a href="<?= APP_URL ?>/logs" class="btn-secondary">Terug naar overzicht</a>
        </div>

        <div class="log-detail">
            <div class="log-detail-row">
                <div class="log-detail-label">ID</div>
                <div class="log-detail-value"><?= $log['id'] ?></div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">Level</div>
                <div class="log-detail-value">
                    <span class="badge badge-<?= strtolower($log['level']) ?>"><?= $log['level'] ?></span>
                </div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">Message</div>
                <div class="log-detail-value"><?= htmlspecialchars($log['message']) ?></div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">Gebruiker</div>
                <div class="log-detail-value">
                    <?php if ($log['gebruikerNaam']): ?>
                        <?= $log['gebruikerNaam'] ?> (<?= $log['gebruikerEmail'] ?>)
                    <?php else: ?>
                        Guest
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">IP Adres</div>
                <div class="log-detail-value"><?= $log['ipAdres'] ?></div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">User Agent</div>
                <div class="log-detail-value"><?= htmlspecialchars($log['userAgent']) ?></div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">URL</div>
                <div class="log-detail-value"><?= htmlspecialchars($log['url']) ?></div>
            </div>
            
            <div class="log-detail-row">
                <div class="log-detail-label">Datum</div>
                <div class="log-detail-value"><?= date('d-m-Y H:i:s', strtotime($log['datumAangemaakt'])) ?></div>
            </div>
            
            <?php if ($log['context']): ?>
            <div class="log-detail-row">
                <div class="log-detail-label">Context</div>
                <div class="log-detail-value">
                    <div class="log-context">
                        <?= json_encode(json_decode($log['context']), JSON_PRETTY_PRINT) ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
