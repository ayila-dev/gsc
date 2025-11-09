<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

header("Content-Type: application/json");

require_once "../Controllers/SettingsController.php";

$action = $_GET['action'] ?? null;

// Init controller
$settingsController = new SettingsController();

switch ($action) {
    // Years
    case 'add-year':
        echo json_encode($settingsController->addYear($_POST));
        break;
    case 'list-years':
        echo json_encode($settingsController->selectAllYears());
        break;
    case 'get-year':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectYearById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID année scolaire manquant"]);
        }
        break;
    case 'update-year':
        echo json_encode($settingsController->updateYear($_POST));
        break;
    case 'delete-year':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteYear($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID année scolaire manquant"]);
        }
        break;

    // Places
    case 'add-place':
        echo json_encode($settingsController->addPlace($_POST));
        break;
    case 'list-places':
        echo json_encode($settingsController->selectAllPlaces());
        break;
    case 'get-place':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectPlaceById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID centre manquant"]);
        }
        break;
    case 'update-place':
        echo json_encode($settingsController->updatePlace($_POST));
        break;
    case 'delete-place':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deletePlace($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID centre manquant"]);
        }
        break;

    // Cycles
    case 'add-cycle':
        echo json_encode($settingsController->addCycle($_POST));
        break;
    case 'list-cycles':
        echo json_encode($settingsController->selectAllCycles());
        break;
    case 'get-cycle':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectCycleById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID cycle manquant"]);
        }
        break;
    case 'update-cycle':
        echo json_encode($settingsController->updateCycle($_POST));
        break;
    case 'delete-cycle':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteCycle($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID cycle manquant"]);
        }
        break;

    // Levels
    case 'add-level':
        echo json_encode($settingsController->addLevel($_POST));
        break;
    case 'list-levels':
        echo json_encode($settingsController->selectAllLevels());
        break;
    case 'get-level':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectLevelById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID niveau manquant"]);
        }
        break;
    case 'update-level':
        echo json_encode($settingsController->updateLevel($_POST));
        break;
    case 'delete-level':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteLevel($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID niveau manquant"]);
        }
        break;

    // Rooms
    case 'add-room':
        echo json_encode($settingsController->addRoom($_POST));
        break;
    case 'list-rooms':
        echo json_encode($settingsController->selectAllRooms());
        break;
    case 'get-room':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectRoomById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID salle manquant"]);
        }
        break;
    case 'update-room':
        echo json_encode($settingsController->updateRoom($_POST));
        break;
    case 'delete-room':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteRoom($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID salle manquant"]);
        }
        break;

    // Series
    case 'add-serie':
        echo json_encode($settingsController->addSerie($_POST));
        break;
    case 'list-series':
        echo json_encode($settingsController->selectAllSeries());
        break;
    case 'get-serie':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectSerieById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID série manquant"]);
        }
        break;
    case 'update-serie':
        echo json_encode($settingsController->updateSerie($_POST));
        break;
    case 'delete-serie':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteSerie($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID série manquant"]);
        }
        break;

    // Schoolings
    case 'add-schooling':
        echo json_encode($settingsController->addSchooling($_POST));
        break;
    case 'list-schoolings':
        echo json_encode($settingsController->selectAllSchoolings());
        break;
    case 'get-schooling':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectSchoolingById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID scolarité manquant"]);
        }
        break;
    case 'update-schooling':
        echo json_encode($settingsController->updateSchooling($_POST));
        break;
    case 'delete-schooling':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteSchooling($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID scolarité manquant"]);
        }
        break;

    // Courses
    case 'add-course':
        echo json_encode($settingsController->addCourse($_POST));
        break;
    case 'list-courses':
        echo json_encode($settingsController->selectAllCourses());
        break;
    case 'get-course':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectCourseById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID matière manquant"]);
        }
        break;
    case 'update-course':
        echo json_encode($settingsController->updateCourse($_POST));
        break;
    case 'delete-course':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteCourse($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID matière manquant"]);
        }
        break;

    // Roles
    case 'add-role':
        echo json_encode($settingsController->addRole($_POST));
        break;
    case 'list-roles':
        echo json_encode($settingsController->selectAllRoles());
        break;
    case 'get-role':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectRoleById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID matière manquant"]);
        }
        break;
    case 'update-role':
        echo json_encode($settingsController->updateRole($_POST));
        break;
    case 'delete-role':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteRole($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID matière manquant"]);
        }
        break;

    // Access
    case 'add-access':
        echo json_encode($settingsController->addAccess($_POST));
        break;
    case 'list-access':
        echo json_encode($settingsController->selectAllAccess());
        break;
    case 'get-access':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectAccessById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID matière manquant"]);
        }
        break;
    case 'update-access':
        echo json_encode($settingsController->updateAccess($_POST));
        break;
    case 'delete-access':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteAccess($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID matière manquant"]);
        }
        break;

    // Fees
    case 'add-fee':
        echo json_encode($settingsController->addFee($_POST));
        break;
    case 'list-fees':
        echo json_encode($settingsController->selectAllFees());
        break;
    case 'get-fee':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->selectFeeById($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID frais manquant"]);
        }
        break;
    case 'update-fee':
        echo json_encode($settingsController->updateFee($_POST));
        break;
    case 'delete-fee':
        $id = $_GET['id'] ?? null;
        if ($id) {
            echo json_encode($settingsController->deleteFee($id));
        } else {
            echo json_encode(["success" => false, "message" => "ID frais manquant"]);
        }
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
        break;
}
