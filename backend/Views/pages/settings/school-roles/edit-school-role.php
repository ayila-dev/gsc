<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>
	
	<div class="main-panel">

		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Modifier un rôle</h1>
				<a href="list-school-role.php" class="btn__add" title="Liste des rôles">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="edit-role-form">

				<div class="form__group">
					<label for="role_id" class="group__label">Rôle : </label>
					<input type="hidden" name="role_id" placeholder="Rôle" id="role_id" class="group__input"
						required />
				</div>

				<div class="form__group">
					<label for="role_name" class="group__label">Rôle : </label>
					<input type="text" name="role_name" placeholder="Rôle" id="role_name" class="group__input"
						required />
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