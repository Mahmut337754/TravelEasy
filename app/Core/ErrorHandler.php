<?php
/**
 * Error Handler
 * Centrale error handling met logging
 */

require_once __DIR__ . '/Logger.php';

class ErrorHandler {
    
    private static $logger;

    public static function register() {
        self::$logger = Logger::getInstance();
        
        // Set error handler
        set_error_handler([self::class, 'handleError']);
        
        // Set exception handler
        set_exception_handler([self::class, 'handleException']);
        
        // Set shutdown handler voor fatal errors
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleError($errno, $errstr, $errfile, $errline) {
        $errorTypes = [
            E_ERROR => 'ERROR',
            E_WARNING => 'WARNING',
            E_NOTICE => 'NOTICE',
            E_USER_ERROR => 'USER_ERROR',
            E_USER_WARNING => 'USER_WARNING',
            E_USER_NOTICE => 'USER_NOTICE',
            E_STRICT => 'STRICT',
            E_DEPRECATED => 'DEPRECATED'
        ];

        $level = $errorTypes[$errno] ?? 'UNKNOWN';
        
        self::$logger->log($level, $errstr, [
            'file' => $errfile,
            'line' => $errline,
            'errno' => $errno
        ]);

        // Laat PHP's normale error handling ook werken
        return false;
    }

    public static function handleException($exception) {
        self::$logger->critical('Uncaught Exception', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);

        // Toon gebruiksvriendelijke error pagina
        if (!headers_sent()) {
            http_response_code(500);
        }
        
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            echo "<h1>Error</h1>";
            echo "<p>" . $exception->getMessage() . "</p>";
            echo "<pre>" . $exception->getTraceAsString() . "</pre>";
        } else {
            echo "<h1>Er is een fout opgetreden</h1>";
            echo "<p>Probeer het later opnieuw.</p>";
        }
    }

    public static function handleShutdown() {
        $error = error_get_last();
        
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            self::$logger->critical('Fatal Error', [
                'message' => $error['message'],
                'file' => $error['file'],
                'line' => $error['line'],
                'type' => $error['type']
            ]);
        }
    }
}
