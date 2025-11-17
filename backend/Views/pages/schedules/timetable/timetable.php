<?php
    ini_set('display_errors', 1);
	error_reporting(E_ALL);
    
    include_once __DIR__ . "/../../checkLogin.php";
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Emploi du Temps - GSC</title>
        <link rel="stylesheet" href="../../../../../public/assets/css/timetable.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>
        <script src="../../../../../public/assets/js/crud.js" defer></script>
        <script src="../../../../../public/assets/js/api-crud.js" type="module" defer></script>
        <script src="../../../../../public/assets/js/main.js" type="module" defer></script>
    </head>
    <body data-page="timetable"
        data-level-id="<?= $_SESSION['level_id'] ?>"
        data-serie-id="<?= $_SESSION['serie_id'] ?>"
        data-room-id="<?= $_SESSION['room_id'] ?>"
        data-place-id="<?= $_SESSION['place_id'] ?>"
    >
    <div id="timetable-container" class=".a4-page">
        <div class="header">
            <div class="logo">
                <img src="../../../../../public/assets/images/gsc-logo.png" alt="Logo de l'école">
            </div>
            <div class="header-info">
                <h2>Emploi du Temps Scolaire</h2>
                <p>
                    <span class="school school-grade">Classe :</span> <span id="class-grade"></span>&nbsp;
                    <span class="school school-room">Salle :</span> <span id="class-room"></span>
                </p>
                <p>
                    <span class="school school-series">Série :</span> <span id="class-series"></span>&nbsp;
                    <span class="school school-places">Centre :</span> <span id="class-places"></span>
                </p>
                <p>
                    <span class="school school-year">Année scolaire :</span> <span id="school-year"></span>
                </p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="time-col">Heure</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                </tr>
            </thead>
            <tbody id="schedule-body"></tbody>
        </table>

        <div class="footer">
            © 2025 GSC - Gestion Scolaire Complète | Emploi du temps
        </div>
    </div>

    <div class="pdf-controls" style="text-align:center; margin: 30px 0;">
        <button id="download-pdf" class="no-print">
            <i>📄</i>
            Télécharger en PDF
        </button>
    </div>
        
    </body>
</html>
