<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

header("Content-Type: application/json");

require_once "../Controllers/UsersController.php";

$action = $_GET['action'] ?? null;

// Init controller
$usersController = new UsersController();

switch ($action) {
    case 'add':
        echo json_encode($usersController->addUser($_POST));
        break;

    case 'list':
        echo json_encode($usersController->selectTeachers());
        break;

    case 'get':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($usersController->selectUserById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID enseignant manquant"]);
        }
        break;

    case 'update':
        echo json_encode($usersController->updateUser($_POST));
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($usersController->deleteUser($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID enseignant manquant"]);
        }
        break;

    case 'place': 
        echo json_encode($usersController->selectPlacesByTeacherSchedules());
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
        break;
}
