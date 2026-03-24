<?php
// Definieer de hoofdmap van de applicatie (één niveau omhoog ten opzichte van public)
define('PROJECT_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Start sessie
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Laad de routering (web.php zit in de config-map, één niveau hoger)
require_once PROJECT_ROOT . 'config' . DIRECTORY_SEPARATOR . 'web.php';