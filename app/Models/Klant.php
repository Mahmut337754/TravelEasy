<?php
/**
 * Klant Model
 */

require_once __DIR__ . '/BaseModel.php';

class Klant extends BaseModel {
    
    protected $table = 'klanten';

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (voornaam, achternaam, email, telefoon, geboortedatum, isActief, opmerking, datumAangemaakt, datumGewijzigd)
            VALUES (?, ?, ?, ?, ?, 1, ?, NOW(), NOW())
        ");
        
        $stmt->execute([
            $data['voornaam'],
            $data['achternaam'],
            $data['email'],
            $data['telefoon'],
            $data['geboortedatum'],
            $data['opmerking'] ?? null
        ]);
        
        return $this->db->lastInsertId();
    }
}
