<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>gsc</title>
    <link rel="stylesheet" href="/public/assets/css/app.css" />
    <link rel="shortcut icon" href="/public/assets/images-logo.png">
    <script src="/public/assets/js/crud.js" defer></script>
    <script src="/public/assets/js/api-crud.js" type="module" defer></script>
    <script src="/public/assets/js/main.js" type="module" defer></script>
</head>

<?php
    // session et calcul du slug de page (serveur) avant d'ouvrir <body>
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
    $page = basename($path, '.php') ?: 'dashboard';
    $_SESSION['page'] = $page;
?>

<body data-page="<?php echo htmlspecialchars($page, ENT_QUOTES); ?>">

<?php
    // inclure les partials ici — chemins basés sur l'emplacement du fichier
    include_once __DIR__ . '/settings.php';
    include_once __DIR__ . '/sidebar.php';
    
?>