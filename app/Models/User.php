<?php

require_once __DIR__ . '/../../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($email, $password, $role)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }
}
