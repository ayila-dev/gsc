<?php
    if (isset($_POST['connect'])) {
        $year_id = $_POST['year_id'];
        $cycle_id = $_POST['cycle_id'];

        if (!empty($year_id) && !empty($cycle_id)) {
            require_once "../../Controllers/AuthController.php";
            $auth = new AuthController();

            $school_year = $auth->checkSchoolYearById($year_id);
            $school_cycle = $auth->checkSchoolCycleById($cycle_id);

            session_start();
            $_SESSION['year_name'] = $school_year['year_name'];
            $_SESSION['cycle_name'] = $school_cycle['cycle_name'];
            
            $_SESSION['year_id'] = $year_id;
            $_SESSION['cycle_id'] = $cycle_id;

            header("location: dashboard.php");
        }
    }
?>