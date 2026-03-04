<?php
require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    private $userModel;
    private $pdo;

    public function __construct($pdo)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

    public function loginForm()
    {
        require dirname(__DIR__, 2) . '/Views/auth/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];

            $stmt = $this->pdo->prepare("SELECT name FROM roles WHERE id = ?");
            $stmt->execute([$user['role_id']]);
            $role = $stmt->fetchColumn();
            $_SESSION['user_role'] = $role;

            if ($role === 'Administrator') {
                header('Location: /dashboard');
            } else {
                header('Location: /');
            }
            exit;
        } else {
            $_SESSION['login_error'] = 'Ongeldige e-mail of wachtwoord.';
            header('Location: /login');
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit;
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Administrator') {
            header('Location: /');
            exit;
        }
        require dirname(__DIR__, 2) . '/Views/dashboard/index.php';
    }
}
