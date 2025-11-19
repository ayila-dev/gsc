<?php
session_start();

if (isset($_POST['connect'])) {
    if ($_SESSION['role_name'] === "Enseignant") {
        $year_id = $_POST['year_id'] ?? null;
        $cycle_id = $_POST['cycle_id'] ?? null;
        $place_id = $_POST['place_id'] ?? null;

        // Vérifie que toutes les données nécessaires sont présentes
        if (!empty($year_id) && !empty($cycle_id) && !empty($place_id)) {

            require_once __DIR__ . "/../../Controllers/AuthController.php";
            $auth = new AuthController();

            // Récupération des données
            $school_year = $auth->checkSchoolYearById($year_id);
            $school_cycle = $auth->checkSchoolCycleById($cycle_id);
            $school_place = $auth->checkSchoolPlaceById($place_id);
            $teacher = $auth->selectLevelTeacher($year_id, $cycle_id, $place_id, $_SESSION['user_id']);

            // Vérification que tout existe réellement
            if (!$school_year || !$school_cycle || !$school_place) {
                $_SESSION['error'] = "Impossible de charger les informations scolaires.";
                header("Location: place.php");
                exit();
            }

            // Session
            $_SESSION['year_id']   = $year_id;
            $_SESSION['year_name'] = $school_year['year_name'];

            $_SESSION['cycle_id']   = $cycle_id;
            $_SESSION['cycle_name'] = $school_cycle['cycle_name'];

            $_SESSION['place_id']   = $place_id;
            $_SESSION['place_name'] = $school_place['place_name'];
            
            $_SESSION['level_id'] = $teacher['level_id'];
            $_SESSION['level_name'] = $teacher['level_name'];

            $_SESSION['serie_id'] = $teacher['serie_id'];
            $_SESSION['serie_name'] = $teacher['serie_name'];

            $_SESSION['room_id'] = $teacher['room_id'];
            $_SESSION['room_name'] = $teacher['room_name'];

            $_SESSION['course_id'] = $teacher['course_id'];
            $_SESSION['course_name'] = $teacher['course_name'];
            
            // Redirection
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $year_id = $_POST['year_id'] ?? null;
        $cycle_id = $_POST['cycle_id'] ?? null;

        // Vérifie que toutes les données nécessaires sont présentes
        if (!empty($year_id) && !empty($cycle_id)) {

            require_once __DIR__ . "/../../Controllers/AuthController.php";
            $auth = new AuthController();

            // Récupération des données
            $school_year = $auth->checkSchoolYearById($year_id);
            $school_cycle = $auth->checkSchoolCycleById($cycle_id);
            
            // Vérification que tout existe réellement
            if (!$school_year || !$school_cycle) {
                header("Location: place.php");
                exit();
            }

            // Session
            $_SESSION['year_id']   = $year_id;
            $_SESSION['year_name'] = $school_year['year_name'];

            $_SESSION['cycle_id']   = $cycle_id;
            $_SESSION['cycle_name'] = $school_cycle['cycle_name'];

            // Redirection
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>