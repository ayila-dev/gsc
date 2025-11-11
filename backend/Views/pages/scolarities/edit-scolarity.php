<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">
		<div class="editor-scolarity">
			<div class="form-container">
				<h1 class="form__title">Paiement de scolarité</h1>

				<div class="form__header">
					<table class="student__infos"></table>
				</div>

				<form method="POST" class="form__body" id="form-payement">

					<div class="form__group field-hidden">
						<label for="student_id" class="group__label">ID élève : </label>
						<input type="text" name="student_id" placeholder="ID élève" id="student_id" class="group__input" required />
					</div>

					<div class="form__group field-hidden">
						<label for="schooling_id" class="group__label">ID scolarité : </label>
						<input type="text" name="schooling_id" placeholder="ID scolarité" id="schooling_id" class="group__input" required />
					</div>

					<div class="form__group field-hidden">
						<label for="payement_mode" class="group__label">Mode de paiement : </label>
						<input type="text" name="payement_mode" placeholder="Mode de paiement" id="payement_mode" class="group__input" value="Espèces" required />
					</div>

					<div class="form__group">
						<label for="tranches" class="group__label">Tranches : </label>
						<select name="tranches" id="tranches" class="group__input" required></select>
					</div>

					<!-- Afficher si la sélection est "Autre montant" -->
					<div class="form__group custom-amount" id="custom-amount">
						<label for="other-amount" class="group__label">Montant : </label>
						<input type="number" name="other-amount" placeholder="Montant" id="other-amount"
							class="group__input" required />
					</div>

					<div class="form__group">
						<button type="submit" name="signup" class="group__button">Paiement</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>