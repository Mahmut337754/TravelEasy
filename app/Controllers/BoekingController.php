<?php
/**
 * Boeking Controller
 * CRUD operations voor boekingen
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/Boeking.php';
require_once __DIR__ . '/../Core/Logger.php';

class BoekingController extends BaseController {
    
    private $boekingModel;
    private $logger;

    public function __construct() {
        $this->boekingModel = new Boeking();
        $this->logger = Logger::getInstance();
    }

    public function index() {
        $this->requireAuth();
        
        $boekingen = $this->boekingModel->getAll();
        $this->view('boekingen/index', ['boekingen' => $boekingen]);
    }

    public function create() {
        $this->requireAuth();
        $this->view('boekingen/create');
    }

    public function store() {
        $this->requireAuth();

        try {
            $data = [
                'klantId' => $_POST['klantId'],
                'bestemmingId' => $_POST['bestemmingId'],
                'startDatum' => $_POST['startDatum'],
                'eindDatum' => $_POST['eindDatum'],
                'aantalVolwassenen' => $_POST['aantalVolwassenen'],
                'aantalKinderen' => $_POST['aantalKinderen'] ?? 0,
                'aantalBabys' => $_POST['aantalBabys'] ?? 0,
            ];

            $boekingId = $this->boekingModel->create($data);
            
            $this->logger->logAction('CREATE', 'Boeking', $boekingId, [
                'klantId' => $data['klantId'],
                'bestemmingId' => $data['bestemmingId'],
                'startDatum' => $data['startDatum'],
                'eindDatum' => $data['eindDatum']
            ]);
            
            $_SESSION['success'] = 'Boeking succesvol aangemaakt';
            $this->redirect('/boekingen');

        } catch (Exception $e) {
            $this->logger->error('Fout bij aanmaken boeking', [
                'error' => $e->getMessage(),
                'data' => $data ?? []
            ]);
            
            $_SESSION['error'] = $e->getMessage();
            $this->redirect('/boekingen/create');
        }
    }
}
