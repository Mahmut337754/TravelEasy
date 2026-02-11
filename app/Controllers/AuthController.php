<?php
/**
 * Auth Controller
 * Handles: login, logout
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Logger.php';

class AuthController extends BaseController {
    
    private $userModel;
    private $logger;

    public function __construct() {
        $this->userModel = new User();
        $this->logger = Logger::getInstance();
    }

    public function showLogin() {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }

    public function login() {
        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->logger->warning('Login poging zonder credentials', ['email' => $email]);
                throw new Exception('Email en wachtwoord zijn verplicht');
            }

            $user = $this->userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['wachtwoord'])) {
                $this->logger->warning('Mislukte login poging', ['email' => $email]);
                throw new Exception('Ongeldige inloggegevens');
            }

            if (!$user['isActief']) {
                $this->logger->warning('Login poging met gedeactiveerd account', ['email' => $email]);
                throw new Exception('Account is gedeactiveerd');
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_naam'] = $user['naam'];
            $_SESSION['user_rol'] = $user['rol'];

            $this->logger->info('Gebruiker succesvol ingelogd', [
                'userId' => $user['id'],
                'email' => $email,
                'rol' => $user['rol']
            ]);

            $this->redirect('/dashboard');

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $this->redirect('/login');
        }
    }

    public function logout() {
        $this->logger->info('Gebruiker uitgelogd', [
            'userId' => $_SESSION['user_id'] ?? null,
            'naam' => $_SESSION['user_naam'] ?? null
        ]);
        
        session_destroy();
        $this->redirect('/login');
    }
}
