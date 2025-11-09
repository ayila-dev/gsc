<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

header("Content-Type: application/json");

require_once "../Controllers/SchedulesController.php";

$action = $_GET['action'] ?? null;

// Init controller
$schedulesController = new SchedulesController();

switch ($action) {
    case 'add':
        echo json_encode($schedulesController->addSchedule($_POST));
        break;

    case 'list':
        echo json_encode($schedulesController->selectAllSchedules());
        break;

    case 'get':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($schedulesController->selectScheduleById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID programme manquant"]);
        }
        break;

    case 'update':
        echo json_encode($schedulesController->updateSchedule($_POST));
        break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($schedulesController->deleteSchedule($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID programme manquant"]);
        }
        break;

    case 'generate-timetable-pdf':
        echo json_encode($schedulesController->generateTimetablePDF($_POST));
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
        break;
}
