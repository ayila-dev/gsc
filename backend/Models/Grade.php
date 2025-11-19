<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

header("Content-Type: application/json");

require_once "../Controllers/GradesController.php";

$action = $_GET['action'] ?? null;

// Init controller
$gradesController = new GradesController();

switch ($action) {
    case 'add':
        echo json_encode($gradesController->addGrade($_POST));
        break;

    case 'listAdd':
        echo json_encode($gradesController->selectAllStudentByParams());
        break;

    case 'list':
        echo json_encode($gradesController->selectAllGradesByParams());
        break;

    case "reportCard":
        echo json_encode($gradesController->getReportCard($_POST));
        break;

    /* case 'get':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($gradesController->selectGradeByStudentId($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID parent manquant"]);
        }
        break;

    case 'update':
        echo json_encode($gradesController->updateGrade($_POST));
        break; */

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
        break;
}
