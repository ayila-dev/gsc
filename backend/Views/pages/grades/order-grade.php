<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">

		<div class="form-formalities">

			<form action="" method="POST" class="form__type_grade">

				<h1 class="form__title">Ajouter les notes d'évaluations</h1>

				<div class="form__group">
					<label for="type_grade" class="group__label">Type d'évaluation :</label>
					<select name="type_grade" id="type_grade" class="group__input" required>
						<option value="" disabled selected>Choisir un type d'évaluation</option>

						<optgroup label="Interrogations">
							<option value="interro1">Interrogation 1</option>
							<option value="interro2">Interrogation 2</option>
							<option value="interro3">Interrogation 3</option>
						</optgroup>

						<optgroup label="Devoirs">
							<option value="devoir1">Devoir 1</option>
							<option value="devoir2">Devoir 2</option>
						</optgroup>
					</select>
				</div>

				<div class="form__group">
					<button type="submit" name="edit_grade" class="group__button">
						Ajouter les notes
					</button>
				</div>

			</form>

		</div>

		<h2 class="list__title">Liste des élèves</h2>
		<div class="list-container">
			<table class="list">
				<thead class="list__header">
					<tr class="list__row">
						<th class="list__row-item">N°</th>
						<th class="list__row-item">Matricule</th>
						<th class="list__row-item">Nom</th>
						<th class="list__row-item">Prénom(s)</th>
						<th class="list__row-item">Notes</th>
						<th class="list__row-item">Date.Ajout</th>
						<th class="list__row-item" colspan="2">Action</th>
					</tr>
				</thead>

				<tbody class="list__body"></tbody>

				<tfoot class="list__footer">
					<tr class="list__row">
						<th class="list__row-item">Total</th>
						<th class="list__row-item" colspan="11"></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>