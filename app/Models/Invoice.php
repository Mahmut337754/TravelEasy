<?php

class Invoice {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT 
                    i.id,
                    i.invoice_number,
                    i.invoice_date,
                    i.due_date,
                    i.total_amount,
                    i.tax_amount,
                    i.status,
                    i.payment_date,
                    i.currency,
                    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                    c.email AS customer_email,
                    t.title AS trip_title,
                    b.status AS booking_status
                FROM invoices i
                INNER JOIN customers c ON i.customer_id = c.id
                INNER JOIN bookings b ON i.booking_id = b.id
                INNER JOIN trips t ON b.trip_id = t.id
                ORDER BY i.invoice_date DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT 
                    i.*,
                    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                    c.email AS customer_email,
                    c.address AS customer_address,
                    t.title AS trip_title,
                    t.description AS trip_description
                FROM invoices i
                INNER JOIN customers c ON i.customer_id = c.id
                INNER JOIN bookings b ON i.booking_id = b.id
                INNER JOIN trips t ON b.trip_id = t.id
                WHERE i.id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM invoices";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
}
