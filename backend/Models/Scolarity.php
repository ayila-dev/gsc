<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

header("Content-Type: application/json");

require_once "../Controllers/ScolaritiesController.php";

$action = $_GET['action'] ?? null;

// Init controller
$scolaritiesController = new ScolaritiesController();

switch ($action) {
    case 'add':
        echo json_encode($scolaritiesController->addPayment($_POST));
        break;

    case 'list':
        echo json_encode($scolaritiesController->selectStudentsListScolarities($_SESSION['year_id']));
        break;

    case 'pay':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($scolaritiesController->getStudentPaymentDetails($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID élève manquant"]);
        }
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
        break;
}
