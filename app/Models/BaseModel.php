<?php
/**
 * Base Model
 * Alle models erven van deze class
 */

class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE isActief = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? AND isActief = 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET isActief = 0, datumGewijzigd = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
