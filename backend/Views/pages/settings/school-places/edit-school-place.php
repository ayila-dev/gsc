<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>
	
	<div class="main-panel">
		
		<div class="form-container">
			
			<div class="main__header">
				<h1 class="form__title">Modifier un centre</h1>
				<a href="list-school-place.php" class="btn__add" title="Liste des centres">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="edit-place-form">

				<div class="form__group">
					<label for="place_id" class="group__label">ID : </label>
					<input type="hidden" name="place_id" placeholder="ID du centre" id="place_id"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="place_name" class="group__label">Centre : </label>
					<input type="text" name="place_name" placeholder="Centre" id="place_name"
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