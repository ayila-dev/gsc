document.addEventListener("DOMContentLoaded", () => {
	// Récupération des données dans l’URL
	const params = new URLSearchParams(window.location.search);
	const data = {
		nom: params.get("nom") || "—",
		matricule: params.get("matricule") || "—",
		classe: params.get("classe") || "—",
		annee: params.get("annee") || "_",
		parent: params.get("parent") || "—",
		tranche: params.get("tranche") || "—",
		montant: params.get("montant") || "—",
		reste: params.get("reste") || "—",
		mode: params.get("mode") || "Espèces",
		statut: params.get("statut") || "En cours...",
		total: params.get("total") || "—",
		paye: params.get("paye") || "—",
		solde: params.get("solde") || "—",
	};

	// Injection dans le HTML
	for (const key in data) {
		const el = document.getElementById(key);
		if (el) el.textContent = data[key];
	}

	// Ajouter les suffixes FCFA
	["montant", "reste", "total", "paye", "solde"].forEach((id) => {
		const el = document.getElementById(id);
		if (el && data[id] !== "—") el.textContent += " FCFA";
	});

	// Gérer la couleur du statut
	const statutEl = document.getElementById("statut");
	if (statutEl) {
		statutEl.classList.remove("encours", "success", "danger");
		if (data.statut.toLowerCase().includes("soldé"))
			statutEl.classList.add("solde");
		else if (data.statut.toLowerCase().includes("Non payé"))
			statutEl.classList.add("nonpaye");
		else statutEl.classList.add("encours");
	}

	// Numéro et date de reçu
	const receiptNumber = `N° R-${new Date().getFullYear()}-${Math.floor(
		Math.random() * 10000
	)
		.toString()
		.padStart(4, "0")}`;
	document.querySelector(
		".receipt-number"
	).textContent = `${receiptNumber} | Délivré le ${new Date().toLocaleDateString(
		"fr-FR"
	)}`;

	// ====================================================
	// Génération du reçu de paiement en PDF avec html2pdf
	// ====================================================
	const pdfButton = document.getElementById("download-pdf");
	if (pdfButton) {
		pdfButton.addEventListener("click", () => {
			const element = document.getElementById("receipt");
			const opt = {
				margin: 0.3,
				filename: `Reçu_De_Paiement_De_Scolarité_${new Date()
					.toISOString()
					.slice(0, 10)}.pdf`,
				image: { type: "jpeg", quality: 0.98 },
				html2canvas: {
					scale: 2,
					useCORS: true, // permet d’inclure les images externes
					scrollY: 0,
					scrollX: -8,
					backgroundColor: "#ffffff",
				},
				jsPDF: {
					unit: "mm",
					format: "a4",
					orientation: "portrait",
				},
				pagebreak: { mode: ["avoid-all"] },
			};
			html2pdf().set(opt).from(element).save();
		});
	}
});

/* document.addEventListener("DOMContentLoaded", () => {
	const params = new URLSearchParams(window.location.search);

	// Données dynamiques
	const data = {
		nom: params.get("nom") || "—",
		matricule: params.get("matricule") || "—",
		classe: params.get("classe") || "—",
		annee:
			params.get("annee") || sessionStorage.getItem("year_name") || "—",
		parent: params.get("parent") || "—",
		tranche: params.get("tranche") || "—",
		montant: params.get("montant") || "—",
		reste: params.get("reste") || "—",
		mode: params.get("mode") || "Espèces",
		statut: params.get("statut") || "En cours...",
		total: params.get("total") || "—",
		paye: params.get("paye") || "—",
		solde: params.get("solde") || "—",
	};

	// Injection dans le HTML
	for (const key in data) {
		const el = document.getElementById(key);
		if (el) el.textContent = data[key];
	}

	// Ajouter les suffixes FCFA
	["montant", "reste", "total", "paye", "solde"].forEach((id) => {
		const el = document.getElementById(id);
		if (el && data[id] !== "—") el.textContent += " FCFA";
	});

	// Couleur du statut
	const statutEl = document.getElementById("statut");
	if (statutEl) {
		statutEl.classList.remove("encours", "solde", "nonpaye");
		if (data.statut.toLowerCase().includes("soldé"))
			statutEl.classList.add("solde");
		else if (data.statut.toLowerCase().includes("non payé"))
			statutEl.classList.add("nonpaye");
		else statutEl.classList.add("encours");
	}

	// Numéro et date de reçu
	const receiptNumber = `N° R-${new Date().getFullYear()}-${Math.floor(
		Math.random() * 10000
	)
		.toString()
		.padStart(4, "0")}`;
	const receiptDate = new Date().toLocaleDateString("fr-FR");
	const receiptEl = document.getElementById("receipt-number");
	if (receiptEl)
		receiptEl.textContent = `${receiptNumber} | Délivré le ${receiptDate}`;

	// Génération PDF
	const pdfButton = document.getElementById("download-pdf");
	if (pdfButton) {
		pdfButton.addEventListener("click", () => {
			const element = document.getElementById("receipt");
			html2pdf()
				.set({
					margin: 0.3,
					filename: `Reçu_De_Paiement_${new Date()
						.toISOString()
						.slice(0, 10)}.pdf`,
					image: { type: "jpeg", quality: 0.98 },
					html2canvas: {
						scale: 2,
						useCORS: true,
						scrollY: 0,
						scrollX: -8,
						backgroundColor: "#ffffff",
					},
					jsPDF: {
						unit: "mm",
						format: "a4",
						orientation: "portrait",
					},
					pagebreak: { mode: ["avoid-all"] },
				})
				.from(element)
				.save();
		});
	}
}); */
