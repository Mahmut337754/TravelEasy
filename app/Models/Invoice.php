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
     * Get booking options for creating invoices using stored procedure
     * @return array
     */
    public function getCreateOptions() {
        try {
            $stmt = $this->pdo->prepare("CALL sp_GetInvoiceCreateOptions()");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();

            return $result !== false ? $result : [];
        } catch (PDOException $e) {
            $message = $e->getMessage();
            if (strpos($message, '1305') !== false || stripos($message, 'does not exist') !== false) {
                return $this->getCreateOptionsWithQueryFallback();
            }

            error_log("Error fetching invoice create options: " . $e->getMessage());
            throw new Exception("Fout bij het ophalen van boekingen voor factuur: " . $e->getMessage());
        }
    }

    /**
     * Create invoice using stored procedure
     * @param array $data
     * @return int
     */
    public function create(array $data) {
        try {
            $stmt = $this->pdo->prepare(
                "CALL sp_CreateInvoice(:booking_id, :customer_id, :invoice_number, :invoice_date, :due_date, :total_amount, :tax_amount, :status, :payment_date, :currency)"
            );
            $stmt->execute([
                'booking_id' => $data['booking_id'],
                'customer_id' => $data['customer_id'],
                'invoice_number' => $data['invoice_number'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'total_amount' => $data['total_amount'],
                'tax_amount' => $data['tax_amount'],
                'status' => $data['status'],
                'payment_date' => $data['payment_date'],
                'currency' => $data['currency'],
            ]);
            $stmt->closeCursor();

            $idRow = $this->pdo->query("SELECT LAST_INSERT_ID() AS id")->fetch();
            return (int)($idRow['id'] ?? 0);
        } catch (PDOException $e) {
            $message = $e->getMessage();
            if (strpos($message, '1305') !== false || stripos($message, 'does not exist') !== false) {
                return $this->createWithQueryFallback($data);
            }

            error_log("Error creating invoice: " . $e->getMessage());
            throw new Exception("Fout bij het aanmaken van factuur: " . $e->getMessage());
        }
    }

    /**
     * Update invoice by ID using stored procedure
     * @param int $id Invoice ID
     * @param array $data Invoice payload
     * @return bool True on success
     */
    public function update($id, array $data) {
        try {
            $stmt = $this->pdo->prepare("CALL sp_UpdateInvoice(:id, :invoice_number, :invoice_date, :due_date, :total_amount, :tax_amount, :status, :payment_date, :currency)");
            $result = $stmt->execute([
                'id' => (int)$id,
                'invoice_number' => $data['invoice_number'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'total_amount' => $data['total_amount'],
                'tax_amount' => $data['tax_amount'],
                'status' => $data['status'],
                'payment_date' => $data['payment_date'],
                'currency' => $data['currency'],
            ]);
            $stmt->closeCursor();

            return $result;
        } catch (PDOException $e) {
            // Fallback for environments where the new stored procedure is not deployed yet.
            $message = $e->getMessage();
            if (strpos($message, '1305') !== false || stripos($message, 'does not exist') !== false) {
                return $this->updateWithQueryFallback($id, $data);
            }

            error_log("Error updating invoice {$id}: " . $e->getMessage());
            throw new Exception("Fout bij het bijwerken van factuur: " . $e->getMessage());
        }
    }

    /**
     * Fallback update when stored procedure is unavailable
     * @param int $id Invoice ID
     * @param array $data Invoice payload
     * @return bool True on success
     */
    private function updateWithQueryFallback($id, array $data) {
        try {
            $stmt = $this->pdo->prepare(
                "UPDATE invoices
                 SET invoice_number = :invoice_number,
                     invoice_date = :invoice_date,
                     due_date = :due_date,
                     total_amount = :total_amount,
                     tax_amount = :tax_amount,
                     status = :status,
                     payment_date = :payment_date,
                     currency = :currency
                 WHERE id = :id"
            );

            return $stmt->execute([
                'id' => (int)$id,
                'invoice_number' => $data['invoice_number'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'total_amount' => $data['total_amount'],
                'tax_amount' => $data['tax_amount'],
                'status' => $data['status'],
                'payment_date' => $data['payment_date'],
                'currency' => $data['currency'],
            ]);
        } catch (PDOException $e) {
            error_log("Fallback invoice update failed for {$id}: " . $e->getMessage());
            throw new Exception("Fout bij het bijwerken van factuur: " . $e->getMessage());
        }
    }

    /**
     * Fallback create options query with joins
     * @return array
     */
    private function getCreateOptionsWithQueryFallback() {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT
                    b.id AS booking_id,
                    c.id AS customer_id,
                    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                    t.title AS trip_title
                 FROM bookings b
                 INNER JOIN customers c ON b.customer_id = c.id
                 INNER JOIN trips t ON b.trip_id = t.id
                 ORDER BY b.id DESC"
            );
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result !== false ? $result : [];
        } catch (PDOException $e) {
            error_log("Fallback create options query failed: " . $e->getMessage());
            throw new Exception("Fout bij het ophalen van boekingen voor factuur: " . $e->getMessage());
        }
    }

    /**
     * Fallback create when stored procedure is unavailable
     * @param array $data
     * @return int
     */
    private function createWithQueryFallback(array $data) {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO invoices
                    (booking_id, customer_id, invoice_number, invoice_date, due_date, total_amount, tax_amount, status, payment_date, currency)
                 VALUES
                    (:booking_id, :customer_id, :invoice_number, :invoice_date, :due_date, :total_amount, :tax_amount, :status, :payment_date, :currency)"
            );
            $stmt->execute([
                'booking_id' => $data['booking_id'],
                'customer_id' => $data['customer_id'],
                'invoice_number' => $data['invoice_number'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'total_amount' => $data['total_amount'],
                'tax_amount' => $data['tax_amount'],
                'status' => $data['status'],
                'payment_date' => $data['payment_date'],
                'currency' => $data['currency'],
            ]);

            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Fallback invoice create failed: " . $e->getMessage());
            throw new Exception("Fout bij het aanmaken van factuur: " . $e->getMessage());
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

