<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

	<div class="main-panel">

		<div class="main__header">
			<h1 class="form__title">Modifier un droit d'accès</h1>
			<a href="list-school-access.php" class="btn__add" title="Liste des droits">&#8801;</a>
		</div>

		<div class="form-container">
			
			<form action="" method="POST" class="form__body" id="edit-access-form">

				<div class="form__group">
					<label for="access_id" class="group__label">ID : </label>
					<input type="hidden" name="access_id" placeholder="ID du droit" id="access_id"
						class="group__input" required />
					<!-- nouveau : id de la relation roles_access -->
					<input type="hidden" name="role_access_id" id="role_access_id" class="group__input" />
				</div>
				
				<div class="form__group">
					<label for="access_id" class="group__label">ID : </label>
					<input type="hidden" name="access_id" placeholder="ID du droit" id="access_id"
						class="group__input" required />
				</div>

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
					<button type="submit" name="edit" class="group__button">Édition</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../../partials/footer.php";
?>