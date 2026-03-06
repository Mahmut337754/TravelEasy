<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur Details - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .invoice-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        .invoice-section-title {
            font-size: 14px;
            color: #999;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .invoice-section {
            margin-bottom: 25px;
        }
        .invoice-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .invoice-row:last-child {
            border-bottom: none;
        }
        .invoice-row-label {
            color: #666;
            font-weight: 500;
        }
        .invoice-row-value {
            font-weight: 600;
            color: #333;
        }
        .invoice-total {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        .invoice-total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 16px;
        }
        .invoice-total-row.total {
            border-top: 2px solid #ddd;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>

<body>
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
                        <a class="nav-link" href="/facturen">
                            <i class="bi bi-receipt"></i> Facturen
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
        <div class="mb-4">
            <a href="/facturen" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Terug naar overzicht
            </a>
        </div>

        <div class="invoice-container">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div>
                    <h1 class="h3 mb-1"><?= htmlspecialchars($invoice['invoice_number']) ?></h1>
                    <p class="text-muted mb-0">Factuurdatum: <?= date('d-m-Y', strtotime($invoice['invoice_date'])) ?></p>
                </div>
                <div class="text-end">
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
                    <span class="status-badge bg-<?= $class ?>">
                        <?= $text ?>
                    </span>
                </div>
            </div>

            <!-- Invoice Details Grid -->
            <div class="invoice-details">
                <!-- Left Column -->
                <div>
                    <div class="invoice-section">
                        <div class="invoice-section-title">Klantgegevens</div>
                        <p class="mb-1"><strong><?= htmlspecialchars($invoice['customer_name']) ?></strong></p>
                        <p class="text-muted mb-1"><?= htmlspecialchars($invoice['customer_email']) ?></p>
                        <p class="text-muted"><?= htmlspecialchars($invoice['customer_address']) ?></p>
                    </div>

                    <div class="invoice-section">
                        <div class="invoice-section-title">Reisgegevens</div>
                        <p class="mb-1"><strong><?= htmlspecialchars($invoice['trip_title']) ?></strong></p>
                        <p class="text-muted"><?= htmlspecialchars($invoice['trip_description']) ?></p>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="invoice-section">
                        <div class="invoice-section-title">Factuurdatums</div>
                        <div class="invoice-row">
                            <span class="invoice-row-label">Factuurdatum:</span>
                            <span class="invoice-row-value"><?= date('d-m-Y', strtotime($invoice['invoice_date'])) ?></span>
                        </div>
                        <div class="invoice-row">
                            <span class="invoice-row-label">Vervaldatum:</span>
                            <span class="invoice-row-value"><?= date('d-m-Y', strtotime($invoice['due_date'])) ?></span>
                        </div>
                        <?php if ($invoice['payment_date']): ?>
                            <div class="invoice-row">
                                <span class="invoice-row-label">Betalingsdatum:</span>
                                <span class="invoice-row-value"><?= date('d-m-Y', strtotime($invoice['payment_date'])) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="invoice-section">
                        <div class="invoice-section-title">Référence</div>
                        <div class="invoice-row">
                            <span class="invoice-row-label">Factuurnummer:</span>
                            <span class="invoice-row-value"><?= htmlspecialchars($invoice['invoice_number']) ?></span>
                        </div>
                        <div class="invoice-row">
                            <span class="invoice-row-label">Valuta:</span>
                            <span class="invoice-row-value"><?= htmlspecialchars($invoice['currency']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Total Section -->
            <div class="invoice-total">
                <div class="invoice-total-row">
                    <span>Subtotaal:</span>
                    <span><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['total_amount'] - $invoice['tax_amount'], 2, ',', '.') ?></span>
                </div>
                <div class="invoice-total-row">
                    <span>BTW (21%):</span>
                    <span><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['tax_amount'], 2, ',', '.') ?></span>
                </div>
                <div class="invoice-total-row total">
                    <span>Totaal:</span>
                    <span><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['total_amount'], 2, ',', '.') ?></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-5 pt-4 border-top">
                <a href="/facturen" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Terug naar overzicht
                </a>
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="bi bi-printer"></i> Afdrukken
                </button>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 TravelEasy. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
