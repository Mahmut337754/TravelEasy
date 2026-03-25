<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Factuur - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/home">
                <i class="bi bi-airplane-engines"></i>
                TravelEasy
            </a>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="mb-4 d-flex gap-2">
            <a href="/facturen" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Terug naar overzicht
            </a>
        </div>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Fout!</strong> <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h1 class="h4 mb-0">
                    <i class="bi bi-file-earmark-plus text-primary"></i>
                    Nieuwe Factuur
                </h1>
            </div>
            <div class="card-body">
                <form method="POST" action="/facturen/create">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Boeking</label>
                            <select name="booking_id" class="form-select" id="booking_id" required>
                                <option value="">Selecteer een boeking</option>
                                <?php foreach ($bookingOptions as $option): ?>
                                    <option
                                        value="<?= (int)$option['booking_id'] ?>"
                                        data-customer-id="<?= (int)$option['customer_id'] ?>"
                                        <?= isset($_POST['booking_id']) && (int)$_POST['booking_id'] === (int)$option['booking_id'] ? 'selected' : '' ?>>
                                        #<?= (int)$option['booking_id'] ?> - <?= htmlspecialchars($option['customer_name']) ?> - <?= htmlspecialchars($option['trip_title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Klant ID</label>
                            <input type="number" name="customer_id" id="customer_id" class="form-control" min="1" value="<?= htmlspecialchars($_POST['customer_id'] ?? '') ?>" required>
                            <div class="form-text">Wordt automatisch gevuld op basis van boeking, maar kan handmatig aangepast worden.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Factuurnummer</label>
                            <input type="text" name="invoice_number" class="form-control" value="<?= htmlspecialchars($_POST['invoice_number'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Factuurdatum</label>
                            <input type="text" name="invoice_date" class="form-control" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" value="<?= htmlspecialchars($_POST['invoice_date'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vervaldatum</label>
                            <input type="text" name="due_date" class="form-control" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" value="<?= htmlspecialchars($_POST['due_date'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Totaalbedrag</label>
                            <input type="number" step="0.01" min="0" name="total_amount" id="total_amount" class="form-control" value="<?= htmlspecialchars($_POST['total_amount'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">BTW-bedrag (21%)</label>
                            <input type="number" step="0.01" min="0" name="tax_amount" id="tax_amount" class="form-control" value="<?= htmlspecialchars($_POST['tax_amount'] ?? '') ?>" readonly>
                            <div class="form-text">Wordt automatisch berekend als 21% van het totaalbedrag.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Valuta</label>
                            <input type="text" name="currency" class="form-control" maxlength="3" value="<?= htmlspecialchars($_POST['currency'] ?? 'EUR') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <?php
                            $statusLabels = [
                                'unpaid' => 'Onbetaald',
                                'paid' => 'Betaald',
                                'overdue' => 'Achterstallig',
                                'cancelled' => 'Geannuleerd'
                            ];
                            ?>
                            <select name="status" class="form-select" required>
                                <?php foreach ($statusOptions as $status): ?>
                                    <option value="<?= htmlspecialchars($status) ?>" <?= (($_POST['status'] ?? 'unpaid') === $status) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($statusLabels[$status] ?? $status) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Betalingsdatum (optioneel)</label>
                            <input type="text" name="payment_date" class="form-control" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" value="<?= htmlspecialchars($_POST['payment_date'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle"></i> Factuur aanmaken
                        </button>
                        <a href="/facturen" class="btn btn-outline-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var bookingSelect = document.getElementById('booking_id');
            var customerInput = document.getElementById('customer_id');
            var totalAmountInput = document.getElementById('total_amount');
            var taxAmountInput = document.getElementById('tax_amount');

            function syncCustomerFromBooking() {
                var selected = bookingSelect.options[bookingSelect.selectedIndex];
                var customerId = selected ? selected.getAttribute('data-customer-id') : '';
                if (customerId) {
                    customerInput.value = customerId;
                }
            }

            bookingSelect.addEventListener('change', syncCustomerFromBooking);
            if (!customerInput.value) {
                syncCustomerFromBooking();
            }

            function syncTaxAmount() {
                var total = parseFloat(totalAmountInput.value || '0');
                if (isNaN(total) || total < 0) {
                    total = 0;
                }

                var tax = (total * 0.21).toFixed(2);
                taxAmountInput.value = tax;
            }

            totalAmountInput.addEventListener('input', syncTaxAmount);
            syncTaxAmount();
        });
    </script>
</body>

</html>
