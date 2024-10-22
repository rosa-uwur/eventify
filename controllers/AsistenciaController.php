<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/eventify/models/Asistencia.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/eventify/config/database.php');

class AsistenciaController {
    private $asistencia;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->asistencia = new Asistencia($this->db);
    }

    public function createAsistencia($user_id, $evento_id) {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->user_id) && !empty($data->evento_id)) {
            $this->asistencia->user_id = $data->user_id;
            $this->asistencia->evento_id = $data->evento_id;

            if ($this->asistencia->create($user_id, $evento_id)) {
                echo json_encode(["message" => "Asistencia creada exitosamente."]);
            } else {
                echo json_encode(["message" => "Error al registrar la asistencia"]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos."]);
        }
    }

    public function readAsistencias() {
        $result = $this->asistencia->read();
        echo json_encode($result);
    }

    public function readAsistencia() {
        $data = json_decode(file_get_contents("php://input"));
        $this->asistencia->asistencia_id = $data->asistencia_id;
        $stmt = $this->asistencia->readOne();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($asistencia);
    }

    public function updateAsistencia($asistencia_id, $user_id, $evento_id) {
        if ($this->asistencia->update($asistencia_id, $user_id, $evento_id)) {
            echo json_encode(['message' => 'Asistencia actualizada con éxito.']);
        } else {
            echo json_encode(['message' => 'Error al actualizar la asistencia.']);
        }
    }

    public function deleteAsistencia($asistencia_id) {
        if ($this->asistencia->delete($asistencia_id)) {
            echo json_encode(['message' => 'Asistencia eliminada con éxito.']);
        } else {
            echo json_encode(['message' => 'Error al eliminar la asistencia.']);
        }
    }
}
?>
