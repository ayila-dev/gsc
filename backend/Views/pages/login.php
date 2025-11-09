<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../Controllers/AuthController.php";

$action = $_GET['action'] ?? null;
$authController = new AuthController();

// Sécurisation des variables POST
$user_email = isset($_POST['user_email']) ? filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL) : null;
$user_password = $_POST['user_password'] ?? null;

switch ($action) {
    case 'login': {
        if (empty($user_email) || empty($user_password)) {
            echo json_encode([
                "success" => false,
                "message" => "Veuillez remplir tous les champs."
            ]);
            exit;
        }

        $result = $authController->checkUserByEmail($_POST);
        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                "success" => false,
                "message" => "Échec de la session utilisateur."
            ]);
            exit;
        }

        $user_role = $authController->checkUserRoleById($_SESSION['user_id']);
        $user_place = $authController->checkUserPlaceById($_SESSION['user_id']);
        $user_access_list = $authController->getUserAccessListById($_SESSION['user_id']);
        $user_first_connection = $authController->checkUserFirstConnectionById($user_email);

        $_SESSION['role_name'] = $user_role['role_name'] ?? null;
        $_SESSION['place_name'] = $user_place['place_name'] ?? null;
        $_SESSION['access_list'] = $user_access_list ?? [];
        $_SESSION['user_first_connection'] = $user_first_connection['user_first_connection'] ?? 1;

        require_once __DIR__ . '/../../helpers/auth_helpers.php';
        loadUserAccessSession($_SESSION['user_id']);

        function redirection($role_name, $first_connection) 
        {
            if ($role_name === "Super admin" || $role_name === "Apprenant") 
            {
                return "dashboard.php";
            } elseif ($first_connection === 0) {
                return "firstConnection.php";
            } else {
                return "place.php";
            }
        }

        echo json_encode([
            "success" => true,
            "message" => "Connexion réussie.",
            "role" => $user_role['role_name'] ?? null,
            "redirect" => redirection($user_role['role_name'], $user_first_connection['user_first_connection'] ?? 1 )
        ]);
        exit;
    }

    case 'connect': {
        $user_password_change = $_POST['user_password_change'] ?? '';
        $user_password_confirm = $_POST['user_password_confirm'] ?? '';

        if (empty($user_password_change) || empty($user_password_confirm)) {
            echo json_encode([
                "success" => false,
                "message" => "Veuillez remplir tous les champs."
            ]);
            exit;
        }

        if ($user_password_change !== $user_password_confirm) {
            echo json_encode([
                "success" => false,
                "message" => "Les mots de passe ne correspondent pas."
            ]);
            exit;
        }

        $user_role = $authController->checkUserRoleById($_SESSION['user_id']);
        $user_first_connection = $authController->checkUserFirstConnectionById($_SESSION['user_email']);

        if (!$user_first_connection) {
            echo json_encode([
                "success" => false,
                "message" => "Utilisateur introuvable."
            ]);
            exit;
        }

        $result = $authController->changePasswordAtFirstConnection($_POST);

        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }

        function redirection($role_name, $first_connection) 
        {
            if ($role_name === "Super admin" || $role_name === "Apprenant") 
            {
                return "dashboard.php";
            } elseif ($first_connection === 0) {
                return "place.php";
            }
        }

        echo json_encode([
            "success" => true,
            "message" => "Mot de passe changé avec succès.",
            "redirect" => redirection($user_role['role_name'], $user_first_connection['user_first_connection'] ?? 1 )
        ]);
        exit;
    }
}
