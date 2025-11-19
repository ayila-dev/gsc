<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

	<div class="main-panel">
		<div class="form-container">

			<div class="form__header">
				<h1 class="form__title">Générer les bulletins des notes</h1>
			</div>

			<form class="form__body" id="generate-report-card-form" method="POST">

				<div class="form__group">
					<label for="place_id" class="group__label">Centre :</label>
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
					<label for="grade_period" class="group__label">Période d'évaluation :</label>
					<select name="grade_period" id="grade_period" class="group__input" required>
						<option value="" disabled selected>Période</option>

						<optgroup label="Trimestre">
							<option value="t1">Trimestre 1</option>
							<option value="t2">Trimestre 2</option>
							<option value="t3">Trimestre 3</option>
						</optgroup>

						<optgroup label="Semestre">
							<option value="s1">Semestre 1</option>
							<option value="s2">Semestre 2</option>
						</optgroup>
					</select>
				</div>

				<div class="form__group">
					<button type="submit" name="signup" class="group__button">Voir le PDF</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../../partials/footer.php";
?>