<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">

		<div class="form-formalities">

			<form method="POST" class="list-container form__type_grade" id="add-grade-form">

				<h1 class="form__title">Ajouter les notes d'évaluations</h1>

				<div class="form__group">
					<label for="grade_period" class="group__label">Période d'évaluation :</label>
					<select name="grade_period" id="grade_period" class="group__input" required>
						<option value="" disabled selected>Choisir une période d'évaluation</option>

						<optgroup label="Trimestre">
							<option value="t1">Trimestre 1</option>
							<option value="t2">Trimestre 2</option>
							<option value="t3">Trimestre 3</option>
						</optgroup>

						<optgroup label="Semestre">
							<option value="s1">Semestre 1</option>
							<option value="s2">Semestre 2</option>
						</optgroup>
					</select>
				</div>

				<div class="form__group">
					<label for="grade_type" class="group__label">Type d'évaluation :</label>
					<select name="grade_type" id="grade_type" class="group__input" required>
						<option value="" disabled selected>Choisir un type d'évaluation</option>

						<optgroup label="Interrogations">
							<option value="i1">Interrogation 1</option>
							<option value="i2">Interrogation 2</option>
							<option value="i3">Interrogation 3</option>
						</optgroup>

						<optgroup label="Devoirs">
							<option value="d1">Devoir 1</option>
							<option value="d2">Devoir 2</option>
						</optgroup>
					</select>
				</div>

				<table class="list">
					<thead class="list__header">
						<tr class="list__row">
							<th class="list__row-item">Matricule</th>
							<th class="list__row-item">Nom</th>
							<th class="list__row-item">Prénom(s)</th>
							<th class="list__row-item">Notes sur 20</th>
						</tr>
					</thead>

					<tbody class="list__body"></tbody>

					<tfoot class="list__footer">
						<tr class="list__row">
							<th class="list__row-item">Total</th>
							<th class="list__row-item" colspan="16">3 notes à enregistrés</th>
						</tr>
					</tfoot>
				</table>
			</form>
		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>