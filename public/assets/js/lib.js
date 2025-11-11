export const currentLinkSidebar = () => {
	const links = document.querySelectorAll(
		".subnavigation__subnavigation-item, .subnavigation-item"
	);
	if (!links || links.length === 0) return;

	const normalize = (p) => p.replace(/\/+$/, ""); // retire slash final
	const currentPath = normalize(window.location.pathname);

	// marque et nettoie les liens
	let matched = false;
	links.forEach((a) => {
		const href = a.getAttribute("href") || "";
		try {
			const url = new URL(href, window.location.origin);
			const linkPath = normalize(url.pathname);
			if (linkPath === currentPath) {
				a.classList.add("current");
				a.style.color = "#000";
				matched = true;
			} else {
				a.classList.remove("current");
				a.style.color = "";
			}
		} catch (e) {
			// ignore malformed href
		}
	});

	// fallback : comparer par nom de fichier (dernier segment)
	if (!matched) {
		const curFile = currentPath.split("/").filter(Boolean).pop() || "";
		if (curFile) {
			links.forEach((a) => {
				const href = a.getAttribute("href") || "";
				const last = href.split("/").filter(Boolean).pop() || "";
				if (last === curFile) {
					a.classList.add("current");
					a.style.color = "#000";
				} else {
					// ne pas écraser si déjà mis par une condition précédente
					if (!a.classList.contains("current")) {
						a.classList.remove("current");
						a.style.color = "";
					}
				}
			});
		}
	}
};

export const showCustomFieldAmount = () => {
	const tranchesField = document.getElementById("tranches");
	const customAmountField = document.getElementById("custom-amount");
	const inputAmount = customAmountField.querySelector(
		'input[name="other-amount"]'
	);

	// Au chargement, cacher le champ et retirer required
	customAmountField.style.display = "none";
	inputAmount.required = false;

	tranchesField.addEventListener("change", () => {
		if (tranchesField.value === "Autre montant") {
			customAmountField.style.display = "block";
			inputAmount.required = true;
		} else {
			customAmountField.style.display = "none";
			inputAmount.required = false;
		}
	});
};

/**
 * Affiche ou cache un conteneur de champs en fonction de la valeur d'un select.
 * @param {string} selectId - L'ID du <select> à surveiller
 * @param {string} containerId - L'ID du conteneur à afficher/masquer
 * @param {string} triggerValue - La valeur qui déclenche l'affichage
 */
export function toggleContainerOnOptionText(
	selectId,
	containerId,
	triggerText
) {
	const selectElement = document.getElementById(selectId);
	const containerElement = document.getElementById(containerId);

	if (!selectElement || !containerElement) return;

	// Fonction interne pour vérifier et afficher/masquer
	function updateDisplay() {
		const selectedOption =
			selectElement.options[selectElement.selectedIndex];
		if (
			selectedOption &&
			selectedOption.text.toLowerCase() === triggerText.toLowerCase()
		) {
			containerElement.style.display = "block";
		} else {
			containerElement.style.display = "none";
			// Réinitialiser les champs du conteneur
			containerElement
				.querySelectorAll("input")
				.forEach((input) => (input.value = ""));
		}
	}

	// Initialisation
	updateDisplay();

	// Événement de changement
	selectElement.addEventListener("change", updateDisplay);
}

export const gradeEditor = () => {
	// Éditeur de notes
	// Sélectionner tous les boutons "Éditer"
	// et ajouter un gestionnaire d'événement
	// pour basculer entre le mode édition et le mode enregistrement.
	// Utiliser un dataset pour éviter le double-bind.
	// Ajouter une validation des entrées pour s'assurer que les notes sont valides.
	// Afficher un message d'erreur si la note n'est pas valide.

	document.querySelectorAll(".edit-grade").forEach(function (btn) {
		if (btn.dataset.bound === "1") return;
		btn.dataset.bound = "1";

		btn.addEventListener("click", function onEditClick() {
			const row = btn.closest("tr");
			const indices = [7, 8, 9, 11, 12];

			const cells = indices.map((i) => row.children[i]).filter(Boolean);

			const actionCell = btn.closest("td") || row.lastElementChild;
			let errorMsg = actionCell.querySelector(".error-msg");
			if (!errorMsg) {
				errorMsg = document.createElement("div");
				errorMsg.className = "error-msg";
				errorMsg.style.color = "red";
				errorMsg.style.fontSize = "13px";
				errorMsg.style.marginTop = "5px";
				errorMsg.style.display = "none";
				actionCell.appendChild(errorMsg);
			}

			cells.forEach((cell) => {
				const val = (cell.textContent || "").trim();
				cell.innerHTML = `<input type="number" min="0" max="20" step="0.01" value="${val.replace(
					",",
					"."
				)}" style="width:60px;">`;
			});

			btn.textContent = "Enregistrer";
			btn.classList.remove("edit-grade");
			btn.classList.add("save-grade");

			function validateInputs() {
				let valid = true;

				cells.forEach((cell) => {
					const input = cell.querySelector('input[type="number"]');

					if (!input) {
						valid = false;
						return;
					}

					const value = parseFloat(
						String(input.value).replace(",", ".")
					);
					if (Number.isNaN(value) || value < 0 || value > 20) {
						input.style.border = "1px solid red";
						valid = false;
					} else {
						input.style.border = "";
					}
				});

				if (!valid) {
					errorMsg.textContent =
						"La note doit être comprise entre 0 et 20.";
					errorMsg.style.display = "block";
				} else {
					errorMsg.style.display = "none";
				}
				return valid;
			}

			cells.forEach((cell) => {
				const input = cell.querySelector('input[type="number"]');
				if (input) input.addEventListener("input", validateInputs);
			});
			validateInputs();

			btn.removeEventListener("click", onEditClick);
			btn.addEventListener("click", function onSaveClick() {
				if (!validateInputs()) return;

				cells.forEach((cell) => {
					const input = cell.querySelector('input[type="number"]');
					if (input) {
						const value = String(input.value).replace(",", ".");
						cell.textContent = value;
					}
				});

				errorMsg.style.display = "none";
				btn.textContent = "Éditer";
				btn.classList.remove("save-grade");
				btn.classList.add("edit-grade");

				btn.removeEventListener("click", onSaveClick);
				btn.dataset.bound = "";
				gradeEditor();
			});
		});
	});
};

export const userDropdownMenu = () => {
	const parent = document.querySelector("#menu-left");
	const menu = document.querySelector("#user-dropdown-menu");
	let userItem = true;

	parent.addEventListener("click", () => {
		if (userItem) {
			menu.style.display = "block";
			console.log("Menu déroulant utilisateur affiché");
			userItem = false;
		} else {
			menu.style.display = "none";
			console.log("Menu déroulant utilisateur masqué");
			userItem = true;
		}
	});
};

export const selectUserRole = function () {
	const roleSelect = document.getElementById("role_id");
	if (!roleSelect) return;

	roleSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectRole.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			roleSelect.innerHTML = "<option disabled selected>Rôle</option>";

			data.forEach((role) => {
				const option = document.createElement("option");
				option.value = role.role_id;
				option.textContent = role.role_name;
				roleSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des rôles :", err);
			roleSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des rôles</option>";
		});
};

export const selectCourse = function () {
	const courseSelect = document.getElementById("course_id");
	if (!courseSelect) return;

	courseSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectCourse.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			courseSelect.innerHTML =
				"<option disabled selected>Matière</option>";

			data.forEach((course) => {
				const option = document.createElement("option");
				option.value = course.course_id;
				option.textContent = course.course_name;
				courseSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des matières :", err);
			courseSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des matières</option>";
		});
};

export const selectRoom = function () {
	const roomSelect = document.getElementById("room_id");
	if (!roomSelect) return;

	roomSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectRoom.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			roomSelect.innerHTML = "<option disabled selected>Salle</option>";

			data.forEach((room) => {
				const option = document.createElement("option");
				option.value = room.room_id;
				option.textContent = room.room_name;
				roomSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des salles :", err);
			roomSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des salles</option>";
		});
};

export const selectTeacher = function () {
	const teacherSelect = document.getElementById("teacher_id");
	if (!teacherSelect) return;

	teacherSelect.innerHTML =
		"<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectTeacher.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			teacherSelect.innerHTML =
				"<option disabled selected>Enseignant</option>";

			data.forEach((teacher) => {
				const option = document.createElement("option");
				option.value = teacher.teacher_id;
				option.textContent = `${teacher.user_firstname} ${teacher.user_lastname}`;
				teacherSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des enseignants :", err);
			teacherSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des enseignants</option>";
		});
};

export const selectParent = function () {
	const parentSelect = document.getElementById("parent_id");
	if (!parentSelect) return;

	parentSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectParent.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			parentSelect.innerHTML =
				"<option disabled selected>Parent</option>";

			data.forEach((parent) => {
				const option = document.createElement("option");
				option.value = parent.parent_id;
				option.textContent = `${parent.user_firstname} ${parent.user_lastname}`;
				parentSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des parents :", err);
			parentSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des parents</option>";
		});
};

export const selectSerie = function () {
	const serieSelect = document.getElementById("serie_id");
	if (!serieSelect) return;

	serieSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectSerie.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			serieSelect.innerHTML = "<option disabled selected>Série</option>";

			data.forEach((serie) => {
				const option = document.createElement("option");
				option.value = serie.serie_id;
				option.textContent = serie.serie_name;
				serieSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des séries :", err);
			serieSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des séries</option>";
		});
};

export const selectPlace = function () {
	const placeSelect = document.getElementById("place_id");
	if (!placeSelect) return;

	placeSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectPlace.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			placeSelect.innerHTML = "<option disabled selected>Centre</option>";

			data.forEach((place) => {
				const option = document.createElement("option");
				option.value = place.place_id;
				option.textContent = place.place_name;
				placeSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des centres :", err);
			placeSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des centres</option>";
		});
};

export const selectYear = function () {
	const yearSelect = document.getElementById("year_id");
	if (!yearSelect) return;

	yearSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectYear.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			yearSelect.innerHTML =
				"<option disabled selected>Année scolaire</option>";
			data.forEach((year) => {
				const option = document.createElement("option");
				option.value = year.year_id;
				option.textContent = year.year_name;
				yearSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error(
				"Erreur lors du chargement des années scolaires :",
				err
			);
			yearSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des années scolaires</option>";
		});
};

export const selectCycle = function () {
	const cycleSelect = document.getElementById("cycle_id");
	if (!cycleSelect) return;

	cycleSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectCycle.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			cycleSelect.innerHTML =
				"<option disabled selected>Cycle scolaire</option>";
			data.forEach((cycle) => {
				const option = document.createElement("option");
				option.value = cycle.cycle_id;
				option.textContent = cycle.cycle_name;
				cycleSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error(
				"Erreur lors du chargement des années scolaires :",
				err
			);
			cycleSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des années scolaires</option>";
		});
};

export const selectSchooing = function () {
	const schoolingSelect = document.getElementById("schooling_id");
	if (!schoolingSelect) return;

	schoolingSelect.innerHTML =
		"<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectSchooling.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			schoolingSelect.innerHTML =
				"<option disabled selected>Type de scolarité</option>";

			data.forEach((schooling) => {
				const option = document.createElement("option");
				option.value = schooling.schooling_id;
				option.textContent = schooling.schooling_name;
				schoolingSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error(
				"Erreur lors du chargement des types de scolarité :",
				err
			);
			schoolingSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des types de scolarité</option>";
		});
};

export const selectLevel = function () {
	const levelSelect = document.getElementById("level_id");
	if (!levelSelect) return;

	levelSelect.innerHTML = "<option disabled selected>Chargement...</option>";

	const url = "/gsc/backend/Models/SelectLevel.php";

	fetch(url, { cache: "no-store" })
		.then((response) => {
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			return response.json();
		})
		.then((data) => {
			if (!Array.isArray(data)) {
				throw new Error("Format de réponse invalide");
			}

			levelSelect.innerHTML = "<option disabled selected>Classe</option>";

			data.forEach((level) => {
				const option = document.createElement("option");
				option.value = level.level_id;
				option.textContent = level.level_name;
				levelSelect.appendChild(option);
			});
		})
		.catch((err) => {
			console.error("Erreur lors du chargement des classes :", err);
			levelSelect.innerHTML =
				"<option disabled selected>Erreur de chargement des classes</option>";
		});
};

export const logoutUser = () => {
	const logoutBtn = document.querySelector("#logout");
	logoutBtn.addEventListener("click", () => {
		if (window.confirm("Êtes-vous sûr de vouloir vous déconnecter ?")) {
			window.location.href = "/gsc/backend/Views/pages/logout.php";
			window.alert("Vous avez été déconnecté avec succès.");
			console.log("Déconnexion de l'utilisateur");
		} else {
			console.error("Erreur de déconnexion");
		}
	});
};
