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
						<option value="6ème">6ème</option>
						<option value="5ème">5ème</option>
						<option value="4ème">4ème</option>
						<option value="3ème">3ème</option>
					</select>
				</div>

				<div class="form__group">
					<label for="serie" class="group__label">Série : </label>
					<select name="serie" id="serie" class="group__input">
						<option value="Série" disabled selected>Série</option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
					</select>
				</div>

				<div class="form__group">
					<label for="matricule" class="group__label">Numéro matricule : </label>
					<input type="text" name="matricule" placeholder="Matricule" id="matricule"
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
						<th class="list__row-item">Tél.Parent</th>
						<th class="list__row-item">Montant.Payé</th>
						<th class="list__row-item">Montant.Dû</th>
						<th class="list__row-item">Date.Payement</th>
						<th class="list__row-item">Statut</th>
						<th class="list__row-item" colspan="2">Action</th>
					</tr>
				</thead>
				<tbody class="list__body">
					<tr class="list__row">
						<td class="list__row-item">1</td>
						<td class="list__row-item">EDCGSC0001</td>
						<td class="list__row-item">BOURAIMA</td>
						<td class="list__row-item">Mouksite</td>
						<td class="list__row-item">2nde</td>
						<td class="list__row-item">D</td>
						<td class="list__row-item">0144781021</td>
						<td class="list__row-item">165000</td>
						<td class="list__row-item">20000</td>
						<td class="list__row-item">10-02-2025</td>
						<td class="list__row-item">En cours...</td>
						<td class="list__row-item">
							<a href="edit-scolarity.php" class="list__btn btn-edit">Payer</a>
						</td>
					</tr>
					<tr class="list__row">
						<td class="list__row-item">2</td>
						<td class="list__row-item">EDCGSC0002</td>
						<td class="list__row-item">AKIOLE</td>
						<td class="list__row-item">Chancelle</td>
						<td class="list__row-item">2nde</td>
						<td class="list__row-item">D</td>
						<td class="list__row-item">0144781021</td>
						<td class="list__row-item">185000</td>
						<td class="list__row-item">000000</td>
						<td class="list__row-item">08-08-2025</td>
						<td class="list__row-item">Soldé</td>
						<td class="list__row-item">
							<a href="edit-scolarity.php" class="list__btn btn-edit">Payer</a>
						</td>
					</tr>
					<tr class="list__row">
						<td class="list__row-item">3</td>
						<td class="list__row-item">EDCGSC0003</td>
						<td class="list__row-item">DOSSOU</td>
						<td class="list__row-item">Rolande</td>
						<td class="list__row-item">2nde</td>
						<td class="list__row-item">D</td>
						<td class="list__row-item">0144781021</td>
						<td class="list__row-item">143000</td>
						<td class="list__row-item">42000</td>
						<td class="list__row-item">11-09-2025</td>
						<td class="list__row-item">En cours...</td>
						<td class="list__row-item">
							<a href="edit-scolarity.php" class="list__btn btn-edit">Payer</a>
						</td>
					</tr>
				</tbody>
				<tfoot class="list__footer">
					<tr class="list__row">
						<th class="list__row-item">Total</th>
						<th class="list__row-item" colspan="11">3 scolarités enregistrés</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>