<?php
require_once 'config/database.php';

class Asistencia {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($user_id, $evento_id) {
        $sql = "INSERT INTO asistencia (user_id, evento_id) VALUES (:user_id, :evento_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':evento_id', $evento_id);
        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM asistencia";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne() {
        $query = "SELECT * FROM asistencia WHERE asistencia_id = :asistencia_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':asistencia_id', $this->asistencia_id);
        $stmt->execute();
        return $stmt;
    }


    public function update($asistencia_id, $user_id, $evento_id) {
        $sql = "UPDATE asistencia SET user_id = :user_id, evento_id = :evento_id WHERE asistencia_id = :asistencia_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':asistencia_id', $asistencia_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':evento_id', $evento_id);
        return $stmt->execute();
    }

    public function delete($asistencia_id) {
        $sql = "DELETE FROM asistencia WHERE asistencia_id = :asistencia_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':asistencia_id', $asistencia_id);
        return $stmt->execute();
    }
}
?>
