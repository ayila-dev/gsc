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
					<table class="student__infos">
						<tr class="infosline">
							<th class="infos">Matruicule : </th>
							<td class="infos">EDGSC2025/00015</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Nom : </th>
							<td class="infos">BOURAIMA</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Prénom(s) : </th>
							<td class="infos">Ayila Fructueux Mouksite</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Montant Payé : </th>
							<td class="infos text-success">145000 FCFA</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Montant Dû : </th>
							<td class="infos text-danger">40000 FCFA</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Statut : </th>
							<td class="infos text-warning">En cours...</td>
						</tr>
					</table>
				</div>
				<form action="" class="form__body">
					<div class="form__group">
						<label for="tranches" class="group__label">Tranches : </label>
						<select name="tranches" id="tranches" class="group__input" required>
							<option disabled selected>Tranches</option>
							<option value="95000">1ère tranche............95000</option>
							<option value="50000">2ème tranche............50000</option>
							<option value="40000">3ème tranche............40000</option>
							<option value="Autre montant">Autre montant</option>
						</select>
					</div>

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