<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">
		<h2 class="list__title">Ajouter les notes la [Classe - Série]</h2>
		<form class="list-container">
			<table class="list">
				<thead class="list__header">
					<tr class="list__row">
						<th class="list__row-item">N°</th>
						<th class="list__row-item">Matricule</th>
						<th class="list__row-item">Nom</th>
						<th class="list__row-item">Prénom(s)</th>
						<th class="list__row-item">I1</th>
					</tr>
				</thead>
				<tbody class="list__body">
					<tr class="list__row">
						<td class="list__row-item">1</td>
						<td class="list__row-item">EDCGSC0001</td>
						<td class="list__row-item">BOURAIMA</td>
						<td class="list__row-item">Mouksite</td>
						<td class="list__row-item">
							<input type="number" name="grade" placeholder="Note sur 20" class="group__input"
								required />
						</td>
					</tr>
					<tr class="list__row">
						<td class="list__row-item">2</td>
						<td class="list__row-item">EDCGSC0002</td>
						<td class="list__row-item">AKIOLE</td>
						<td class="list__row-item">Chancelle</td>
						<td class="list__row-item">
							<input type="number" name="grade" placeholder="Note sur 20" class="group__input"
								required />
						</td>
					</tr>
					<tr class="list__row">
						<td class="list__row-item">3</td>
						<td class="list__row-item">EDCGSC0003</td>
						<td class="list__row-item">DOSSOU</td>
						<td class="list__row-item">Rolande</td>
						<td class="list__row-item">
							<input type="number" name="grade" placeholder="Note sur 20" class="group__input"
								required />
						</td>
					</tr>
					<tr class="">
						<td class="list__row-item" colspan="13">
							<button type="submit" name="signup" class="group__button">Validation</button>
						</td>
					</tr>
				</tbody>
				<tfoot class="list__footer">
					<tr class="list__row">
						<th class="list__row-item">Total</th>
						<th class="list__row-item" colspan="16">3 notes à enregistrés</th>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>