<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>
	
	<div class="main-panel">

		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Ajouter une salle</h1>
				<a href="list-school-room.php" class="btn__add" title="Liste des salles">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="add-room-form">

				<div class="form__group">
					<label for="room_name" class="group__label">Nom de la salle : </label>
					<input type="text" name="room_name" placeholder="Nom de la salle" id="room_name"
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