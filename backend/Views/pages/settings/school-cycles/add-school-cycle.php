<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

	<div class="main-panel">

		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Ajouter un cycle</h1>
				<a href="list-school-cycle.php" class="btn__add" title="Liste des cycles">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="add-cycle-form">

				<div class="form__group">
					<label for="cycle_name" class="group__label">Cycle : </label>
					<input type="text" name="cycle_name" placeholder="Cycle" id="cycle_name"
						class="group__input" required />
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