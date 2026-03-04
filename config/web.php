<?php
require_once __DIR__ . '/database.php';
$pdo = getDBConnection();

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/UserController.php';
require_once __DIR__ . '/../app/Controllers/CustomerController.php';
require_once __DIR__ . '/../app/Controllers/TripController.php';
require_once __DIR__ . '/../app/Controllers/AccommodationController.php';
require_once __DIR__ . '/../app/Controllers/BookingController.php';
require_once __DIR__ . '/../app/Controllers/ExtraController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {

    case '/':
    case '/home':
        $userEmail = $_SESSION['user_email'] ?? null;
        $userRole  = $_SESSION['user_role'] ?? null;
        require PROJECT_ROOT . 'views' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'index.php';
        break;

    case '/login':
        if ($method === 'POST') {
            (new AuthController($pdo))->login();
        } else {
            (new AuthController($pdo))->loginForm();
        }
        break;

    case '/logout':
        (new AuthController($pdo))->logout();
        break;

    case '/register':
        if ($method === 'POST') {
            (new AuthController($pdo))->register();
        } else {
            (new AuthController($pdo))->registerForm();
        }
        break;

    case '/dashboard':
        (new AuthController($pdo))->dashboard();
        break;

    case '/users':
        (new UserController($pdo))->index();
        break;
    case '/users/create':
        if ($method === 'POST') {
            (new UserController($pdo))->store();
        } else {
            (new UserController($pdo))->create();
        }
        break;
    case preg_match('#^/users/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new UserController($pdo))->update($matches[1]);
        } else {
            (new UserController($pdo))->edit($matches[1]);
        }
        break;
    case preg_match('#^/users/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new UserController($pdo))->destroy($matches[1]);
        break;

    case '/customers':
        (new CustomerController($pdo))->index();
        break;
    case '/customers/create':
        if ($method === 'POST') {
            (new CustomerController($pdo))->store();
        } else {
            (new CustomerController($pdo))->create();
        }
        break;
    case preg_match('#^/customers/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new CustomerController($pdo))->update($matches[1]);
        } else {
            (new CustomerController($pdo))->edit($matches[1]);
        }
        break;
    case preg_match('#^/customers/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new CustomerController($pdo))->destroy($matches[1]);
        break;

    case '/trips':
        (new TripController($pdo))->index();
        break;
    case '/trips/create':
        if ($method === 'POST') {
            (new TripController($pdo))->store();
        } else {
            (new TripController($pdo))->create();
        }
        break;
    case preg_match('#^/trips/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new TripController($pdo))->update($matches[1]);
        } else {
            (new TripController($pdo))->edit($matches[1]);
        }
        break;
    case preg_match('#^/trips/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new TripController($pdo))->destroy($matches[1]);
        break;

    case '/accommodations':
        (new AccommodationController($pdo))->index();
        break;
    case '/accommodations/create':
        if ($method === 'POST') {
            (new AccommodationController($pdo))->store();
        } else {
            (new AccommodationController($pdo))->create();
        }
        break;
    case preg_match('#^/accommodations/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new AccommodationController($pdo))->update($matches[1]);
        } else {
            (new AccommodationController($pdo))->edit($matches[1]);
        }
        break;
    case preg_match('#^/accommodations/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new AccommodationController($pdo))->destroy($matches[1]);
        break;

    case '/bookings':
        (new BookingController($pdo))->index();
        break;
    case '/bookings/create':
        if ($method === 'POST') {
            (new BookingController($pdo))->store();
        } else {
            (new BookingController($pdo))->create();
        }
        break;
    case preg_match('#^/bookings/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new BookingController($pdo))->update($matches[1]);
        } else {
            (new BookingController($pdo))->edit($matches[1]);
        }
        break;
    case preg_match('#^/bookings/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new BookingController($pdo))->destroy($matches[1]);
        break;

    case '/extras':
        (new ExtraController($pdo))->index();
        break;
    case '/extras/create':
        if ($method === 'POST') {
            (new ExtraController($pdo))->store();
        } else {
            (new ExtraController($pdo))->create();
        }
        break;
    case preg_match('#^/extras/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new ExtraController($pdo))->update($matches[1]);
        } else {
            (new ExtraController($pdo))->edit($matches[1]);
        }
        break;
    case preg_match('#^/extras/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new ExtraController($pdo))->destroy($matches[1]);
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
