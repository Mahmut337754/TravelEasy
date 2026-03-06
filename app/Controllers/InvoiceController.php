<?php
require_once PROJECT_ROOT . 'app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Invoice.php';

class InvoiceController {
    private $pdo;
    private $invoiceModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->invoiceModel = new Invoice($pdo);
    }

    public function index() {
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
    }

    public function show($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_email'])) {
            header('Location: /login');
            exit;
        }

        // Get invoice by ID
        $invoice = $this->invoiceModel->getById($id);

        if (!$invoice) {
            header('Location: /invoices');
            exit;
        }

        // Load the view
        require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . 'show.php';
    }
}
