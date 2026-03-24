<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        try {
            $stmt = $this->pdo->query("
                SELECT users.*, roles.name AS role_name
                FROM users
                JOIN roles ON users.role_id = roles.id
                ORDER BY users.id
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User::getAll error: " . $e->getMessage());
            return [];
        }
    }

    public function findById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User::findById error: " . $e->getMessage());
            return false;
        }
    }

    public function findByEmail($email)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User::findByEmail error: " . $e->getMessage());
            return false;
        }
    }

    public function create($data)
    {
        try {
            $sql = "INSERT INTO users (name, email, password_hash, role_id)
                    VALUES (:name, :email, :password_hash, :role_id)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
                'role_id'       => $data['role_id']
            ]);
        } catch (PDOException $e) {
            error_log("User::create error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $sql = "UPDATE users SET name = :name, email = :email, role_id = :role_id";
            if (!empty($data['password'])) {
                $sql .= ", password_hash = :password_hash";
            }
            $sql .= " WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            $params = [
                'name'    => $data['name'],
                'email'   => $data['email'],
                'role_id' => $data['role_id'],
                'id'      => $id
            ];
            if (!empty($data['password'])) {
                $params['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("User::update error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("User::delete error: " . $e->getMessage());
            return false;
        }
    }
}