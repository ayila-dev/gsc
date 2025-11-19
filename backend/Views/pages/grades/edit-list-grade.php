<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">
		<h2 class="list__title">Éditer & consulter les notes</h2>

		<div class="form-filter-container">

			<form action="" class="form__body">
				<div class="form__group">
					<label for="matricule" class="group__label">Numéro matricule : </label>
					<input type="matricule" name="matricule" placeholder="Matricule" id="matricule"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="lastname" class="group__label">Nom : </label>
					<input type="text" name="lastname" placeholder="Nom" id="lastname"
						class="group__input lastname" required />
				</div>

				<div class="form__group">
					<label for="firstname" class="group__label">Prénom : </label>
					<input type="text" name="firstname" placeholder="Prénom" id="firstname"
						class="group__input firstname" required />
				</div>
			</form>

		</div>

		<form class="list-container">
			<table class="list">
				<thead class="list__header">
					<tr class="list__row">
						<th class="list__row-item">N°</th>
						<th class="list__row-item">Matricule</th>
						<th class="list__row-item">Nom</th>
						<th class="list__row-item">Prénom(s)</th>
						<th class="list__row-item">Classe</th>
						<th class="list__row-item">Série</th>
						<th class="list__row-item">Matière</th>
						<th class="list__row-item">Période</th>
						<th class="list__row-item">I1</th>
						<th class="list__row-item">I2</th>
						<th class="list__row-item">I3</th>
						<th class="list__row-item">MI</th>
						<th class="list__row-item">D1</th>
						<th class="list__row-item">D2</th>
						<th class="list__row-item">MG</th>
						<th class="list__row-item">MC</th>
						<th class="list__row-item" colspan="2">Action</th>
					</tr>
				</thead>

				<tbody class="list__body"></tbody>
				
				<tfoot class="list__footer">
					<tr class="list__row">
						<th class="list__row-item">Total</th>
						<th class="list__row-item" colspan="16"></th>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>