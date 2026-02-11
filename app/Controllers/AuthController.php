<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    public function loginForm()
    {
        require __DIR__ . '/../../views/auth/login.php';
    }

    public function login()
    {
        if (!isset($_POST['email'], $_POST['password'])) {
            echo "Vul alle velden in.";
            return;
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            echo "Onbekende gebruiker.";
            return;
        }

        if (!password_verify($password, $user['password'])) {
            echo "Verkeerd wachtwoord.";
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        header("Location: /users");
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function registerForm()
    {
        require __DIR__ . '/../../views/auth/register.php';
    }

    public function register()
    {
        if (!isset($_POST['email'], $_POST['password'], $_POST['role'])) {
            echo "Vul alle velden in.";
            return;
        }

        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            echo "Gebruiker bestaat al.";
            return;
        }

        $userModel->create($email, $password, $role);

        header("Location: /login");
        exit;
    }
}
