<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/eventify/controllers/userController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/eventify/controllers/EventoController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/eventify/controllers/AsistenciaController.php'); // Incluye el controlador de asistencia

$usuarioController = new UserController();
$eventoController = new EventoController();
$asistenciaController = new AsistenciaController(); // Instancia el controlador de asistencia

$request_method = $_SERVER["REQUEST_METHOD"];
$action = isset($_GET['action']) ? $_GET['action'] : null;
$evento_id = isset($_GET['evento_id']) ? $_GET['evento_id'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$asistencia_id = isset($_GET['asistencia_id']) ? $_GET['asistencia_id'] : null; // Para acciones de asistencia

switch ($request_method) {
    case 'POST':
        // Acciones de usuario
        if ($action == 'create_user') {
            $usuarioController->createUser();
        } else if ($action == 'update_user') {
            $usuarioController->updateUser();
        } else if ($action == 'delete_user') {
            $usuarioController->deleteUser();
        } else if ($action == 'login') {
            $usuarioController->loginUser(); // Llama al método de inicio de sesión
        }
        // Acciones de evento
        else if ($action == 'create_event') {
            $eventoController->createEvento();
        }
        // Acciones de asistencia
        else if ($action == 'create_asistencia') {
            $asistenciaController->createAsistencia($user_id, $evento_id);
        }
        break;

    case 'GET':
        // Acciones de usuario
        if ($action == 'read_user') {
            if (isset($_GET['user_id'])) {
                $usuarioController->readUser();
            } else {
                $usuarioController->readUsers();
            }
        }
        // Acciones de evento
        else if ($action == 'read_event') {
            if ($evento_id) {
                $eventoController->getEvento($evento_id);
            } else {
                $eventoController->getEventos();
            }
        }
        // Acciones de asistencia
        else if ($action == 'read_asistencias') {
            if ($asistencia_id) {
                $asistenciaController->readAsistencia($asistencia_id);
            } else {
                $asistenciaController->readAsistencias();
            }
        }
        break;

    case 'PUT':
        // Actualizar evento
        if ($evento_id && $action == 'update_event') {
            $eventoController->updateEvento($evento_id);
        }
        // Actualizar asistencia
        else if ($asistencia_id && $action == 'update_asistencia') {
            $asistenciaController->updateAsistencia($asistencia_id);
        }
        break;

    case 'DELETE':
        // Eliminar usuario
        if ($action == 'delete_user') {
            $usuarioController->deleteUser();
        }
        // Eliminar evento
        else if ($evento_id && $action == 'delete_event') {
            $eventoController->deleteEvento($evento_id);
        }
        // Eliminar asistencia
        else if ($asistencia_id && $action == 'delete_asistencia') {
            $asistenciaController->deleteAsistencia($asistencia_id);
        }
        break;

    default:
        echo json_encode(["message" => "Método no soportado."]);
        break;
}
?>
