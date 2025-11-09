<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>
	
	<div class="main-panel">
		
		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Ajouter un type scolarité</h1>
				<a href="list-schooling.php" class="btn__add" title="Liste des types de scolarités">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="add-schooling-form">

				<div class="form__group">
					<label for="schooling_name" class="group__label">type de scolarité : </label>
					<input type="text" name="schooling_name" placeholder="type de scolarité"
						id="schooling_name" class="group__input" required />
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