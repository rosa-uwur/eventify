<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/eventify/config/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/eventify/models/user.php');

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->user = new user($this->db);
    }

    public function createUser() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->email) && !empty($data->password)) {
            $this->user->username = $data->username;
            $this->user->email = $data->email;
            $this->user->password = $data->password;

            if ($this->user->create()) {
                echo json_encode(["message" => "Usuario creado exitosamente."]);
            } else {
                echo json_encode(["message" => "Error al crear el usuario."]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos."]);
        }
    }

    public function readUsers() {
        $stmt = $this->user->read();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    }

    public function readUser() {
        $data = json_decode(file_get_contents("php://input"));
        $this->user->user_id = $data->user_id;
        $stmt = $this->user->readOne();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user);
    }

    public function updateUser() {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->user_id) && !empty($data->username) && !empty($data->email) && !empty($data->password)) {
            $this->user->user_id = $data->user_id;
            $this->user->username = $data->username;
            $this->user->email = $data->email;
            $this->user->password = $data->password;

            if ($this->user->update()) {
                echo json_encode(["message" => "Usuario actualizado exitosamente."]);
            } else {
                echo json_encode(["message" => "Error al actualizar el usuario."]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos."]);
        }
    }

    public function deleteUser() {
        $data = json_decode(file_get_contents("php://input"));
        $this->user->user_id = $data->user_id;

        if ($this->user->delete()) {
            echo json_encode(["message" => "Usuario eliminado exitosamente."]);
        } else {
            echo json_encode(["message" => "Error al eliminar el usuario."]);
        }
    }
}
?>
