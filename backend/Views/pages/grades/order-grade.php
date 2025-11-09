<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">

		<h1 class="grade__title">Demande d'ajout des notes</h1>

		<div class="form-formalities">

			<form action="" class="form__i">

				<h1 class="form__title">Interrogations</h1>

				<div class="form__group">
					<label for="school-grade" class="group__label">Classe : </label>
					<select name="school-grade" id="school-grade" class="group__input">
						<option value="Classe" disabled selected>Classe</option>
						<option value="6ème">6ème</option>
						<option value="5ème">5ème</option>
						<option value="4ème">4ème</option>
						<option value="3ème">3ème</option>
					</select>
				</div>

				<div class="form__group">
					<label for="level-interrogation" class="group__label">Niveau : </label>
					<select name="level-interrogation" id="level-interrogation" class="group__input">
						<option value="Niveau" disabled selected>Niveau</option>
						<option value="I1">I1</option>
						<option value="I2">I2</option>
						<option value="I3">I3</option>
					</select>
				</div>

				<div class="form__group">
					<button type="submit" name="signup" class="group__button">Édition</button>
				</div>

			</form>

			<form action="" class="form__d">

				<h1 class="form__title">Devoirs</h1>

				<div class="form__group">
					<label for="school-grade" class="group__label">Classe : </label>
					<select name="school-grade" id="school-grade" class="group__input">
						<option value="Classe" disabled selected>Classe</option>
						<option value="6ème">6ème</option>
						<option value="5ème">5ème</option>
						<option value="4ème">4ème</option>
						<option value="3ème">3ème</option>
					</select>
				</div>

				<div class="form__group">
					<label for="level-duty" class="group__label">Niveau : </label>
					<select name="level-duty" id="level-duty" class="group__input">
						<option value="Niveau" disabled selected>Niveau</option>
						<option value="I1">D1</option>
						<option value="I2">D2</option>
					</select>
				</div>

				<div class="form__group">
					<button type="submit" name="signup" class="group__button">Édition</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>