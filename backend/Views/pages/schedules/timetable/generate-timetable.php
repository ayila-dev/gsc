<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

    <div class="main-panel">
        <div class="form-container">

            <div class="form__header">
                <h1 class="form__title">Générer l'emploi du temps</h1>
            </div>

            <form class="form__body" id="generate-timetable-form" method="POST">

                <div class="form__group">
					<label for="place_id" class="group__label">Classe :</label>
					<select name="place_id" id="place_id" class="group__input" required></select>
				</div>

                <div class="form__group">
					<label for="level_id" class="group__label">Classe :</label>
					<select name="level_id" id="level_id" class="group__input" required></select>
				</div>

				<div class="form__group">
					<label for="serie_id" class="group__label">Série :</label>
					<select name="serie_id" id="serie_id" class="group__input" required></select>
				</div>

				<div class="form__group">
					<label for="room_id" class="group__label">Salle :</label>
					<select name="room_id" id="room_id" class="group__input" required></select>
				</div>

                <div class="form__group">
                    <button type="submit" name="generate" class="group__button">Générer le PDF</button>
                </div>
            </form>

        </div>
    </div>

<?php
    include_once __DIR__ . "/../../../partials/footer.php";
?>