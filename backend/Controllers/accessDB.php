<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../helpers/auth_helpers.php"; // adapter le chemin si besoin

// Démarre la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Simuler un utilisateur connecté pour le test
// Remplacez user_id par un ID existant dans votre base
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // <- ID d'un utilisateur existant
}

// Vérifie et affiche la liste des accès
echo "<h2>Test des droits d'accès</h2>";

$auth = new AuthController();
$accessList = $auth->getUserAccessListById($_SESSION['user_id']);

echo "<pre>Access List:\n";
print_r($accessList);
echo "</pre>";


echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Test de la fonction hasAccess
$tests = ['add-student', 'list-student', 'delete-student'];
foreach ($tests as $access) {
    echo "Has access '{$access}'? ";
    echo hasAccess($access) ? "<strong style='color:green'>Oui</strong><br>" : "<strong style='color:red'>Non</strong><br>";
}

$motDePasseSaisi = '9\/mQC?@wbc2[';
$hashEnBDD = password_hash($motDePasseSaisi, PASSWORD_DEFAULT);

echo '<br /><br />';

var_dump(password_verify($motDePasseSaisi, $hashEnBDD));

echo '<br /><br />' . $hashEnBDD . '<br /><br />';

// UPDATE users SET user_password = PASSWORD('$2y$10$K2zefV1A7kro2WiwhQLsJukhsjuYU3rZFXSsL19xLn805xxBi/lMO') WHERE user_email = 'user2@gmail.com';
?>

