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
				<tbody class="list__body">
					<tr class="list__row">
						<td class="list__row-item">1</td>
						<td class="list__row-item">EDCGSC0001</td>
						<td class="list__row-item">BOURAIMA</td>
						<td class="list__row-item">Mouksite</td>
						<td class="list__row-item">2nde</td>
						<td class="list__row-item">D</td>
						<td class="list__row-item">Maths</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">12.5</td>
						<td class="list__row-item">08</td>
						<td class="list__row-item">10.33</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">10.11</td>
						<td class="list__row-item">30.33</td>
						<td class="list__row-item">
							<button type="button" class="edit-grade">Éditer</button>
						</td>
					</tr>
					<tr class="list__row">
						<td class="list__row-item">2</td>
						<td class="list__row-item">EDCGSC0002</td>
						<td class="list__row-item">AKIOLE</td>
						<td class="list__row-item">Chancelle</td>
						<td class="list__row-item">2nde</td>
						<td class="list__row-item">D</td>
						<td class="list__row-item">Maths</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">12.5</td>
						<td class="list__row-item">08</td>
						<td class="list__row-item">10.33</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">10.11</td>
						<td class="list__row-item">30.33</td>
						<td class="list__row-item">
							<button type="button" class="edit-grade">Éditer</button>
						</td>
					</tr>
					<tr class="list__row">
						<td class="list__row-item">3</td>
						<td class="list__row-item">EDCGSC0003</td>
						<td class="list__row-item">DOSSOU</td>
						<td class="list__row-item">Rolande</td>
						<td class="list__row-item">2nde</td>
						<td class="list__row-item">D</td>
						<td class="list__row-item">Maths</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">12.5</td>
						<td class="list__row-item">08</td>
						<td class="list__row-item">10.33</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">10</td>
						<td class="list__row-item">10.11</td>
						<td class="list__row-item">30.33</td>
						<td class="list__row-item">
							<button type="button" class="edit-grade">Éditer</button>
						</td>
					</tr>
				</tbody>
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