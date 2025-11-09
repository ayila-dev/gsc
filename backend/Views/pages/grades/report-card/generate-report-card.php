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

			<form action="" class="form__body" id="studentForm" method="POST">

				<div class="form__group">
					<label for="level" class="group__label">Classe : </label>
					<select name="level" id="level" class="group__input">
						<option value="Classe" disabled selected>Classe</option>
						<option value="6ème">6ème</option>
						<option value="5ème">5ème</option>
						<option value="4ème">4ème</option>
						<option value="3ème">3ème</option>
						<option value="2nde">2nde</option>
						<option value="1ère">1ère</option>
						<option value="Tle">Tle</option>
					</select>
				</div>

				<div class="form__group">
					<label for="serie" class="group__label">Série : </label>
					<select name="serie" id="serie" class="group__input">
						<option value="Série" disabled selected>Série</option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
						<option value="Néant">Néant</option>
					</select>
				</div>

				<div class="form__group">
					<button type="submit" name="signup" class="group__button">Génération</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../../partials/footer.php";
?>