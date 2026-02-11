<?php
/**
 * User Model
 */

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel {
    
    protected $table = 'gebruikers';

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ? AND isActief = 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (email, naam, wachtwoord, rol, isActief, datumAangemaakt, datumGewijzigd)
            VALUES (?, ?, ?, ?, 1, NOW(), NOW())
        ");
        
        $hashedPassword = password_hash($data['wachtwoord'], PASSWORD_DEFAULT);
        
        $stmt->execute([
            $data['email'],
            $data['naam'],
            $hashedPassword,
            $data['rol']
        ]);
        
        return $this->db->lastInsertId();
    }
}
