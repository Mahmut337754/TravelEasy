<?php
/**
 * Klant Controller
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/Klant.php';

class KlantController extends BaseController {
    
    private $klantModel;

    public function __construct() {
        $this->klantModel = new Klant();
    }

    public function index() {
        $this->requireAuth();
        
        $klanten = $this->klantModel->getAll();
        $this->view('klanten/index', ['klanten' => $klanten]);
    }
}
