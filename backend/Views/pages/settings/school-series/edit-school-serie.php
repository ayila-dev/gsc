<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>
	
	<div class="main-panel">

		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Modifier une série</h1>
				<a href="list-school-serie.php" class="btn__add" title="Liste des séries">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="edit-serie-form">

				<div class="form__group">
					<label for="serie_id" class="group__label">Série : </label>
					<input type="hidden" name="serie_id" placeholder="Série" id="serie_id"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="serie_name" class="group__label">Série : </label>
					<input type="text" name="serie_name" placeholder="Série" id="serie_name"
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