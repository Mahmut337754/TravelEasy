<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturen - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php
    // Include Invoice model for helper methods
    require_once PROJECT_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Invoice.php';
    ?>
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
                        <a class="nav-link" href="/home">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/trips">
                            <i class="bi bi-suitcase"></i> Reizen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bookings">
                            <i class="bi bi-calendar-check"></i> Boekingen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/facturen">
                            <i class="bi bi-receipt"></i> Facturen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/customers">
                            <i class="bi bi-people"></i> Klanten
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_email'])): ?>
                        <span class="navbar-text me-3 text-light">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['user_email'] ?? 'Gebruiker') ?>
                        </span>
                        <a class="btn btn-outline-light btn-sm" href="/logout">
                            <i class="bi bi-box-arrow-right"></i> Uitloggen
                        </a>
                    <?php else: ?>
                        <a class="btn btn-outline-light btn-sm" href="/login">
                            <i class="bi bi-box-arrow-in-right"></i> Inloggen
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="bi bi-receipt text-primary"></i> Overzicht Facturen
                        </h1>
                        <p class="text-muted">Bekijk alle facturen van klanten</p>
                    </div>
                    <div>
                        <span class="badge bg-primary fs-6">
                            Totaal: <?= $invoiceCount ?> facturen
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Succes!</strong> <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Fout!</strong> <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Fout!</strong> <?= $errorMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($invoices)): ?>
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                <div>
                    <h4 class="alert-heading mb-1">Geen facturen beschikbaar</h4>
                    <p class="mb-0">Er zijn geen facturen beschikbaar om weer te geven.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Factuurnummer</th>
                                    <th>Klant</th>
                                    <th>Reis</th>
                                    <th>Factuurdatum</th>
                                    <th>Vervaldatum</th>
                                    <th>Bedrag</th>
                                    <th>Status</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoices as $invoice): ?>
                                    <tr>
                                        <td>
                                            <strong class="text-primary"><?= htmlspecialchars($invoice['invoice_number']) ?></strong>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($invoice['customer_name']) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= htmlspecialchars($invoice['customer_email']) ?></small>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($invoice['trip_title']) ?></td>
                                        <td><?= date('d-m-Y', strtotime($invoice['invoice_date'])) ?></td>
                                        <td>
                                            <?php
                                            $dueDate = strtotime($invoice['due_date']);
                                            $today = time();
                                            $isOverdue = $dueDate < $today && $invoice['status'] !== 'paid';
                                            ?>
                                            <span class="<?= $isOverdue ? 'text-danger fw-bold' : '' ?>">
                                                <?= date('d-m-Y', $dueDate) ?>
                                                <?php if ($isOverdue): ?>
                                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['total_amount'], 2, ',', '.') ?></strong>
                                            <br>
                                            <small class="text-muted">BTW: <?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['tax_amount'], 2, ',', '.') ?></small>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = [
                                                'paid' => 'success',
                                                'unpaid' => 'warning',
                                                'overdue' => 'danger',
                                                'cancelled' => 'secondary'
                                            ];
                                            $statusText = [
                                                'paid' => 'Betaald',
                                                'unpaid' => 'Onbetaald',
                                                'overdue' => 'Achterstallig',
                                                'cancelled' => 'Geannuleerd'
                                            ];
                                            $class = $statusClass[$invoice['status']] ?? 'secondary';
                                            $text = $statusText[$invoice['status']] ?? $invoice['status'];
                                            ?>
                                            <span class="badge bg-<?= $class ?>">
                                                <?= $text ?>
                                            </span>
                                            <?php if ($invoice['payment_date']): ?>
                                                <br>
                                                <small class="text-muted">Betaald: <?= date('d-m-Y', strtotime($invoice['payment_date'])) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="/facturen/<?= $invoice['id'] ?>" class="btn btn-sm btn-outline-primary" title="Bekijk details">
                                                <i class="bi bi-eye"></i> Bekijken
                                            </a>
                                            <a href="/facturen/delete/<?= $invoice['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Verwijder factuur"
                                               onclick="return confirm('Weet u zeker dat u deze factuur wilt verwijderen?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
                <?php
                try {
                    $invoiceModel = new Invoice($pdo);
                    $summary = $invoiceModel->getSummary();
                    $totalPaid = $summary['paid'];
                    $totalUnpaid = $summary['unpaid'];
                    $totalOverdue = $summary['overdue'];
                    $totalAmount = $summary['total'];
                } catch (Exception $e) {
                    error_log("Error getting summary: " . $e->getMessage());
                    $totalPaid = 0;
                    $totalUnpaid = 0;
                    $totalOverdue = 0;
                    $totalAmount = 0;
                }
                ?>
                <div class="col-md-3">
                    <div class="card text-center border-primary">
                        <div class="card-body">
                            <i class="bi bi-currency-euro text-primary fs-1"></i>
                            <h5 class="card-title mt-2">Totaal Bedrag</h5>
                            <p class="card-text fs-4 fw-bold">€ <?= number_format($totalAmount, 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <i class="bi bi-check-circle text-success fs-1"></i>
                            <h5 class="card-title mt-2">Betaald</h5>
                            <p class="card-text fs-4 fw-bold text-success">€ <?= number_format($totalPaid, 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-warning">
                        <div class="card-body">
                            <i class="bi bi-hourglass-split text-warning fs-1"></i>
                            <h5 class="card-title mt-2">Onbetaald</h5>
                            <p class="card-text fs-4 fw-bold text-warning">€ <?= number_format($totalUnpaid, 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-danger">
                        <div class="card-body">
                            <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
                            <h5 class="card-title mt-2">Achterstallig</h5>
                            <p class="card-text fs-4 fw-bold text-danger">€ <?= number_format($totalOverdue, 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 TravelEasy. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple and reliable alert dismiss
        window.addEventListener('DOMContentLoaded', function() {
            // Get all alerts
            var alerts = document.querySelectorAll('.alert');
            
            alerts.forEach(function(alert) {
                // Handle close button click
                var closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.onclick = function() {
                        alert.style.transition = 'opacity 0.15s linear';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.remove();
                        }, 150);
                    };
                }
                
                // Auto-dismiss success alerts after 5 seconds
                if (alert.classList.contains('alert-success')) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 0.15s linear';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.remove();
                        }, 150);
                    }, 5000);
                }
            });
        });
    </script>
</body>

</html>
