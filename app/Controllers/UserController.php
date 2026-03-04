<?php
require_once __DIR__ . '/../Models/User.php';

class UserController
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

    private function checkAdmin()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Administrator') {
            header('Location: /');
            exit;
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $users = $this->userModel->getAll();
        require dirname(__DIR__, 2) . '/Views/users/index.php';
    }

    public function create()
    {
        $this->checkAdmin();
        $stmt = $this->pdo->query("SELECT id, name FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require dirname(__DIR__, 2) . '/Views/users/create.php';
    }

    public function store()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role_id = $_POST['role_id'] ?? '';

        $errors = [];
        if (empty($name)) $errors[] = 'Naam is verplicht.';
        if (empty($email)) $errors[] = 'E-mail is verplicht.';
        if (empty($password)) $errors[] = 'Wachtwoord is verplicht.';
        if (empty($role_id)) $errors[] = 'Rol is verplicht.';

        if (empty($errors)) {
            $existing = $this->userModel->findByEmail($email);
            if ($existing) {
                $errors[] = 'E-mailadres is al in gebruik.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['user_errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /users/create');
            exit;
        }

        $this->userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id
        ]);

        $_SESSION['user_success'] = 'Gebruiker succesvol aangemaakt.';
        header('Location: /users');
        exit;
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $user = $this->userModel->findById($id);
        if (!$user) {
            header('Location: /users');
            exit;
        }
        $stmt = $this->pdo->query("SELECT id, name FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require dirname(__DIR__, 2) . '/Views/users/edit.php';
    }

    public function update($id)
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role_id = $_POST['role_id'] ?? '';

        $errors = [];
        if (empty($name)) $errors[] = 'Naam is verplicht.';
        if (empty($email)) $errors[] = 'E-mail is verplicht.';
        if (empty($role_id)) $errors[] = 'Rol is verplicht.';

        if (empty($errors)) {
            $existing = $this->userModel->findByEmail($email);
            if ($existing && $existing['id'] != $id) {
                $errors[] = 'E-mailadres is al in gebruik.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['user_errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: /users/edit/' . $id);
            exit;
        }

        $this->userModel->update($id, [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id
        ]);

        $_SESSION['user_success'] = 'Gebruiker succesvol bijgewerkt.';
        header('Location: /users');
        exit;
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }
        $this->userModel->delete($id);
        $_SESSION['user_success'] = 'Gebruiker succesvol verwijderd.';
        header('Location: /users');
        exit;
    }
}
