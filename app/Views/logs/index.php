<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="layout-content">
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
    
    <main class="main-content">
        <h2>Technische Logs</h2>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Level</th>
                        <th>Message</th>
                        <th>Gebruiker</th>
                        <th>IP Adres</th>
                        <th>Datum</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Geen logs gevonden</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $log['id'] ?></td>
                            <td><span class="badge badge-<?= strtolower($log['level']) ?>"><?= $log['level'] ?></span></td>
                            <td><?= htmlspecialchars(substr($log['message'], 0, 100)) ?></td>
                            <td><?= $log['gebruikerNaam'] ?? 'Guest' ?></td>
                            <td><?= $log['ipAdres'] ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($log['datumAangemaakt'])) ?></td>
                            <td>
                                <a href="<?= APP_URL ?>/logs/view/<?= $log['id'] ?>" class="btn-sm">Details</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </main>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
