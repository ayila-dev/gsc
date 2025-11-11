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
				<select name="schooling_id" id="schooling_id" class="group__input" required></select>
			</div>

			<!-- ✅ Champs des tranches (cachés par défaut) -->
			<div id="tranches-container" style="display:none; margin-top:1rem;">
				<h3 style="margin-bottom:8px;">Tranches de paiement :</h3>

				<div class="form__group">
					<label for="tranche1" class="group__label">Tranche 1 :</label>
					<input type="number" step="0.01" name="tranche1" id="tranche1" class="group__input" placeholder="Montant tranche 1">
				</div>

				<div class="form__group">
					<label for="tranche2" class="group__label">Tranche 2 :</label>
					<input type="number" step="0.01" name="tranche2" id="tranche2" class="group__input" placeholder="Montant tranche 2">
				</div>

				<div class="form__group">
					<label for="tranche3" class="group__label">Tranche 3 :</label>
					<input type="number" step="0.01" name="tranche3" id="tranche3" class="group__input" placeholder="Montant tranche 3">
				</div>
			</div>

			<div class="form__group">
				<label for="level_id" class="group__label">Classe : </label>
				<select name="level_id" id="level_id" class="group__input" required></select>
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
