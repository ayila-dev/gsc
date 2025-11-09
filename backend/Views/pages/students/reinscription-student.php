<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once "../checkLogin.php";
	include_once "../../partials/header.php";
?>

	<div class="main-panel">
		<div class="form-container">

			<div class="form__header">
				<h1 class="form__title">Reinscrire un élève</h1>
			</div>

			<form method="POST" class="form__body" id="reinscription-student-form">

				<div class="form__group">
					<label for="student_id" class="group__label">ID :</label>
					<input type="text" name="student_id" placeholder="ID" id="student_id" class="group__input field-hidden" required />
				</div>

				<div class="form__group">
					<label for="place_id" class="group__label">Centre : </label>
					<select name="place_id" id="place_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<label for="level_id" class="group__label">Classe : </label>
					<select name="level_id" id="level_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<label for="serie_id" class="group__label">Série : </label>
					<select name="serie_id" id="serie_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<label for="room_id" class="group__label">Salle : </label>
					<select name="room_id" id="room_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<button type="submit" name="signup" class="group__button">Reinscription</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once "../../partials/footer.php";
?>