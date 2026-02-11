<?php
/**
 * Logger Class
 * Technische logging voor alle acties in het systeem
 */

class Logger {
    
    private static $instance = null;
    private $db;
    private $logFile;

    private function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->logFile = BASE_PATH . '/logs/app.log';
        
        // Maak logs directory aan als deze niet bestaat
        if (!file_exists(BASE_PATH . '/logs')) {
            mkdir(BASE_PATH . '/logs', 0755, true);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Log naar database en bestand
     */
    public function log($level, $message, $context = []) {
        try {
            // Log naar database
            $this->logToDatabase($level, $message, $context);
            
            // Log naar bestand
            $this->logToFile($level, $message, $context);
            
        } catch (Exception $e) {
            // Fallback: alleen naar bestand als database faalt
            $this->logToFile('ERROR', 'Database logging failed: ' . $e->getMessage());
            $this->logToFile($level, $message, $context);
        }
    }

    /**
     * Log naar database tabel
     */
    private function logToDatabase($level, $message, $context) {
        $stmt = $this->db->prepare("
            INSERT INTO technische_logs 
            (level, message, context, gebruikerId, ipAdres, userAgent, url, datumAangemaakt)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $level,
            $message,
            json_encode($context),
            $_SESSION['user_id'] ?? null,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null,
            $_SERVER['REQUEST_URI'] ?? null
        ]);
    }

    /**
     * Log naar bestand
     */
    private function logToFile($level, $message, $context) {
        $timestamp = date('Y-m-d H:i:s');
        $userId = $_SESSION['user_id'] ?? 'guest';
        $contextStr = !empty($context) ? json_encode($context) : '';
        
        $logMessage = sprintf(
            "[%s] [%s] [User: %s] %s %s\n",
            $timestamp,
            $level,
            $userId,
            $message,
            $contextStr
        );
        
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    // Convenience methods
    public function info($message, $context = []) {
        $this->log('INFO', $message, $context);
    }

    public function warning($message, $context = []) {
        $this->log('WARNING', $message, $context);
    }

    public function error($message, $context = []) {
        $this->log('ERROR', $message, $context);
    }

    public function debug($message, $context = []) {
        $this->log('DEBUG', $message, $context);
    }

    public function critical($message, $context = []) {
        $this->log('CRITICAL', $message, $context);
    }

    /**
     * Log gebruikersactie
     */
    public function logAction($action, $entity, $entityId = null, $details = []) {
        $message = sprintf(
            "Gebruiker %s heeft %s uitgevoerd op %s",
            $_SESSION['user_naam'] ?? 'Onbekend',
            $action,
            $entity
        );
        
        $context = array_merge([
            'action' => $action,
            'entity' => $entity,
            'entityId' => $entityId
        ], $details);
        
        $this->info($message, $context);
    }
}
