<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="layout-content">
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2>Klanten</h2>
            <a href="<?= APP_URL ?>/klanten/create" class="btn-primary">Nieuwe Klant</a>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Email</th>
                        <th>Telefoon</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($klanten)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Geen klanten gevonden</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($klanten as $klant): ?>
                        <tr>
                            <td><?= $klant['id'] ?></td>
                            <td><?= $klant['voornaam'] . ' ' . $klant['achternaam'] ?></td>
                            <td><?= $klant['email'] ?></td>
                            <td><?= $klant['telefoon'] ?></td>
                            <td>
                                <a href="<?= APP_URL ?>/klanten/view/<?= $klant['id'] ?>" class="btn-sm">Bekijken</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
