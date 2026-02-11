<?php
/**
 * Web Routes
 */

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/traveleasy', '', $request);
$request = strtok($request, '?');

// Route mapping
switch ($request) {
    case '/':
    case '/dashboard':
        require __DIR__ . '/../app/Controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case '/login':
        require __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;

    case '/logout':
        require __DIR__ . '/../app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/boekingen':
        require __DIR__ . '/../app/Controllers/BoekingController.php';
        $controller = new BoekingController();
        $controller->index();
        break;

    case '/boekingen/create':
        require __DIR__ . '/../app/Controllers/BoekingController.php';
        $controller = new BoekingController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            $controller->create();
        }
        break;

    case '/klanten':
        require __DIR__ . '/../app/Controllers/KlantController.php';
        $controller = new KlantController();
        $controller->index();
        break;

    case '/logs':
        require __DIR__ . '/../app/Controllers/LogController.php';
        $controller = new LogController();
        $controller->index();
        break;

    default:
        // Check voor /logs/view/{id}
        if (preg_match('/^\/logs\/view\/(\d+)$/', $request, $matches)) {
            require __DIR__ . '/../app/Controllers/LogController.php';
            $controller = new LogController();
            $controller->view($matches[1]);
            break;
        }
        http_response_code(404);
        echo "404 - Pagina niet gevonden";
        break;
}
