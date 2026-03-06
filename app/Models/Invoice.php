<?php

class Invoice {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Get all invoices using stored procedure
     * @return array Array of invoices or empty array on error
     */
    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("CALL sp_GetAllInvoices()");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            
            return $result !== false ? $result : [];
        } catch (PDOException $e) {
            error_log("Error fetching all invoices: " . $e->getMessage());
            throw new Exception("Fout bij het ophalen van facturen: " . $e->getMessage());
        }
    }

    /**
     * Get invoice by ID using stored procedure
     * @param int $id Invoice ID
     * @return array|null Invoice data or null if not found
     */
    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("CALL sp_GetInvoiceById(:id)");
            $stmt->execute(['id' => (int)$id]);
            $result = $stmt->fetch();
            $stmt->closeCursor();
            
            return $result !== false ? $result : null;
        } catch (PDOException $e) {
            error_log("Error fetching invoice by ID {$id}: " . $e->getMessage());
            throw new Exception("Fout bij het ophalen van factuur: " . $e->getMessage());
        }
    }

    /**
     * Count total invoices using stored procedure
     * @return int Total number of invoices
     */
    public function countAll() {
        try {
            $stmt = $this->pdo->prepare("CALL sp_CountInvoices(@count)");
            $stmt->execute();
            $stmt->closeCursor();
            
            $result = $this->pdo->query("SELECT @count as total")->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error counting invoices: " . $e->getMessage());
            throw new Exception("Fout bij het tellen van facturen: " . $e->getMessage());
        }
    }

    /**
     * Get invoices by status using stored procedure
     * @param string $status Invoice status (paid, unpaid, overdue, cancelled)
     * @return array Array of invoices with given status
     */
    public function getByStatus($status) {
        try {
            $stmt = $this->pdo->prepare("CALL sp_GetInvoicesByStatus(:status)");
            $stmt->execute(['status' => $status]);
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            
            return $result !== false ? $result : [];
        } catch (PDOException $e) {
            error_log("Error fetching invoices by status {$status}: " . $e->getMessage());
            throw new Exception("Fout bij het ophalen van facturen op status: " . $e->getMessage());
        }
    }

    /**
     * Get invoice summary statistics using stored procedure
     * @return array Summary with totals for paid, unpaid, overdue, and total amount
     */
    public function getSummary() {
        try {
            $stmt = $this->pdo->prepare("CALL sp_GetInvoiceSummary(@total_paid, @total_unpaid, @total_overdue, @total_amount)");
            $stmt->execute();
            $stmt->closeCursor();
            
            $result = $this->pdo->query("SELECT @total_paid as paid, @total_unpaid as unpaid, @total_overdue as overdue, @total_amount as total")->fetch();
            
            return [
                'paid' => (float)($result['paid'] ?? 0),
                'unpaid' => (float)($result['unpaid'] ?? 0),
                'overdue' => (float)($result['overdue'] ?? 0),
                'total' => (float)($result['total'] ?? 0)
            ];
        } catch (PDOException $e) {
            error_log("Error fetching invoice summary: " . $e->getMessage());
            throw new Exception("Fout bij het ophalen van factuuroverzicht: " . $e->getMessage());
        }
    }

    /**
     * Delete invoice by ID using stored procedure
     * @param int $id Invoice ID
     * @return bool True on success
     */
    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("CALL sp_DeleteInvoice(:id)");
            $result = $stmt->execute(['id' => (int)$id]);
            $stmt->closeCursor();
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error deleting invoice {$id}: " . $e->getMessage());
            throw new Exception("Fout bij het verwijderen van factuur: " . $e->getMessage());
        }
    }
}

