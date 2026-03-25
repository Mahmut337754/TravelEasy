<?php
require_once PROJECT_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Invoice.php';

class InvoiceController {
    private $pdo;
    private $invoiceModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->invoiceModel = new Invoice($pdo);
    }

    /**
     * Display all invoices overview
     */
    public function index() {
        try {
            // Check if user is logged in
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            // Get all invoices
            $invoices = $this->invoiceModel->getAll();
            $invoiceCount = $this->invoiceModel->countAll();

            // Load the view
            require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'index.php';
        } catch (Exception $e) {
            error_log("InvoiceController::index error: " . $e->getMessage());
            $invoices = [];
            $invoiceCount = 0;
            $errorMessage = "Er is een fout opgetreden bij het laden van de facturen: " . htmlspecialchars($e->getMessage());
            require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'index.php';
        }
    }

    /**
     * Show create form for invoice
     */
    public function create() {
        try {
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            $statusOptions = ['unpaid', 'paid', 'overdue', 'cancelled'];
            $bookingOptions = $this->invoiceModel->getCreateOptions();

            require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'create.php';
        } catch (Exception $e) {
            error_log("InvoiceController::create error: " . $e->getMessage());
            $_SESSION['error_message'] = "Fout bij het laden van nieuw factuurformulier: " . htmlspecialchars($e->getMessage());
            header('Location: /facturen');
            exit;
        }
    }

    /**
     * Store newly created invoice
     */
    public function store() {
        try {
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            $statusOptions = ['unpaid', 'paid', 'overdue', 'cancelled'];

            $data = [
                'booking_id' => (int)($_POST['booking_id'] ?? 0),
                'customer_id' => (int)($_POST['customer_id'] ?? 0),
                'invoice_number' => trim($_POST['invoice_number'] ?? ''),
                'invoice_date' => trim($_POST['invoice_date'] ?? ''),
                'due_date' => trim($_POST['due_date'] ?? ''),
                'total_amount' => (float)($_POST['total_amount'] ?? 0),
                'status' => trim($_POST['status'] ?? ''),
                'payment_date' => trim($_POST['payment_date'] ?? ''),
                'currency' => strtoupper(trim($_POST['currency'] ?? 'EUR')),
            ];

            if (
                $data['booking_id'] <= 0 ||
                $data['customer_id'] <= 0 ||
                $data['invoice_number'] === '' ||
                $data['invoice_date'] === '' ||
                $data['due_date'] === ''
            ) {
                throw new Exception("Boeking, klant, factuurnummer, factuurdatum en vervaldatum zijn verplicht");
            }

            if (!in_array($data['status'], $statusOptions, true)) {
                throw new Exception("Ongeldige factuurstatus");
            }

            if ($data['total_amount'] < 0) {
                throw new Exception("Totaalbedrag mag niet negatief zijn");
            }

            // Tax is always 21% of total amount.
            $data['tax_amount'] = round($data['total_amount'] * 0.21, 2);

            $data['tax_amount'] = $this->calculateTaxAmount($data['total_amount']);

            $data['invoice_date'] = $this->parseEuropeanDate($data['invoice_date'], 'Factuurdatum');
            $data['due_date'] = $this->parseEuropeanDate($data['due_date'], 'Vervaldatum');

            if ($data['payment_date'] === '') {
                $data['payment_date'] = null;
            } else {
                $data['payment_date'] = $this->parseEuropeanDate($data['payment_date'], 'Betalingsdatum');
            }

            $newInvoiceId = $this->invoiceModel->create($data);

            $_SESSION['success_message'] = "Factuur succesvol aangemaakt";
            header('Location: /facturen/' . (int)$newInvoiceId);
            exit;
        } catch (Exception $e) {
            error_log("InvoiceController::store error: " . $e->getMessage());
            $_SESSION['error_message'] = "Fout bij het aanmaken van factuur: " . htmlspecialchars($e->getMessage());
            header('Location: /facturen/create');
            exit;
        }
    }

    /**
     * Display single invoice details
     * @param int $id Invoice ID
     */
    public function show($id) {
        try {
            // Check if user is logged in
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            // Validate ID
            if (!is_numeric($id)) {
                throw new Exception("Ongeldig factuurnummer");
            }

            // Get invoice by ID
            $invoice = $this->invoiceModel->getById($id);

            if (!$invoice) {
                header('Location: /facturen');
                exit;
            }

            // Load the view
            require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'show.php';
        } catch (Exception $e) {
            error_log("InvoiceController::show error: " . $e->getMessage());
            header('Location: /facturen');
            exit;
        }
    }

    /**
     * Show edit form for invoice
     * @param int $id Invoice ID
     */
    public function edit($id) {
        try {
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            if (!is_numeric($id)) {
                throw new Exception("Ongeldig factuurnummer");
            }

            $invoice = $this->invoiceModel->getById($id);
            if (!$invoice) {
                $_SESSION['error_message'] = "Factuur niet gevonden";
                header('Location: /facturen');
                exit;
            }

            $statusOptions = ['unpaid', 'paid', 'overdue', 'cancelled'];
            require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'edit.php';
        } catch (Exception $e) {
            error_log("InvoiceController::edit error: " . $e->getMessage());
            $_SESSION['error_message'] = "Fout bij het laden van het bewerken: " . htmlspecialchars($e->getMessage());
            header('Location: /facturen');
            exit;
        }
    }

    /**
     * Update invoice details
     * @param int $id Invoice ID
     */
    public function update($id) {
        try {
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            if (!is_numeric($id)) {
                throw new Exception("Ongeldig factuurnummer");
            }

            $statusOptions = ['unpaid', 'paid', 'overdue', 'cancelled'];

            $data = [
                'invoice_number' => trim($_POST['invoice_number'] ?? ''),
                'invoice_date' => trim($_POST['invoice_date'] ?? ''),
                'due_date' => trim($_POST['due_date'] ?? ''),
                'total_amount' => (float)($_POST['total_amount'] ?? 0),
                'status' => trim($_POST['status'] ?? ''),
                'payment_date' => trim($_POST['payment_date'] ?? ''),
                'currency' => strtoupper(trim($_POST['currency'] ?? 'EUR')),
            ];

            if ($data['invoice_number'] === '' || $data['invoice_date'] === '' || $data['due_date'] === '') {
                throw new Exception("Factuurnummer, factuurdatum en vervaldatum zijn verplicht");
            }

            $data['invoice_date'] = $this->parseEuropeanDate($data['invoice_date'], 'Factuurdatum');
            $data['due_date'] = $this->parseEuropeanDate($data['due_date'], 'Vervaldatum');

            if (!in_array($data['status'], $statusOptions, true)) {
                throw new Exception("Ongeldige factuurstatus");
            }

            if ($data['total_amount'] < 0) {
                throw new Exception("Totaalbedrag mag niet negatief zijn");
            }

                // Tax is always 21% of total amount.
                $data['tax_amount'] = round($data['total_amount'] * 0.21, 2);

            $data['tax_amount'] = $this->calculateTaxAmount($data['total_amount']);

            if ($data['payment_date'] === '') {
                $data['payment_date'] = null;
            } else {
                $data['payment_date'] = $this->parseEuropeanDate($data['payment_date'], 'Betalingsdatum');
            }

            $this->invoiceModel->update($id, $data);

            $_SESSION['success_message'] = "Factuur succesvol bijgewerkt";
            header('Location: /facturen/' . (int)$id);
            exit;
        } catch (Exception $e) {
            error_log("InvoiceController::update error: " . $e->getMessage());
            $_SESSION['error_message'] = "Fout bij het bijwerken van factuur: " . htmlspecialchars($e->getMessage());
            header('Location: /facturen/edit/' . (int)$id);
            exit;
        }
    }

    /**
     * Parse date from dd/mm/yyyy to yyyy-mm-dd
     * @param string $value Date value from form
     * @param string $fieldName Friendly field label
     * @return string Date in MySQL format
     */
    private function parseEuropeanDate($value, $fieldName) {
        $date = DateTime::createFromFormat('d/m/Y', $value);
        $errors = DateTime::getLastErrors();

        if (!$date || $errors['warning_count'] > 0 || $errors['error_count'] > 0) {
            throw new Exception($fieldName . " moet in formaat dd/mm/jjjj zijn");
        }

        return $date->format('Y-m-d');
    }

    /**
     * Calculate VAT amount based on fixed 21% rate
     * @param float $totalAmount
     * @return float
     */
    private function calculateTaxAmount($totalAmount) {
        return round(((float)$totalAmount) * 0.21, 2);
    }

    /**
     * Download a single invoice as HTML file
     * @param int $id Invoice ID
     */
    public function download($id) {
        try {
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            if (!is_numeric($id)) {
                throw new Exception("Ongeldig factuurnummer");
            }

            $invoice = $this->invoiceModel->getById($id);
            if (!$invoice) {
                throw new Exception("Factuur niet gevonden");
            }

            $safeInvoiceNumber = preg_replace('/[^A-Za-z0-9\-_]/', '_', (string)$invoice['invoice_number']);
            if ($safeInvoiceNumber === '') {
                $safeInvoiceNumber = 'invoice_' . (int)$id;
            }

            ob_start();
            require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'download.php';
            $content = ob_get_clean();

            header('Content-Type: text/html; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $safeInvoiceNumber . '.html"');
            header('Content-Length: ' . strlen($content));
            echo $content;
            exit;
        } catch (Exception $e) {
            error_log("InvoiceController::download error: " . $e->getMessage());
            $_SESSION['error_message'] = "Fout bij het downloaden van factuur: " . htmlspecialchars($e->getMessage());
            header('Location: /facturen/' . (int)$id);
            exit;
        }
    }

    /**
     * Delete invoice
     * @param int $id Invoice ID
     */
    public function destroy($id) {
        try {
            // Check if user is logged in
            if (!isset($_SESSION['user_email'])) {
                header('Location: /login');
                exit;
            }

            // Validate ID
            if (!is_numeric($id)) {
                throw new Exception("Ongeldig factuurnummer");
            }

            // Delete the invoice
            $this->invoiceModel->delete($id);

            // Set success message
            $_SESSION['success_message'] = "Factuur succesvol verwijderd";

            // Redirect to list
            header('Location: /facturen');
            exit;
        } catch (Exception $e) {
            error_log("InvoiceController::destroy error: " . $e->getMessage());
            
            // Set error message
            $_SESSION['error_message'] = "Fout bij het verwijderen van factuur: " . htmlspecialchars($e->getMessage());
            
            // Redirect to list
            header('Location: /facturen');
            exit;
        }
    }
}

