<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>
	
	<div class="main-panel">

		<div class="main__header">
			<h2 class="list__title">Liste des séries</h2>
			<a href="add-school-serie.php" class="btn__add" title="Ajouter une série">+</a>
		</div>
		
		<div class="list-container">

			<table class="list">
				<thead class="list__header">
					<tr class="list__row">
						<th class="list__row-item">N°</th>
						<th class="list__row-item">Séries</th>
						<th class="list__row-item">Date.Ajout</th>
						<th class="list__row-item" colspan="2">Action</th>
					</tr>
				</thead>
				
				<tbody class="list__body"></tbody>

				<tfoot class="list__footer">
					<tr class="list__row">
						<th class="list__row-item">Total</th>
						<th class="list__row-item" colspan="13"></th>
					</tr>
				</tfoot>
			</table>
			
		</div>
	</div>

<?php
	include_once __DIR__ . "/../../../partials/footer.php";
?>