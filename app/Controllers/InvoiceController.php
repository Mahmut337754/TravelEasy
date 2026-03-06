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

