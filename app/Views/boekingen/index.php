<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="layout-content">
    <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2>Boekingen</h2>
            <a href="<?= APP_URL ?>/boekingen/create" class="btn-primary">Nieuwe Boeking</a>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Klant</th>
                        <th>Bestemming</th>
                        <th>Start Datum</th>
                        <th>Eind Datum</th>
                        <th>Totaal Prijs</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($boekingen)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Geen boekingen gevonden</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($boekingen as $boeking): ?>
                        <tr>
                            <td><?= $boeking['id'] ?></td>
                            <td><?= $boeking['klantId'] ?></td>
                            <td><?= $boeking['bestemmingId'] ?></td>
                            <td><?= date('d-m-Y', strtotime($boeking['startDatum'])) ?></td>
                            <td><?= date('d-m-Y', strtotime($boeking['eindDatum'])) ?></td>
                            <td>€<?= number_format($boeking['totaalPrijs'], 2, ',', '.') ?></td>
                            <td><span class="badge badge-<?= $boeking['status'] ?>"><?= ucfirst($boeking['status']) ?></span></td>
                            <td>
                                <a href="<?= APP_URL ?>/boekingen/view/<?= $boeking['id'] ?>" class="btn-sm">Bekijken</a>
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
