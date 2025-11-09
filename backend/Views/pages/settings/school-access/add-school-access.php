<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

	<div class="main-panel">

		<div class="main__header">
			<h1 class="form__title">Ajouter un droit d'accès</h1>
			<a href="list-school-access.php" class="btn__add" title="Liste des droits">&#8801;</a>
		</div>

		<div class="form-container">
			
			<form action="" method="POST" class="form__body" id="add-access-form">

				<div class="form__group">
					<label for="access_name" class="group__label">Droit : </label>
					<input type="text" name="access_name" placeholder="Entrez le droit ici" id="access_name"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="access_section" class="group__label">Section : </label>
					<input type="text" name="access_section" placeholder="Ex: teachers, grades, settings..." id="access_section"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="role_id" class="group__label">Rôle associé : </label>
					<select name="role_id" id="role_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<button type="submit" name="add" class="group__button">Création</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../../partials/footer.php";
?>