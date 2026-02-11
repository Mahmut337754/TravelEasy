<?php
/**
 * TravelEasy - Front Controller
 * Alle requests komen hier binnen
 */

session_start();

// Error reporting voor development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug mode
define('DEBUG_MODE', true);

// Autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Config laden
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// Error handler registreren
require_once __DIR__ . '/app/Core/ErrorHandler.php';
ErrorHandler::register();

// Router
require_once __DIR__ . '/routes/web.php';
