<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

	<div class="main-panel">
		
		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Modifier une classe</h1>
				<a href="list-school-grade.php" class="btn__add" title="Liste des classes">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="edit-level-form">

				<div class="form__group">
					<label for="level_id" class="group__label">Classe : </label>
					<input type="hidden" name="level_id" placeholder="Classe" id="level_id"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="level_name" class="group__label">Classe : </label>
					<input type="text" name="level_name" placeholder="Classe" id="level_name"
						class="group__input" required />
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