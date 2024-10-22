<?php
require_once 'config/database.php';

class Evento {
    private $conn;
    private $table_name = "evento";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllEventos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvento($data) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, titulo, descripcion, fecha) VALUES (:user_id, :titulo, :descripcion, :fecha)";
        $stmt = $this->conn->prepare($query);

        // Asignar valores
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':fecha', $data['fecha']);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getEventoById($evento_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE evento_id = :evento_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':evento_id', $evento_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEvento($evento_id, $data) {
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, descripcion = :descripcion, fecha = :fecha WHERE evento_id = :evento_id";
        $stmt = $this->conn->prepare($query);

        // Asignar valores
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':fecha', $data['fecha']);
        $stmt->bindParam(':evento_id', $evento_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
