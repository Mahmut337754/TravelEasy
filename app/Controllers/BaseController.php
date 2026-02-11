<?php
/**
 * Base Controller
 * Alle controllers erven van deze class
 */

class BaseController {
    
    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../Views/' . $view . '.php';
    }

    protected function redirect($url) {
        header("Location: " . APP_URL . $url);
        exit;
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }

    protected function hasRole($role) {
        return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === $role;
    }

    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
