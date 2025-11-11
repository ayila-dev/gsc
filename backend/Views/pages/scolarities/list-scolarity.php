<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">
		<h2 class="list__title">Liste de paiement des élèves</h2>

		<div class="form-filter-container">

			<form action="" class="form__body">

				<div class="form__group">
					<label for="school-grade" class="group__label">Classe : </label>
					<select name="school-grade" id="school-grade" class="group__input">
						<option value="Classe" disabled selected>Classe</option>
					</select>
				</div>

				<div class="form__group">
					<label for="serie" class="group__label">Série : </label>
					<select name="serie" id="serie" class="group__input">
						<option value="Série" disabled selected>Série</option>
					</select>
				</div>

				<div class="form__group">
					<label for="room" class="group__label">Salle : </label>
					<select name="room" id="room" class="group__input">
						<option value="Salle" disabled selected>Salle</option>
					</select>
				</div>

				<div class="form__group">
					<label for="matricule" class="group__label">Numéro matricule : </label>
					<input type="text" name="matricule" placeholder="Matricule ou Nom ou Prénom" id="matricule"
						class="group__input" required />
				</div>
			</form>

		</div>

		<div class="list-container">
			<table class="list">
				<thead class="list__header">
					<tr class="list__row">
						<th class="list__row-item">N°</th>
						<th class="list__row-item">Matricule</th>
						<th class="list__row-item">Nom</th>
						<th class="list__row-item">Prénom(s)</th>
						<th class="list__row-item">Classe</th>
						<th class="list__row-item">Série</th>
						<th class="list__row-item">Salle</th>
						<th class="list__row-item">Année</th>
						<th class="list__row-item">Tél.Parent</th>
						<th class="list__row-item">Montant.Payé</th>
						<th class="list__row-item">Montant.Dû</th>
						<th class="list__row-item">Date.Payement</th>
						<th class="list__row-item">Statut</th>
						<th class="list__row-item" colspan="3">Action</th>
					</tr>
				</thead>

				<tbody class="list__body"></tbody>

				<tfoot class="list__footer">
					<tr class="list__row">
						<th class="list__row-item">Total</th>
						<th class="list__row-item" colspan="15"></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>