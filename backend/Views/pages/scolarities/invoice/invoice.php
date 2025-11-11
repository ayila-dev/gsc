<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Reçu de paiement de scolarité</title>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
		<link
			rel="stylesheet"
			href="../../../../../public/assets/css/invoice.css"
		/>
		<script defer src="../../../../../public/assets/js/invoice.js"></script>
	</head>
	<body>
		<!-- ====== REÇU ====== -->
		<div id="receipt" class="receipt">
			<header>
				<div class="school">
					<h2>ÉCOLE GSC</h2>
					<p>Rue des Écoles – Ville<br />Tél : 01 23 45 67 89</p>
				</div>
				<img
					src="../../../../../public/assets/images/gsc-logo.png"
					alt="Logo"
				/>
			</header>

			<h1 class="title">Reçu de paiement de scolarité</h1>
			<div class="receipt-number">N° R-2025-004 | Délivré le .....</div>

			<table class="info-table">
				<tr>
					<th>Nom de l’élève :</th>
					<td><span id="nom">.....</span></td>
				</tr>
				<tr>
					<th>Matricule :</th>
					<td><span id="matricule">.....</span></td>
				</tr>
				<tr>
					<th>Classe :</th>
					<td><span id="classe">.....</span></td>
				</tr>
				<tr>
					<th>Année académique :</th>
					<td><span id="annee">.....</span></td>
				</tr>
				<tr>
					<th>Parent :</th>
					<td><span id="parent">Tel......</span></td>
				</tr>
			</table>

			<hr />

			<table class="summary-table">
				<tr>
					<th>Tranche payée :</th>
					<td><span id="tranche">.....</span></td>
				</tr>
				<tr>
					<th>Montant payé :</th>
					<td><strong id="montant">.....</strong></td>
				</tr>
				<tr>
					<th>Montant restant dû :</th>
					<td><span id="reste">.....</span></td>
				</tr>
				<tr>
					<th>Mode de paiement :</th>
					<td><span id="mode">.....</span></td>
				</tr>
				<tr>
					<th>Statut du paiement :</th>
					<td>
						<span class="status encours" id="statut">.....</span>
					</td>
				</tr>
			</table>

			<div class="summary">
				<p>
					<strong>Montant total dû :</strong>
					<span id="total">.....</span>
				</p>
				<p>
					<strong>Total payé à ce jour :</strong>
					<span id="paye">.....</span>
				</p>
				<p>
					<strong>Solde restant :</strong>
					<span id="solde">.....</span>
				</p>
			</div>

			<div class="signature">
				<div>
					<p>Signature du parent</p>
					<br /><br />____________________
				</div>
				<div>
					<p>Signature du caissier</p>
					<br /><br />____________________
				</div>
			</div>

			<footer>
				Ce reçu atteste le paiement partiel ou total des frais de
				scolarité.<br />
				À conserver soigneusement.
			</footer>
		</div>

		<!-- ====== BOUTON DE TÉLÉCHARGEMENT ====== -->
		<div class="pdf-controls" style="text-align: center; margin: 30px 0">
			<button id="download-pdf" class="no-print">
				<i>📄</i> Télécharger en PDF
			</button>
		</div>
	</body>
</html>
