<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/eventify/models/Evento.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/eventify/config/database.php');

class EventoController {
    private $db;
    private $eventoModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->eventoModel = new Evento($this->db);
    }

    public function getEventos() {
        $eventos = $this->eventoModel->getAllEventos();
        echo json_encode($eventos);
    }

    public function createEvento() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($this->eventoModel->createEvento($data)) {
            echo json_encode(array("message" => "Evento creado con éxito"));
        } else {
            echo json_encode(array("message" => "Error al crear el evento"));
        }
    }

    public function getEvento($evento_id) {
        $evento = $this->eventoModel->getEventoById($evento_id);
        if ($evento) {
            echo json_encode($evento);
        } else {
            echo json_encode(array("message" => "Evento no encontrado"));
        }
    }

    public function updateEvento($evento_id) {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if ($this->eventoModel->updateEvento($evento_id, $data)) {
            echo json_encode(array("message" => "Evento actualizado con éxito"));
        } else {
            echo json_encode(array("message" => "Error al actualizar el evento"));
        }
    }
}
?>
