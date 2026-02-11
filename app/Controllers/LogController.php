<?php
/**
 * Log Controller
 * Voor het bekijken van technische logs (alleen voor administrators)
 */

require_once __DIR__ . '/BaseController.php';

class LogController extends BaseController {
    
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index() {
        $this->requireAuth();
        
        // Alleen administrators mogen logs bekijken
        if (!$this->hasRole('administrator')) {
            $_SESSION['error'] = 'Geen toegang tot deze pagina';
            $this->redirect('/dashboard');
        }

        // Haal logs op met paginering
        $page = $_GET['page'] ?? 1;
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("
            SELECT l.*, g.naam as gebruikerNaam
            FROM technische_logs l
            LEFT JOIN gebruikers g ON l.gebruikerId = g.id
            ORDER BY l.datumAangemaakt DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$perPage, $offset]);
        $logs = $stmt->fetchAll();

        // Totaal aantal logs
        $totalStmt = $this->db->query("SELECT COUNT(*) as total FROM technische_logs");
        $total = $totalStmt->fetch()['total'];

        $this->view('logs/index', [
            'logs' => $logs,
            'currentPage' => $page,
            'totalPages' => ceil($total / $perPage)
        ]);
    }

    public function view($id) {
        $this->requireAuth();
        
        if (!$this->hasRole('administrator')) {
            $_SESSION['error'] = 'Geen toegang tot deze pagina';
            $this->redirect('/dashboard');
        }

        $stmt = $this->db->prepare("
            SELECT l.*, g.naam as gebruikerNaam, g.email as gebruikerEmail
            FROM technische_logs l
            LEFT JOIN gebruikers g ON l.gebruikerId = g.id
            WHERE l.id = ?
        ");
        $stmt->execute([$id]);
        $log = $stmt->fetch();

        if (!$log) {
            $_SESSION['error'] = 'Log niet gevonden';
            $this->redirect('/logs');
        }

        $this->view('logs/view', ['log' => $log]);
    }
}
