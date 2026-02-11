<?php
/**
 * Dashboard Controller
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/Boeking.php';

class DashboardController extends BaseController {
    
    private $boekingModel;

    public function __construct() {
        $this->boekingModel = new Boeking();
    }

    public function index() {
        $this->requireAuth();

        $data = [
            'totaalBoekingen' => $this->boekingModel->getTotaalBoekingen(),
            'totaalOmzet' => $this->boekingModel->getTotaalOmzet(),
            'actieveKlanten' => $this->boekingModel->getActieveKlanten(),
        ];

        $this->view('dashboard/index', $data);
    }
}
