<?php

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
        (new AuthController())->loginForm();
        break;

    case '/login':
        if ($method === 'POST') {
            (new AuthController())->login();
        } else {
            (new AuthController())->loginForm();
        }
        break;

    case '/logout':
        (new AuthController())->logout();
        break;

    case '/register':
        if ($method === 'POST') {
            (new AuthController())->register();
        } else {
            (new AuthController())->registerForm();
        }
        break;

    case '/users':
        (new UserController())->index();
        break;
    case '/users/create':
        if ($method === 'POST') {
            (new UserController())->store();
        } else {
            (new UserController())->create();
        }
        break;
    case preg_match('#^/users/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new UserController())->update($matches[1]);
        } else {
            (new UserController())->edit($matches[1]);
        }
        break;
    case preg_match('#^/users/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new UserController())->destroy($matches[1]);
        break;

    case '/customers':
        (new CustomerController())->index();
        break;
    case '/customers/create':
        if ($method === 'POST') {
            (new CustomerController())->store();
        } else {
            (new CustomerController())->create();
        }
        break;
    case preg_match('#^/customers/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new CustomerController())->update($matches[1]);
        } else {
            (new CustomerController())->edit($matches[1]);
        }
        break;
    case preg_match('#^/customers/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new CustomerController())->destroy($matches[1]);
        break;

    case '/trips':
        (new TripController())->index();
        break;
    case '/trips/create':
        if ($method === 'POST') {
            (new TripController())->store();
        } else {
            (new TripController())->create();
        }
        break;
    case preg_match('#^/trips/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new TripController())->update($matches[1]);
        } else {
            (new TripController())->edit($matches[1]);
        }
        break;
    case preg_match('#^/trips/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new TripController())->destroy($matches[1]);
        break;

    case '/accommodations':
        (new AccommodationController())->index();
        break;
    case '/accommodations/create':
        if ($method === 'POST') {
            (new AccommodationController())->store();
        } else {
            (new AccommodationController())->create();
        }
        break;
    case preg_match('#^/accommodations/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new AccommodationController())->update($matches[1]);
        } else {
            (new AccommodationController())->edit($matches[1]);
        }
        break;
    case preg_match('#^/accommodations/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new AccommodationController())->destroy($matches[1]);
        break;

    case '/bookings':
        (new BookingController())->index();
        break;
    case '/bookings/create':
        if ($method === 'POST') {
            (new BookingController())->store();
        } else {
            (new BookingController())->create();
        }
        break;
    case preg_match('#^/bookings/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new BookingController())->update($matches[1]);
        } else {
            (new BookingController())->edit($matches[1]);
        }
        break;
    case preg_match('#^/bookings/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new BookingController())->destroy($matches[1]);
        break;

    case '/extras':
        (new ExtraController())->index();
        break;
    case '/extras/create':
        if ($method === 'POST') {
            (new ExtraController())->store();
        } else {
            (new ExtraController())->create();
        }
        break;
    case preg_match('#^/extras/edit/(\d+)$#', $uri, $matches) ? true : false:
        if ($method === 'POST') {
            (new ExtraController())->update($matches[1]);
        } else {
            (new ExtraController())->edit($matches[1]);
        }
        break;
    case preg_match('#^/extras/delete/(\d+)$#', $uri, $matches) ? true : false:
        (new ExtraController())->destroy($matches[1]);
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
