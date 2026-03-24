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
        require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'index.php';
    }

    public function create()
    {
        $this->checkAdmin();
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM roles");
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Roles ophalen mislukt: " . $e->getMessage());
            $roles = [];
        }
        require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'create.php';
    }

    public function store()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role_id = $_POST['role_id'] ?? '';

        $errors = [];
        if (empty($name))     $errors[] = 'Naam is verplicht.';
        if (empty($email))    $errors[] = 'E-mail is verplicht.';
        if (empty($password)) $errors[] = 'Wachtwoord is verplicht.';
        if (empty($role_id))  $errors[] = 'Rol is verplicht.';

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

        $result = $this->userModel->create([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'role_id'  => $role_id
        ]);

        if ($result) {
            $_SESSION['user_success'] = 'Gebruiker succesvol aangemaakt.';
        } else {
            $_SESSION['user_errors'] = ['Er is een databasefout opgetreden.'];
        }

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
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM roles");
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Roles ophalen mislukt: " . $e->getMessage());
            $roles = [];
        }
        require PROJECT_ROOT . 'Views' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'edit.php';
    }

    public function update($id)
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role_id = $_POST['role_id'] ?? '';

        $errors = [];
        if (empty($name))     $errors[] = 'Naam is verplicht.';
        if (empty($email))    $errors[] = 'E-mail is verplicht.';
        if (empty($role_id))  $errors[] = 'Rol is verplicht.';

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

        $data = [
            'name'     => $name,
            'email'    => $email,
            'role_id'  => $role_id
        ];
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $result = $this->userModel->update($id, $data);

        if ($result) {
            $_SESSION['user_success'] = 'Gebruiker succesvol bijgewerkt.';
        } else {
            $_SESSION['user_errors'] = ['Er is een databasefout opgetreden.'];
        }

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

        $result = $this->userModel->delete($id);
        if ($result) {
            $_SESSION['user_success'] = 'Gebruiker succesvol verwijderd.';
        } else {
            $_SESSION['user_errors'] = ['Kon gebruiker niet verwijderen.'];
        }

        header('Location: /users');
        exit;
    }
}