<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Factuur <?= htmlspecialchars($invoice['invoice_number']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #1f2937;
        }

        h1,
        h2,
        p {
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #f3f4f6;
            padding: 8px 0;
        }

        .total {
            margin-top: 10px;
            border-top: 2px solid #d1d5db;
            padding-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1>TravelEasy</h1>
            <p>Factuur</p>
        </div>
        <div style="text-align: right;">
            <h2><?= htmlspecialchars($invoice['invoice_number']) ?></h2>
            <p>Factuurdatum: <?= date('d-m-Y', strtotime($invoice['invoice_date'])) ?></p>
            <p>Vervaldatum: <?= date('d-m-Y', strtotime($invoice['due_date'])) ?></p>
        </div>
    </div>

    <div class="section">
        <div class="label">Klant</div>
        <p><strong><?= htmlspecialchars($invoice['customer_name']) ?></strong></p>
        <p><?= htmlspecialchars($invoice['customer_email']) ?></p>
        <p><?= htmlspecialchars($invoice['customer_address']) ?></p>
    </div>

    <div class="section">
        <div class="label">Reis</div>
        <p><strong><?= htmlspecialchars($invoice['trip_title']) ?></strong></p>
        <p><?= htmlspecialchars($invoice['trip_description']) ?></p>
    </div>

    <div class="section">
        <div class="label">Bedragen</div>
        <div class="row">
            <span>Subtotaal</span>
            <span><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['total_amount'] - $invoice['tax_amount'], 2, ',', '.') ?></span>
        </div>
        <div class="row">
            <span>BTW</span>
            <span><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['tax_amount'], 2, ',', '.') ?></span>
        </div>
        <div class="row total">
            <span>Totaal</span>
            <span><?= htmlspecialchars($invoice['currency']) ?> <?= number_format($invoice['total_amount'], 2, ',', '.') ?></span>
        </div>
    </div>

    <div class="section">
        <div class="label">Status</div>
        <p><?= htmlspecialchars($invoice['status']) ?></p>
        <?php if (!empty($invoice['payment_date'])): ?>
            <p>Betalingsdatum: <?= date('d-m-Y', strtotime($invoice['payment_date'])) ?></p>
        <?php endif; ?>
    </div>
</body>

</html>
