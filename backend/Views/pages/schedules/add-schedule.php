<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">
		<div class="form-container">

			<div class="form__header">
				<h1 class="form__title">Ajouter un programme</h1>
			</div>

			<form method="POST" class="form__body" id="add-schedule-form">

				<div class="form__group">
					<label for="teacher_id" class="group__label">Enseignant :</label>
					<select name="teacher_id" id="teacher_id" class="group__input" required></select>
				</div>

				<div class="form__group">
					<label for="place_id" class="group__label">Centre :</label>
					<select name="place_id" id="place_id" class="group__input" required></select>
				</div>

				<div class="form__group">
					<label for="course_id" class="group__label">Matière :</label>
					<select name="course_id" id="course_id" class="group__input" required></select>
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
					<label for="schedule_day" class="group__label">Jour :</label>
					<input type="text" name="schedule_day" placeholder="Jour" id="schedule_day" class="group__input" required />
				</div>

				<div class="form__group">
					<label for="schedule_start_time" class="group__label">Heure de début :</label>
					<input type="time" name="schedule_start_time" id="schedule_start_time" class="group__input" required />
				</div>

				<div class="form__group">
					<label for="schedule_end_time" class="group__label">Heure de fin :</label>
					<input type="time" name="schedule_end_time" id="schedule_end_time" class="group__input" required />
				</div>

				<div class="form__group">
					<button type="submit" class="group__button">Créer</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>