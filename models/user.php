<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    public $user_id;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); // Encriptar contraseña

        // Asignar valores
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT user_id, username, email FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT user_id, username, email FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET username = :username, email = :email, password = :password WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); // Encriptar contraseña

        // Asignar valores
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function login() {
        $query = "SELECT user_id, username, password FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->email = htmlspecialchars(strip_tags($this->email));
    
        // Asignar valor del email
        $stmt->bindParam(':email', $this->email);
    
        $stmt->execute();
    
        // Si se encuentra un usuario
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verificar la contraseña
            if (password_verify($this->password, $row['password'])) {
                // Las credenciales son correctas
                $this->user_id = $row['user_id'];
                $this->username = $row['username'];
                return true;
            }
        }
        // Las credenciales son incorrectas
        return false;
    }
    

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
