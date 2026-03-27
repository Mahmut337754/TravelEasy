<?php

class User
{
    // PDO database verbinding opslaan in de class
    private $pdo;

    public function __construct($pdo)
    {
        // Bij het maken van een User object geven we de database verbinding mee
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        try {
            // Haal alle users op + hun rolnaam uit de roles tabel
            $stmt = $this->pdo->query("
                SELECT users.*, roles.name AS role_name
                FROM users
                JOIN roles ON users.role_id = roles.id
                ORDER BY users.id
            ");

            // Alles teruggeven als associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Fout loggen zodat je het later kunt debuggen
            error_log("User::getAll error: " . $e->getMessage());
            return [];
        }
    }

    public function findById($id)
    {
        try {
            // 1 specifieke user zoeken op id
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);

            // 1 rij teruggeven
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User::findById error: " . $e->getMessage());
            return false;
        }
    }

    public function findByEmail($email)
    {
        try {
            // User zoeken op email (handig voor login / controle)
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
            // Nieuwe user toevoegen aan database
            $sql = "INSERT INTO users (name, email, password_hash, role_id)
                    VALUES (:name, :email, :password_hash, :role_id)";

            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                'name'          => $data['name'],
                'email'         => $data['email'],

                // Wachtwoord NOOIT direct opslaan, altijd hashen
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
            // Basis update query zonder wachtwoord
            $sql = "UPDATE users SET name = :name, email = :email, role_id = :role_id";

            // Alleen wachtwoord updaten als er echt iets is ingevuld
            if (!empty($data['password'])) {
                $sql .= ", password_hash = :password_hash";
            }

            $sql .= " WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);

            // Standaard velden voor update
            $params = [
                'name'    => $data['name'],
                'email'   => $data['email'],
                'role_id' => $data['role_id'],
                'id'      => $id
            ];

            // Alleen password_hash toevoegen als wachtwoord is ingevuld
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
            // User verwijderen op basis van id
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("User::delete error: " . $e->getMessage());
            return false;
        }
    }
}
