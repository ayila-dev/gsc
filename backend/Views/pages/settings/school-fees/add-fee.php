<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

<div class="main-panel">

		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Ajouter un frais de scolarité</h1>
				<a href="list-fee.php" class="btn__add" title="Liste des frais de scolarité">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="add-fee-form">

				<div class="form__group">
					<label for="fee_amount" class="group__label">Frais : </label>
					<input type="number" name="fee_amount" placeholder="Montant" id="fee_amount"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="schooling_id" class="group__label">Type de scolarité : </label>
					<select name="schooling_id" id="schooling_id" class="group__input">
						<option value="Type de scolarité" disabled selected>Type de scolarité</option>
					</select>
				</div>

				<div class="form__group">
					<label for="level_id" class="group__label">Classe : </label>
					<select name="level_id" id="level_id" class="group__input">
						<option value="Classe" disabled selected>Classe</option>
					</select>
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