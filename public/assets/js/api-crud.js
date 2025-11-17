import { showPopup, showConfirmPopup } from "../js/popup.js";

document.addEventListener("DOMContentLoaded", async (e) => {
	const page = document.body.dataset.page;
	switch (page) {
		// =============================
		// FONCTIONS MANAGER – INDEX
		// =============================
		case "index": {
			const form = document.getElementById("form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.index.login(formData);

					if (result.success) {
						showPopup(
							"success",
							result.message || "Connexion réussie !"
						);
						form.reset();

						// Redirect after 2 seconds
						setTimeout(() => {
							window.location.href = `/gsc/backend/Views/pages/${result.redirect}`;
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur de connexion."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur du réseau.");
				}
			});
			break;
		}

		case "first-connection": {
			const form = document.getElementById("form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.firstConnection.connect(
						formData
					);

					if (result.success) {
						showPopup(
							"success",
							result.message ||
								"Redirection vers votre tableau de bord en cours..."
						);
						form.reset();

						// Redirect after 2 seconds
						setTimeout(() => {
							window.location.href = `/gsc/backend/Views/pages/${result.redirect}`;
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur de connexion."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur du réseau.");
				}
			});
			break;
		}

		// =============================
		// FONCTIONS MANAGER – PERSONALS
		// =============================
		case "add-personal": {
			const form = document.getElementById("add-personal-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.personals.add(formData);
					// Check if result is successful
					if (result.success) {
						let popupContent =
							result.message || "Personnel ajouté avec succès.";
						if (result.plain_password) {
							popupContent += `<br><br><strong>Mot de passe généré :</strong> <span id='plain-password' style='font-family:monospace;'>${result.plain_password}</span> <button id='copy-password-btn' style='margin-left:8px;padding:2px 8px;font-size:0.9em;'>Copier</button>`;
						}
						showPopup("success", popupContent, false);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/personals/list-personal.php";
						}, 2000);
						// Ajout gestion du bouton copier
						setTimeout(() => {
							const btn =
								document.getElementById("copy-password-btn");
							if (btn) {
								btn.onclick = function () {
									const pwd =
										document.getElementById(
											"plain-password"
										).textContent;
									navigator.clipboard.writeText(pwd);
									btn.textContent = "Copié !";
									setTimeout(() => {
										btn.textContent = "Copier";
									}, 1500);
								};
							}
						}, 300);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout du personnel."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur");
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// List Personals
		case "list-personal": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				// load via API
				const personals = await GSC.API.personals.list();

				if (!personals || personals.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun personnel trouvé</td></tr>`;

					// Update footer count
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 personnel enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				personals.forEach((value, index) => {
					if (value.role_name === "Super admin") return; // Skip Super Admin display
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.user_lastname}</td>
						<td class="list__row-item">${value.user_firstname}</td>
						<td class="list__row-item">${value.user_phone}</td>
						<td class="list__row-item">${value.user_email}</td>
						<td class="list__row-item">${value.user_sex}</td>
						<td class="list__row-item">${value.place_name}</td>
						<td class="list__row-item">${value.role_name}</td>
						<td class="list__row-item">${value.user_date_add}</td>
						<td class="list__row-item">
							<a href="edit-personal.php?id=${
								value.user_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.user_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = personals.length;
					totalCell.textContent =
						total +
						(total > 1
							? " personnels enregistrés"
							: " personnel enregistré");
				}

				// Delete Personal
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const personalId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce personnel ?",
							async () => {
								try {
									const result =
										await GSC.API.personals.delete(
											personalId
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										// Update footer count after deletion
										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " personnels enregistrés"
													: " personnel enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des personnels."
				);
			}
			break;
		}

		case "edit-personal": {
			const form = document.querySelector("#edit-personal-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le personnel.");
				break;
			}

			// load places
			let places = [];
			try {
				const resPlaces = await fetch(
					"/gsc/backend/Models/SelectPlace.php"
				);
				places = await resPlaces.json();
				const selectPlace = form.querySelector("[name='place_id']");
				selectPlace.innerHTML = "<option disabled>Centre</option>";
				places.forEach((place) => {
					const opt = document.createElement("option");
					opt.value = place.place_id;
					opt.textContent = place.place_name;
					selectPlace.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des centres.");
			}

			// load roles
			let roles = [];
			try {
				const resRoles = await fetch(
					"/gsc/backend/Models/SelectRole.php"
				);
				roles = await resRoles.json();
				const selectRole = form.querySelector("[name='role_id']");
				selectRole.innerHTML = "<option disabled>Rôle</option>";
				roles.forEach((role) => {
					const opt = document.createElement("option");
					opt.value = role.role_id;
					opt.textContent = role.role_name;
					selectRole.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des rôles.");
			}

			// Charger les infos du personnel
			try {
				const res = await fetch(
					`/gsc/backend/Models/Personal.php?action=get&id=${id}`
				);
				const personal = await res.json();
				if (!personal || !personal.user_id) {
					showPopup("danger", "Personnel introuvable.");
					break;
				}
				// Pré-remplir le formulaire
				document.getElementById("user_id").value = personal.user_id;
				form.querySelector("[name='user_lastname']").value =
					personal.user_lastname;
				form.querySelector("[name='user_firstname']").value =
					personal.user_firstname;
				form.querySelector("[name='user_birth_date']").value =
					personal.user_birth_date;
				form.querySelector("[name='user_sex']").value =
					personal.user_sex;
				form.querySelector("[name='user_phone']").value =
					personal.user_phone;
				form.querySelector("[name='user_email']").value =
					personal.user_email ?? "";
				// Sélectionner le bon rôle
				if (personal.role_id) {
					form.querySelector("[name='role_id']").value =
						personal.role_id;
				}
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du personnel."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.personals.update(id, formData);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Personnel modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/personals/list-personal.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// =============================
		// FONCTIONS MANAGER – TEACHERS
		// =============================
		case "add-teacher": {
			const form = document.getElementById("add-teacher-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.teachers.add(formData);
					// Check if result is successful
					if (result.success) {
						let popupContent =
							result.message || "Enseignant ajouté avec succès.";
						if (result.plain_password) {
							popupContent += `<br><br><strong>Mot de passe généré :</strong> <span id='plain-password' style='font-family:monospace;'>${result.plain_password}</span> <button id='copy-password-btn' style='margin-left:8px;padding:2px 8px;font-size:0.9em;'>Copier</button>`;
						}
						showPopup("success", popupContent, false);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/teachers/list-teacher.php";
						}, 2000);
						// Ajout gestion du bouton copier
						setTimeout(() => {
							const btn =
								document.getElementById("copy-password-btn");
							if (btn) {
								btn.onclick = function () {
									const pwd =
										document.getElementById(
											"plain-password"
										).textContent;
									navigator.clipboard.writeText(pwd);
									btn.textContent = "Copié !";
									setTimeout(() => {
										btn.textContent = "Copier";
									}, 1500);
								};
							}
						}, 300);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de l'enseignant."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur");
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// List Teacher
		case "list-teacher": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				// load via API
				const teachers = await GSC.API.teachers.list();

				if (!teachers || teachers.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun enseignant trouvé</td></tr>`;

					// Update footer count
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 enseignant enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				teachers.forEach((value, index) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.user_lastname}</td>
						<td class="list__row-item">${value.user_firstname}</td>
						<td class="list__row-item">${value.user_phone}</td>
						<td class="list__row-item">${value.user_email}</td>
						<td class="list__row-item">${value.user_date_add}</td>
						<td class="list__row-item">
							<a href="edit-teacher.php?id=${
								value.user_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.user_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = teachers.length;
					totalCell.textContent =
						total +
						(total > 1
							? " enseignants enregistrés"
							: " enseignant enregistré");
				}

				// Delete Teacher
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const teacherId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cet enseignant ?",
							async () => {
								try {
									const result =
										await GSC.API.teachers.delete(
											teacherId
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										// Update footer count after deletion
										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " enseignants enregistrés"
													: " enseignant enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des enseignants."
				);
			}
			break;
		}

		case "edit-teacher": {
			const form = document.querySelector("#edit-teacher-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger l'enseignant.");
				break;
			}

			// Charger les infos de l'enseignant
			try {
				const res = await fetch(
					`/gsc/backend/Models/Teacher.php?action=get&id=${id}`
				);
				const teacher = await res.json();
				if (!teacher || !teacher.user_id) {
					showPopup("danger", "Enseignant introuvable.");
					break;
				}
				// Pré-remplir le formulaire
				document.getElementById("user_id").value = teacher.user_id;
				form.querySelector("[name='user_lastname']").value =
					teacher.user_lastname;
				form.querySelector("[name='user_firstname']").value =
					teacher.user_firstname;
				form.querySelector("[name='user_birth_date']").value =
					teacher.user_birth_date;
				form.querySelector("[name='user_sex']").value =
					teacher.user_sex;
				form.querySelector("[name='user_phone']").value =
					teacher.user_phone;
				form.querySelector("[name='user_email']").value =
					teacher.user_email ?? "";
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de enseignant."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.teachers.update(id, formData);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Enseignant modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/teachers/list-teacher.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "school-session": {
			const content = document.querySelector(".content");
			if (!content) return;

			try {
				// Récupérer la liste des lieux/plannings de l'enseignant
				const teachers = await GSC.API.teachers.listPlace();

				const levelList = [
					"6ème",
					"5ème",
					"4ème",
					"3ème",
					"2nde",
					"1ère",
					"Tle",
				];

				teachers.forEach((value) => {
					const cycleName = levelList.includes(`${value.level_name}`)
						? "Secondaire"
						: "Primaire";

					const session = document.createElement("div");
					session.classList.add("session");

					// Vérifier si certaines données sont nulles (LEFT JOIN peut produire null)
					const placeName = value.place_name || "Non attribué";
					const yearName = value.year_name || "Non défini";
					const levelName = value.level_name || "Non défini";

					session.innerHTML = `
                <form action="checkSchool.php" class="school-session" method="POST" id="school-session-form">
                    <h2 class="form__title">${placeName} | ${yearName}</h2>
                    <h3 class="form__title">Cycle : ${cycleName}</h3>
                    <h3 class="form__title">Classe : ${levelName}</h3>

                    <input type="hidden" name="year_id" value="${
						value.year_id || ""
					}" />
                    <input type="hidden" name="cycle_id" value="${
						value.cycle_id || ""
					}" />
					<input type="hidden" name="place_id" value="${value.place_id || ""}" />

                    <div class="form__group">
                        <button type="submit" name="connect" class="group__button">
                            Connexion
                        </button>
                    </div>
                </form>
            `;
					content.appendChild(session);
				});
			} catch (err) {
				console.error(err);
				showPopup("danger", "Erreur réseau.");
			}
			break;
		}

		// =============================
		// FONCTIONS MANAGER – PARENTS
		// =============================
		case "add-parent": {
			const form = document.getElementById("add-parent-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.parents.add(formData);
					// Check if result is successful
					if (result.success) {
						showPopup(
							"success",
							result.message || "Parent ajouté avec succès."
						);
						form.reset();
						// Redirect or update the UI as needed
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/parents/list-parent.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout du parent."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-parent": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				// load via API
				const parents = await GSC.API.parents.list();

				if (!parents || parents.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun parent trouvé</td></tr>`;

					// Update footer count
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 parent enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				parents.forEach((value, index) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.user_lastname}</td>
						<td class="list__row-item">${value.user_firstname}</td>
						<td class="list__row-item">${value.user_phone}</td>
						<td class="list__row-item">${value.user_email}</td>
						<td class="list__row-item">${value.user_sex}</td>
						<td class="list__row-item">${value.user_date_add}</td>
						<td class="list__row-item">
							<a href="edit-parent.php?id=${
								value.user_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.user_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = parents.length;
					totalCell.textContent =
						total +
						(total > 1
							? " parents enregistrés"
							: " parent enregistré");
				}

				// Delete Parent
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const parentId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce parent ?",
							async () => {
								try {
									const result = await GSC.API.parents.delete(
										parentId
									);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										// Update footer count after deletion
										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " parents enregistrés"
													: " parent enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup("danger", "Erreur réseau.");
			}
			break;
		}

		case "edit-parent": {
			const form = document.querySelector("#edit-parent-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const parentId = params.get("id");
			if (!parentId) {
				showPopup("danger", "Impossible de charger le parent.");
				break;
			}

			// Charger les infos du parent
			try {
				const parent = await GSC.API.parents.get(parentId);
				if (!parent) {
					showPopup("danger", "Parent introuvable.");
					return;
				}

				// Pré-remplir le formulaire
				document.getElementById("user_id").value = parent.user_id;
				document.getElementById("user_lastname").value =
					parent.user_lastname;
				document.getElementById("user_firstname").value =
					parent.user_firstname;
				document.getElementById("user_phone").value = parent.user_phone;
				document.getElementById("user_email").value = parent.user_email;
				document.getElementById("user_sex").value = parent.user_sex;
				document.getElementById("user_birth_date").value =
					parent.user_birth_date;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur lors du chargement des informations du parent."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.parents.update(
						parentId,
						formData
					);
					// Check if result is successful
					if (result.success) {
						showPopup(
							"success",
							result.message || "Parent modifié avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/parents/list-parent.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de la modification du parent."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// =============================
		// FONCTIONS MANAGER – STUDENTS
		// =============================
		case "add-student": {
			const form = document.getElementById("add-student-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.students.add(formData);
					// Check if result is successful
					if (result.success) {
						showPopup(
							"success",
							result.message || "Élève ajouté avec succès."
						);
						form.reset();
						// Redirect or update the UI as needed
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/students/list-student.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de l'élève."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// list-student
		case "list-student": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				// load via API
				const students = await GSC.API.students.list();

				if (!students || students.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun apprenant trouvé</td></tr>`;

					// Update footer count
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 apprenant enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				students.forEach((value, index) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.student_matricule}</td>
						<td class="list__row-item">${value.user_lastname}</td>
						<td class="list__row-item">${value.user_firstname}</td>
						<td class="list__row-item">${value.user_email}</td>	
						<td class="list__row-item">${value.user_birth_date}</td>
						<td class="list__row-item">${value.user_sex}</td>
						<td class="list__row-item">${value.year_name}</td>
						<td class="list__row-item">${value.place_name}</td>
						<td class="list__row-item">${value.cycle_name}</td>
						<td class="list__row-item">${value.level_name}</td>
						<td class="list__row-item">${value.serie_name}</td>
						<td class="list__row-item">${value.student_date_add}</td>
						<td class="list__row-item">
							<a href="edit-student.php?id=${
								value.user_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="reinscription-student.php?id=${
								value.user_id
							}" class="list__btn btn-edit">Reinscrire</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.user_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = students.length;
					totalCell.textContent =
						total +
						(total > 1
							? " apprenants enregistrés"
							: " apprenant enregistré");
				}

				// Delete Apprenant
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const studentId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cet apprenant ?",
							async () => {
								try {
									const result =
										await GSC.API.students.delete(
											studentId
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										// Update footer count after deletion
										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " apprenants enregistrés"
													: " apprenant enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup("danger", "Erreur réseau.");
			}
			break;
		}

		// edit-student
		case "edit-student": {
			const form = document.querySelector("#edit-student-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const studentId = params.get("id");
			if (!studentId) {
				showPopup("danger", "Impossible de charger l'apprenant(e).");
				break;
			}

			// Charger les infos de l'apprenant
			try {
				const student = await GSC.API.students.get(studentId);
				if (!student) {
					showPopup("danger", "Apprenant(e) introuvable.");
					return;
				}

				// load parents
				let parents = [];
				try {
					const resParents = await fetch(
						"/gsc/backend/Models/SelectParent.php"
					);
					parents = await resParents.json();
					const selectParent =
						form.querySelector("[name='parent_id']");
					selectParent.innerHTML = "<option disabled>Parent</option>";
					parents.forEach((parent) => {
						const opt = document.createElement("option");
						opt.value = parent.parent_id;
						opt.textContent = `${parent.user_firstname} ${parent.user_lastname}`;
						selectParent.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des parents."
					);
				}

				// load places
				let places = [];
				try {
					const resPlaces = await fetch(
						"/gsc/backend/Models/SelectPlace.php"
					);
					places = await resPlaces.json();
					const selectPlace = form.querySelector("[name='place_id']");
					selectPlace.innerHTML = "<option disabled>Centre</option>";
					places.forEach((place) => {
						const opt = document.createElement("option");
						opt.value = place.place_id;
						opt.textContent = place.place_name;
						selectPlace.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des centres."
					);
				}

				// load levels
				let levels = [];
				try {
					const resLevels = await fetch(
						"/gsc/backend/Models/SelectLevel.php"
					);
					levels = await resLevels.json();
					const selectLevel = form.querySelector("[name='level_id']");
					selectLevel.innerHTML = "<option disabled>Niveau</option>";
					levels.forEach((level) => {
						const opt = document.createElement("option");
						opt.value = level.level_id;
						opt.textContent = level.level_name;
						selectLevel.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des niveaux."
					);
				}

				// load series
				let series = [];
				try {
					const resSeries = await fetch(
						"/gsc/backend/Models/SelectSerie.php"
					);
					series = await resSeries.json();
					const selectSerie = form.querySelector("[name='serie_id']");
					selectSerie.innerHTML = "<option disabled>Série</option>";
					series.forEach((serie) => {
						const opt = document.createElement("option");
						opt.value = serie.serie_id;
						opt.textContent = serie.serie_name;
						selectSerie.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des séries."
					);
				}

				// load rooms
				let rooms = [];
				try {
					const resRooms = await fetch(
						"/gsc/backend/Models/SelectRoom.php"
					);
					rooms = await resRooms.json();
					const selectRoom = form.querySelector("[name='room_id']");
					selectRoom.innerHTML = "<option disabled>Salle</option>";
					rooms.forEach((room) => {
						const opt = document.createElement("option");
						opt.value = room.room_id;
						opt.textContent = room.room_name;
						selectRoom.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des salles."
					);
				}

				// Pré-remplir le formulaire
				document.getElementById("user_id").value = student.user_id;
				document.getElementById("user_lastname").value =
					student.user_lastname;
				document.getElementById("user_firstname").value =
					student.user_firstname;
				document.getElementById("user_phone").value =
					student.user_phone;
				document.getElementById("user_email").value =
					student.user_email;
				document.getElementById("user_sex").value = student.user_sex;
				document.getElementById("user_birth_date").value =
					student.user_birth_date;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur lors du chargement des informations du parent."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.students.update(
						studentId,
						formData
					);
					// Check if result is successful
					if (result.success) {
						showPopup(
							"success",
							result.message ||
								"Apprenant(e) modifié avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/students/list-student.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de la modification de l'apprenant(e)."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// reinscription-student
		case "reinscription-student": {
			const form = document.querySelector("#reinscription-student-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const studentId = params.get("id");
			if (!studentId) {
				showPopup("danger", "Impossible de charger l'apprenant(e).");
				break;
			}

			// Charger les infos de l'apprenant
			try {
				const student = await GSC.API.students.get(studentId);
				if (!student) {
					showPopup("danger", "Apprenant(e) introuvable.");
					return;
				}

				// load places
				let places = [];
				try {
					const resPlaces = await fetch(
						"/gsc/backend/Models/SelectPlace.php"
					);
					places = await resPlaces.json();
					const selectPlace = form.querySelector("[name='place_id']");
					selectPlace.innerHTML = "<option disabled>Centre</option>";
					places.forEach((place) => {
						const opt = document.createElement("option");
						opt.value = place.place_id;
						opt.textContent = place.place_name;
						selectPlace.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des centres."
					);
				}

				// load levels
				let levels = [];
				try {
					const resLevels = await fetch(
						"/gsc/backend/Models/SelectLevel.php"
					);
					levels = await resLevels.json();
					const selectLevel = form.querySelector("[name='level_id']");
					selectLevel.innerHTML = "<option disabled>Niveau</option>";
					levels.forEach((level) => {
						const opt = document.createElement("option");
						opt.value = level.level_id;
						opt.textContent = level.level_name;
						selectLevel.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des niveaux."
					);
				}

				// load series
				let series = [];
				try {
					const resSeries = await fetch(
						"/gsc/backend/Models/SelectSerie.php"
					);
					series = await resSeries.json();
					const selectSerie = form.querySelector("[name='serie_id']");
					selectSerie.innerHTML = "<option disabled>Série</option>";
					series.forEach((serie) => {
						const opt = document.createElement("option");
						opt.value = serie.serie_id;
						opt.textContent = serie.serie_name;
						selectSerie.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des séries."
					);
				}

				// load rooms
				let rooms = [];
				try {
					const resRooms = await fetch(
						"/gsc/backend/Models/SelectRoom.php"
					);
					rooms = await resRooms.json();
					const selectRoom = form.querySelector("[name='room_id']");
					selectRoom.innerHTML = "<option disabled>Salle</option>";
					rooms.forEach((room) => {
						const opt = document.createElement("option");
						opt.value = room.room_id;
						opt.textContent = room.room_name;
						selectRoom.appendChild(opt);
					});
				} catch (e) {
					showPopup(
						"danger",
						"Erreur lors du chargement des salles."
					);
				}

				// Pré-remplir le formulaire
				document.getElementById("student_id").value =
					student.student_id;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur lors du chargement des informations de l'apprenant(e)."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.students.reinscription(
						formData
					);
					// Check if result is successful
					if (result.success) {
						showPopup(
							"success",
							result.message ||
								"Apprenant(e) reinscrit(e) avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/students/list-student.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de la reinscription de l'apprenant(e)."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// =============================
		// FONCTIONS MANAGER – SCHEDULES
		// =============================
		case "add-schedule": {
			const form = document.getElementById("add-schedule-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.schedules.add(formData);
					// Check if result is successful
					if (result.success) {
						let popupContent =
							result.message ||
							"Emploi du temps ajouté avec succès.";
						showPopup("success", popupContent, false);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/schedules/list-schedule.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de l'emploi du temps."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur");
					showPopup("danger", "Erreur du réseau.");
				}
			});
			break;
		}

		// List Schedules
		case "list-schedule": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				// load via API
				const schedules = await GSC.API.schedules.list();

				if (!schedules || schedules.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun emploi du temps trouvé</td></tr>`;

					// Update footer count
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 emploi du temps enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				schedules.forEach((value, index) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.user_lastname}</td>
						<td class="list__row-item">${value.user_firstname}</td>
						<td class="list__row-item">${value.schedule_day}</td>
						<td class="list__row-item">${value.schedule_start_time}</td>
						<td class="list__row-item">${value.schedule_end_time}</td>
						<td class="list__row-item">${value.place_name}</td>
						<td class="list__row-item">${value.course_name}</td>
						<td class="list__row-item">${value.level_name}</td>
						<td class="list__row-item">${value.room_name}</td>
						<td class="list__row-item">${value.serie_name}</td>
						<td class="list__row-item">${value.schedule_date_add}</td>
						<td class="list__row-item">
							<a href="edit-schedule.php?id=${
								value.schedule_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${
								value.schedule_id
							}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = schedules.length;
					totalCell.textContent =
						total +
						(total > 1
							? " emplois du temps enregistrés"
							: " emploi du temps enregistré");
				}

				// Delete Teacher
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const scheduleId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cet emploi du temps ?",
							async () => {
								try {
									const result =
										await GSC.API.schedules.delete(
											scheduleId
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										// Update footer count after deletion
										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " emplois du temps enregistrés"
													: " emploi du temps enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des emplois du temps."
				);
			}
			break;
		}

		case "edit-schedule": {
			const form = document.querySelector("#edit-schedule-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger l'emploi du temps.");
				break;
			}

			// load places
			let places = [];
			try {
				const resPlaces = await fetch(
					"/gsc/backend/Models/SelectPlace.php"
				);
				places = await resPlaces.json();
				const selectPlace = form.querySelector("[name='place_id']");
				selectPlace.innerHTML = "<option disabled>Centre</option>";
				places.forEach((place) => {
					const opt = document.createElement("option");
					opt.value = place.place_id;
					opt.textContent = place.place_name;
					selectPlace.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des centres.");
			}

			// load courses
			let courses = [];
			try {
				const resCourses = await fetch(
					"/gsc/backend/Models/SelectCourse.php"
				);
				courses = await resCourses.json();
				const selectCourse = form.querySelector("[name='course_id']");
				selectCourse.innerHTML = "<option disabled>Cours</option>";
				courses.forEach((course) => {
					const opt = document.createElement("option");
					opt.value = course.course_id;
					opt.textContent = course.course_name;
					selectCourse.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des cours.");
			}

			// load levels
			let levels = [];
			try {
				const resLevels = await fetch(
					"/gsc/backend/Models/SelectLevel.php"
				);
				levels = await resLevels.json();
				const selectLevel = form.querySelector("[name='level_id']");
				selectLevel.innerHTML = "<option disabled>Niveau</option>";
				levels.forEach((level) => {
					const opt = document.createElement("option");
					opt.value = level.level_id;
					opt.textContent = level.level_name;
					selectLevel.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des niveaux.");
			}

			// load series
			let series = [];
			try {
				const resSeries = await fetch(
					"/gsc/backend/Models/SelectSerie.php"
				);
				series = await resSeries.json();
				const selectSerie = form.querySelector("[name='serie_id']");
				selectSerie.innerHTML = "<option disabled>Série</option>";
				series.forEach((serie) => {
					const opt = document.createElement("option");
					opt.value = serie.serie_id;
					opt.textContent = serie.serie_name;
					selectSerie.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des séries.");
			}

			// load rooms
			let rooms = [];
			try {
				const resRooms = await fetch(
					"/gsc/backend/Models/SelectRoom.php"
				);
				rooms = await resRooms.json();
				const selectRoom = form.querySelector("[name='room_id']");
				selectRoom.innerHTML = "<option disabled>Salle</option>";
				rooms.forEach((room) => {
					const opt = document.createElement("option");
					opt.value = room.room_id;
					opt.textContent = room.room_name;
					selectRoom.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des salles.");
			}

			// Charger les infos de l'emploi du temps
			try {
				const schedule = await GSC.API.schedules.get(id);
				if (!schedule || !schedule.schedule_id) {
					showPopup("danger", "Emploi du temps introuvable.");
					break;
				}
				// Pré-remplir le formulaire
				document.getElementById("teacher_id").value =
					schedule.teacher_id;
				form.querySelector("[name='place_id']").value =
					schedule.place_id;
				form.querySelector("[name='course_id']").value =
					schedule.course_id;
				form.querySelector("[name='level_id']").value =
					schedule.level_id;
				form.querySelector("[name='serie_id']").value =
					schedule.serie_id;
				form.querySelector("[name='room_id']").value = schedule.room_id;
				form.querySelector("[name='schedule_day']").value =
					schedule.schedule_day;
				form.querySelector("[name='schedule_start_time']").value =
					schedule.schedule_start_time;
				form.querySelector("[name='schedule_end_time']").value =
					schedule.schedule_end_time;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de l'emploi du temps."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.schedules.update(id, formData);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message ||
								"Emploi du temps modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/schedules/list-schedule.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "generate-timetable": {
			const form = document.getElementById("generate-timetable-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.schedules.generateTimetablePDF(
						formData
					);
					// Check if result is successful
					if (result.success) {
						let popupContent =
							result.message ||
							"Emplois du temps générés avec succès.";
						showPopup("success", popupContent, false);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/schedules/timetable/timetable.php";
						}, 2000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de la génération des emplois du temps."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur");
					showPopup("danger", "Erreur du réseau.");
				}
			});
			break;
		}

		case "timetable": {
			const page = document.body.dataset.page;

			if (page === "timetable") {
				const level_id = document.body.dataset.levelId;
				const serie_id = document.body.dataset.serieId;
				const room_id = document.body.dataset.roomId;
				const place_id = document.body.dataset.placeId;

				try {
					const formData = new FormData();
					formData.append("level_id", level_id);
					formData.append("serie_id", serie_id);
					formData.append("room_id", room_id);
					formData.append("place_id", place_id);

					const result = await GSC.API.schedules.generateTimetablePDF(
						formData
					);

					if (!result.success || !result.data) {
						document.getElementById(
							"schedule-body"
						).innerHTML = `<tr><td colspan="7">Aucun emploi du temps trouvé</td></tr>`;
						return;
					}

					// Remplir le header depuis l'API
					const params = result.params || {};
					document.getElementById("class-grade").textContent =
						params.level_name || "";
					document.getElementById("class-room").textContent =
						params.room_name || "";
					document.getElementById("school-year").textContent =
						params.year_name || "";
					document.getElementById("class-places").textContent =
						params.place_name || "";
					document.getElementById("class-series").textContent = [
						"6ème",
						"5ème",
						"4ème",
						"3ème",
					].includes(params.level_name)
						? "Néant"
						: params.serie_name;

					// Générer la grille
					const schedules = result.data;
					const tbody = document.getElementById("schedule-body");
					tbody.innerHTML = "";
					const days = [
						"Lundi",
						"Mardi",
						"Mercredi",
						"Jeudi",
						"Vendredi",
						"Samedi",
					];
					for (let hour = 7; hour <= 19; hour++) {
						const tr = document.createElement("tr");
						const tdTime = document.createElement("td");
						tdTime.classList.add("time-col");
						tdTime.textContent = `${hour
							.toString()
							.padStart(2, "0")}:00`;
						tr.appendChild(tdTime);

						for (const day of days) {
							const td = document.createElement("td");
							const current = schedules.find(
								(s) =>
									s.schedule_day === day &&
									parseInt(
										s.schedule_start_time.split(":")[0]
									) === hour
							);
							if (current) {
								td.innerHTML = `
								<div class="course">
									<strong>${current.course_name}</strong>
									<small>${current.teacher_name}</small><br>
									<small>${current.schedule_start_time} - ${current.schedule_end_time}</small>
								</div>`;
							}
							tr.appendChild(td);
						}
						tbody.appendChild(tr);
					}

					// === GÉNÉRATION DU PROMGRAMME EN PDF AVEC HTML2PDF ===
					document.addEventListener("click", async (e) => {
						if (e.target.id === "download-pdf") {
							const element = document.getElementById(
								"timetable-container"
							);

							const opt = {
								margin: [12, 5], // haut, droite, bas, gauche
								filename: `emploi_du_temps_${new Date()
									.toISOString()
									.slice(0, 10)}.pdf`,
								html2canvas: {
									scale: 4, // augmente la netteté
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
						}
						// Rediriger vers la sélection après téléchargement
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/schedules/timetable/generate-timetable.php";
						}, 1000);
					});
				} catch (err) {
					console.error(err);
					document.getElementById(
						"schedule-body"
					).innerHTML = `<tr><td colspan="7">Erreur lors du chargement de l'emploi du temps</td></tr>`;
				}
			}

			break;
		}

		// =============================
		// SETTINGS MANAGER – YEARS
		// =============================
		case "add-school-year": {
			const form = document.getElementById("add-year-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.years.add(formData);
					// Check if result is successful
					if (result.success) {
						let popupContent =
							result.message ||
							"Année scolaire ajoutée avec succès.";
						showPopup("success", popupContent, false);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-years/list-school-year.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de l'année scolaire."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur");
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// List Years
		case "list-school-year": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				// load via API
				const settings = await GSC.API.settings.years.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucune année scolaire trouvée</td></tr>`;

					// Update footer count
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 année scolaire enregistrée";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value, index) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.year_name}</td>
						<td class="list__row-item">${value.year_date_add}</td>
						<td class="list__row-item">
							<a href="edit-school-year.php?id=${
								value.year_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.year_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " années scolaires enregistrées"
							: " année scolaire enregistrée");
				}

				// Delete Year
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const yearId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cette année scolaire ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.years.delete(
											yearId
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										// Update footer count after deletion
										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " années scolaires enregistrés"
													: " année scolaire enregistrée");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des années scolaires."
				);
			}
			break;
		}

		case "edit-school-year": {
			const form = document.querySelector("#edit-year-form");
			if (!form) return;

			// Get ID By URL
			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger l'année scolaire.");
				break;
			}

			// Load year name
			try {
				const res = await GSC.API.settings.years.get(id);
				if (!res || !res.year_id) {
					showPopup("danger", "Année scolaire introuvable.");
					break;
				}
				// Pré-remplir le formulaire
				document.getElementById("year_id").value = res.year_id;
				form.querySelector("[name='year_name']").value = res.year_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de l'année scolaire."
				);
			}

			// Submit form
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.years.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message ||
								"Année scolaire modifiée avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-years/list-school-year.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// =============================
		// SETTINGS MANAGER – PLACES
		// =============================
		case "add-school-place": {
			const form = document.getElementById("add-place-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.places.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Lieu ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-places/list-school-place.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de l’ajout du lieu."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur");
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// List Places
		case "list-school-place": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const places = await GSC.API.settings.places.list();

				if (!places || places.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun lieu trouvé</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell) totalCell.textContent = "0 lieu enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;
				places.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.place_name}</td>
						<td class="list__row-item">${value.place_date_add}</td>
						<td class="list__row-item"><a href="edit-school-place.php?id=${
							value.place_id
						}" class="list__btn btn-edit">Éditer</a></td>
						<td class="list__row-item"><a href="" class="list__btn btn-delete" data-id="${
							value.place_id
						}">Supprimer</a></td>
					`;
					tbody.appendChild(tr);
				});

				// Update footer count
				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = places.length;
					totalCell.textContent =
						total +
						(total > 1
							? " Centres enregistrés"
							: " Centre enregistré");
				}

				// Delete Place
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const placeId = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce centre ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.places.delete(
											placeId
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " lieux enregistrés"
													: " lieu enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des centres."
				);
			}
			break;
		}

		// Edit Place
		case "edit-school-place": {
			const form = document.querySelector("#edit-place-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le centre.");
				break;
			}

			try {
				const res = await GSC.API.settings.places.get(id);

				if (!res || !res.place_id) {
					showPopup("danger", "Centre introuvable.");
					break;
				}

				document.getElementById("place_id").value = res.place_id;
				form.querySelector("[name='place_name']").value =
					res.place_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du centre."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.places.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Centre modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-places/list-school-place.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – CYCLES
		// ==========================
		case "add-school-cycle": {
			const form = document.getElementById("add-cycle-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.cycles.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Cycle ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-cycles/list-school-cycle.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de l’ajout du cycle."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-cycle": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.cycles.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun cycle trouvé</td></tr>`;

					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell) totalCell.textContent = "0 cycle enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
				<td class="list__row-item">${i++}</td>
				<td class="list__row-item">${value.cycle_name}</td>
				<td class="list__row-item">${value.cycle_date_add}</td>
				<td class="list__row-item">
					<a href="edit-school-cycle.php?id=${
						value.cycle_id
					}" class="list__btn btn-edit">Éditer</a>
				</td>
				<td class="list__row-item">
					<a href="" class="list__btn btn-delete" data-id="${
						value.cycle_id
					}">Supprimer</a>
				</td>
			`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " cycles enregistrés"
							: " cycle enregistré");
				}

				// Delete Cycle
				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce cycle ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.cycles.delete(
											id
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " cycles enregistrés"
													: " cycle enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des cycles."
				);
			}
			break;
		}

		case "edit-school-cycle": {
			const form = document.querySelector("#edit-cycle-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le cycle.");
				break;
			}

			try {
				const res = await GSC.API.settings.cycles.get(id);
				if (!res || !res.cycle_id) {
					showPopup("danger", "Cycle introuvable.");
					break;
				}
				document.getElementById("cycle_id").value = res.cycle_id;
				form.querySelector("[name='cycle_name']").value =
					res.cycle_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du cycle."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.cycles.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Cycle modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-cycles/list-school-cycle.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – LEVELS
		// ==========================
		case "add-school-grade": {
			const form = document.getElementById("add-level-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.levels.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Classe ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-grades/list-school-grade.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de la classe."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-grade": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.levels.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucune classe trouvé</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 classe enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
				<td class="list__row-item">${i++}</td>
				<td class="list__row-item">${value.level_name}</td>
				<td class="list__row-item">${value.level_date_add}</td>
				<td class="list__row-item">
					<a href="edit-school-grade.php?id=${
						value.level_id
					}" class="list__btn btn-edit">Éditer</a>
				</td>
				<td class="list__row-item">
					<a href="" class="list__btn btn-delete" data-id="${
						value.level_id
					}">Supprimer</a>
				</td>
			`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " classes enregistrés"
							: " classe enregistré");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cette classe ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.levels.delete(
											id
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " classes enregistrés"
													: " classe enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des classes."
				);
			}
			break;
		}

		case "edit-school-grade": {
			const form = document.querySelector("#edit-level-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger la classe.");
				break;
			}

			try {
				const res = await GSC.API.settings.levels.get(id);
				if (!res || !res.level_id) {
					showPopup("danger", "Classe introuvable.");
					break;
				}
				document.getElementById("level_id").value = res.level_id;
				form.querySelector("[name='level_name']").value =
					res.level_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de la classe."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.levels.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Classe modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-grades/list-school-grade.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – ROOMS
		// ==========================
		case "add-school-room": {
			const form = document.getElementById("add-room-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.rooms.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Salle ajoutée avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-rooms/list-school-room.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de la salle."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-room": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.rooms.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucune salle trouvée</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 salle enregistrée";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.room_name}</td>
						<td class="list__row-item">${value.room_date_add}</td>
						<td class="list__row-item">
							<a href="edit-school-room.php?id=${
								value.room_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.room_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " salles enregistrées"
							: " salle enregistrée");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cette salle ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.rooms.delete(id);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " salles enregistrées"
													: " salle enregistrée");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des salles."
				);
			}
			break;
		}

		case "edit-school-room": {
			const form = document.querySelector("#edit-room-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger la salle.");
				break;
			}

			try {
				const res = await GSC.API.settings.rooms.get(id);
				if (!res || !res.room_id) {
					showPopup("danger", "Salle introuvable.");
					break;
				}
				document.getElementById("room_id").value = res.room_id;
				form.querySelector("[name='room_name']").value = res.room_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de la salle."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.rooms.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Salle modifiée avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-rooms/list-school-room.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – SERIES
		// ==========================
		case "add-school-serie": {
			const form = document.getElementById("add-serie-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.series.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Série ajoutée avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-series/list-school-serie.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de la série."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-serie": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.series.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucune série trouvée</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 série enregistrée";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.serie_name}</td>
						<td class="list__row-item">${value.serie_date_add}</td>
						<td class="list__row-item">
							<a href="edit-school-serie.php?id=${
								value.serie_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${
								value.serie_id
							}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " séries enregistrées"
							: " série enregistrée");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cette série ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.series.delete(
											id
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " séries enregistrées"
													: " série enregistrée");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des séries."
				);
			}
			break;
		}

		case "edit-school-serie": {
			const form = document.querySelector("#edit-serie-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger la série.");
				break;
			}

			try {
				const res = await GSC.API.settings.series.get(id);
				if (!res || !res.serie_id) {
					showPopup("danger", "Série introuvable.");
					break;
				}
				document.getElementById("serie_id").value = res.serie_id;
				form.querySelector("[name='serie_name']").value =
					res.serie_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de la série."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.series.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Série modifiée avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-series/list-school-serie.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// =============================
		// SETTINGS MANAGER – SCHOOLINGS
		// =============================
		case "add-schooling": {
			const form = document.getElementById("add-schooling-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.schoolings.add(
						formData
					);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Scolarité ajoutée avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-schooling/list-schooling.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message ||
								"Erreur lors de l’ajout de la scolarité."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-schooling": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.schoolings.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucune scolarité trouvée</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 scolarité enregistrée";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.schooling_name}</td>
						<td class="list__row-item">${value.schooling_date_add}</td>
						<td class="list__row-item">
							<a href="edit-schooling.php?id=${
								value.schooling_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${
								value.schooling_id
							}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " scolarités enregistrées"
							: " scolarité enregistrée");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer cette scolarité ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.schoolings.delete(
											id
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " scolarités enregistrées"
													: " scolarité enregistrée");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des scolarités."
				);
			}
			break;
		}

		case "edit-schooling": {
			const form = document.querySelector("#edit-schooling-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger la scolarité.");
				break;
			}

			try {
				const res = await GSC.API.settings.schoolings.get(id);
				if (!res || !res.schooling_id) {
					showPopup("danger", "Scolarité introuvable.");
					break;
				}
				document.getElementById("schooling_id").value =
					res.schooling_id;
				form.querySelector("[name='schooling_name']").value =
					res.schooling_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement de la scolarité."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.schoolings.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Scolarité modifiée avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-schooling/list-schooling.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – COURSES
		// ==========================
		case "add-school-course": {
			const form = document.getElementById("add-course-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.courses.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Cours ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-courses/list-school-course.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de l’ajout du cours."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-course": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.courses.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun cours trouvé</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell) totalCell.textContent = "0 cours enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.course_name}</td>
						<td class="list__row-item">${value.course_date_add}</td>
						<td class="list__row-item">
							<a href="edit-school-course.php?id=${
								value.course_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${
								value.course_id
							}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " cours enregistrés"
							: " cours enregistré");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce cours ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.courses.delete(
											id
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " cours enregistrés"
													: " cours enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des cours."
				);
			}
			break;
		}

		case "edit-school-course": {
			const form = document.querySelector("#edit-course-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le cours.");
				break;
			}

			try {
				const res = await GSC.API.settings.courses.get(id);
				if (!res || !res.course_id) {
					showPopup("danger", "Cours introuvable.");
					break;
				}
				document.getElementById("course_id").value = res.course_id;
				form.querySelector("[name='course_name']").value =
					res.course_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du cours."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.courses.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Cours modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-courses/list-school-course.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – ROLES
		// ==========================
		case "add-school-role": {
			const form = document.getElementById("add-role-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.roles.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Role ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-roles/list-school-role.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de l’ajout du role."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-role": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.roles.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun role trouvé</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell) totalCell.textContent = "0 role enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.role_name}</td>
						<td class="list__row-item">${value.role_date_add}</td>
						<td class="list__row-item">
							<a href="edit-school-role.php?id=${
								value.role_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.role_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1 ? " roles enregistrés" : " role enregistré");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce role ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.roles.delete(id);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " roles enregistrés"
													: " role enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des roles."
				);
			}
			break;
		}

		case "edit-school-role": {
			const form = document.querySelector("#edit-role-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le role.");
				break;
			}

			try {
				const res = await GSC.API.settings.roles.get(id);
				if (!res || !res.role_id) {
					showPopup("danger", "Role introuvable.");
					break;
				}
				document.getElementById("role_id").value = res.role_id;
				form.querySelector("[name='role_name']").value = res.role_name;
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du role."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.roles.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Role modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-roles/list-school-role.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – ACCESS
		// ==========================
		case "add-school-access": {
			const form = document.getElementById("add-access-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.access.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Droit ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-access/list-school-access.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de l’ajout du droit."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-school-access": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.access.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun droit trouvé</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell) totalCell.textContent = "0 droit enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.access_name}</td>
						<td class="list__row-item">${value.role_name}</td>
						<td class="list__row-item">${value.access_date_add}</td>
						<td class="list__row-item">
							<a href="edit-school-access.php?id=${
								value.access_id
							}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${
								value.access_id
							}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " droits enregistrés"
							: " droit enregistré");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce droit ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.access.delete(
											id
										);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " droits enregistrés"
													: " droit enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des droits."
				);
			}
			break;
		}

		case "edit-school-access": {
			const form = document.querySelector("#edit-access-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le droit.");
				break;
			}

			// load roles
			let roles = [];
			try {
				const resRoles = await fetch(
					"/gsc/backend/Models/SelectRole.php"
				);
				roles = await resRoles.json();
				const selectRole = form.querySelector("[name='role_id']");
				selectRole.innerHTML = "<option disabled>Rôle</option>";
				roles.forEach((role) => {
					const opt = document.createElement("option");
					opt.value = role.role_id;
					opt.textContent = role.role_name;
					selectRole.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des rôles.");
			}

			try {
				const res = await GSC.API.settings.access.get(id);
				if (!res || !res.access_id) {
					showPopup("danger", "Droit introuvable.");
					break;
				}
				document.getElementById("access_id").value = res.access_id;
				form.querySelector("[name='access_name']").value =
					res.access_name;
				// remplir la section si renvoyée
				if (form.querySelector("[name='access_section']")) {
					form.querySelector("[name='access_section']").value =
						res.access_section ?? "";
				}
				// remplir le role_id et role_access_id si fournis par l'API
				if (res.role_id) {
					form.querySelector("[name='role_id']").value = res.role_id;
				}
				if (
					res.role_access_id &&
					document.getElementById("role_access_id")
				) {
					document.getElementById("role_access_id").value =
						res.role_access_id;
				}
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du droit."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.access.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Droit modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-access/list-school-access.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		// ===============================
		// SETTINGS MANAGER – SCOLARITIES
		// ===============================
		case "list-scolarity": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const scolarities = await GSC.API.scolarities.list();

				if (!scolarities || scolarities.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucune liste de paiement trouvée</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell)
						totalCell.textContent = "0 paiement enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				scolarities.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");

					// Déterminer la classe de couleur selon le statut
					let statusClass = "warning";
					if (value.payment_status === "Non payé")
						statusClass = "danger";
					else if (value.payment_status === "Soldé")
						statusClass = "success";

					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.student_matricule}</td>
						<td class="list__row-item">${value.student_lastname}</td>
						<td class="list__row-item">${value.student_firstname}</td>
						<td class="list__row-item">${value.level_name}</td>
						<td class="list__row-item">${value.serie_name}</td>
						<td class="list__row-item">${value.room_name}</td>
						<td class="list__row-item">${value.year_name}</td>
						<td class="list__row-item">${value.parent_phone}</td>
						<td class="list__row-item">${value.amount_paid}</td>
						<td class="list__row-item">${value.amount_due}</td>
						<td class="list__row-item">${value.last_payment_date ?? "—"}</td>
						<td class="list__row-item ${statusClass}">${value.payment_status}</td>
						<td class="list__row-item">
							<a href="edit-scolarity.php?id=${value.student_id}" class="list__btn btn-edit">
								Payer
							</a>
						</td>
					`;

					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = scolarities.length;
					totalCell.textContent =
						total +
						(total > 1
							? " scolarités enregistrées"
							: " scolarité enregistrée");
				}
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des paiements."
				);
			}
			break;
		}

		case "edit-scolarity": {
			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");

			console.log("URL params:", window.location.search);
			console.log("id récupéré:", id);

			if (!id) return showPopup("danger", "Aucun élève sélectionné.");

			let data = null;

			try {
				const res = await GSC.API.scolarities.pay(id);

				if (!res.success) {
					showPopup("danger", res.message);
					return;
				}

				data = res.message;

				document.querySelector(".student__infos").innerHTML = `
						<tr class="infosline">
							<th class="infos">Matricule :</th>
							<td class="infos">${data.student_matricule}</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Nom :</th>
							<td class="infos">${data.student_lastname}</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Prénom(s) :</th>
							<td class="infos">${data.student_firstname}</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Montant Payé :</th>
							<td class="infos text-success">${data.amount_paid} FCFA</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Montant Dû :</th>
							<td class="infos text-danger">${data.amount_due} FCFA</td>
						</tr>
						<tr class="infosline">
							<th class="infos">Statut :</th>
							<td class="infos text-warning">${data.payment_status}</td>
						</tr>
					`;

				// Remplir les champs cachés
				document.getElementById("student_id").value = data.student_id;
				document.getElementById("schooling_id").value =
					data.schooling_id ?? 1; // par défaut si null
				document.getElementById("payement_mode").value = "Espèces";

				const select = document.getElementById("tranches");
				select.innerHTML = `<option disabled selected>Tranches</option>`;

				["tranche1", "tranche2", "tranche3"].forEach((t, i) => {
					if (data[t] && data[t] > 0) {
						const opt = document.createElement("option");
						opt.value = data[t];
						opt.textContent = `${i + 1}ᵉ tranche ............ ${
							data[t]
						} FCFA`;
						select.appendChild(opt);
					}
				});

				const optOther = document.createElement("option");
				optOther.value = "other";
				optOther.textContent = "Autre montant";
				select.appendChild(optOther);

				// Afficher le champ “Autre montant”
				const customAmount = document.getElementById("custom-amount");
				select.addEventListener("change", () => {
					customAmount.style.display =
						select.value === "other" ? "block" : "none";
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Erreur lors du chargement des informations."
				);
			}

			// Soumission du formulaire
			const form = document.getElementById("form-payement");
			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const select = document.getElementById("tranches");
				let amount = select.value;
				if (amount === "other")
					amount = document.getElementById("other-amount").value;

				const formData = new FormData(form);
				formData.set("payement_amount", amount);

				try {
					const result = await GSC.API.scolarities.add(formData);
					if (result.success) {
						showPopup(
							"success",
							"Paiement enregistré avec succès !"
						);

						// relire l'élève pour obtenir les montants et statut à jour
						try {
							// attend 300ms pour laisser la BD se stabiliser (optionnel)
							await new Promise((r) => setTimeout(r, 300));

							const fresh = await GSC.API.scolarities.pay(id);
							if (!fresh || !fresh.success) {
								// fallback : utilise 'data' local si pas de réponse
								console.warn(
									"Impossible de récupérer le détail mis à jour, utilisation des données locales."
								);
								// build minimal query from local variables (still safer than nothing)
								const trancheLabel =
									select.value === "other"
										? `Autre: ${amount}`
										: `${
												select.options[
													select.selectedIndex
												].text
										  }`;
								const qs = new URLSearchParams({
									nom: `${data.student_lastname} ${data.student_firstname}`,
									matricule: data.student_matricule,
									classe: `${data.level_name} ${data.room_name}`,
									annee: data.year_name,
									parent: data.parent_phone,
									tranche: trancheLabel,
									montant: amount,
									reste: data.amount_due, // not updated but best-effort
									mode: "Espèces",
									statut: data.payment_status,
									total: data.fee_amount,
									paye: data.amount_paid,
									solde: data.amount_due,
								});
								window.location.href = `/gsc/backend/Views/pages/scolarities/invoice/invoice.php?${qs.toString()}`;
								return;
							}

							// Normal path: fresh.success === true
							// Support both shapes: fresh.data or fresh.message (we saw both)
							const freshData =
								fresh.data ?? fresh.message ?? null;
							if (!freshData) {
								throw new Error("Réponse serveur mal formée");
							}

							// tranche label: if other, show amount; else use option text (safer)
							const trancheLabel =
								select.value === "other"
									? `Autre: ${Number(amount).toLocaleString(
											"fr-FR"
									  )}`
									: select.options[select.selectedIndex]
											?.text || select.value;

							// Ensure numeric formatting (remove decimals if .00)
							const format = (v) => {
								if (v == null) return "0";
								const n = Number(v);
								return Number.isNaN(n)
									? String(v)
									: n.toLocaleString("fr-FR", {
											maximumFractionDigits: 2,
											minimumFractionDigits: 0,
									  });
							};

							const qs2 = new URLSearchParams({
								nom: `${freshData.student_lastname} ${freshData.student_firstname}`,
								matricule: freshData.student_matricule,
								classe: `${
									freshData.level_name ?? data.level_name
								} ${freshData.room_name ?? data.room_name}`,
								annee: freshData.year_name ?? data.year_name,
								parent:
									freshData.parent_phone ?? data.parent_phone,
								tranche: trancheLabel,
								montant: format(amount),
								reste: format(
									freshData.amount_due ?? data.amount_due
								),
								mode: "Espèces",
								statut:
									freshData.payment_status ??
									data.payment_status,
								total: format(
									freshData.fee_amount ?? data.fee_amount
								),
								paye: format(
									freshData.amount_paid ?? data.amount_paid
								),
								solde: format(
									freshData.amount_due ?? data.amount_due
								),
							});

							// redirect vers invoice.php avec query proprement encodée
							window.location.href = `/gsc/backend/Views/pages/scolarities/invoice/invoice.php?${qs2.toString()}`;
						} catch (err) {
							console.error(
								"Erreur lors de récupération post-payment:",
								err
							);
							// fallback: redirect with local data (best-effort)
							const tryQs = new URLSearchParams({
								nom: `${data.student_lastname} ${data.student_firstname}`,
								matricule: data.student_matricule,
								classe: `${data.level_name} ${data.room_name}`,
								annee: data.year_name,
								parent: data.parent_phone,
								tranche:
									select.value === "other"
										? `Autre: ${amount}`
										: select.options[select.selectedIndex]
												?.text || select.value,
								montant: amount,
								reste: data.amount_due,
								mode: "Espèces",
								statut: data.payment_status,
								total: data.fee_amount,
								paye: data.amount_paid,
								solde: data.amount_due,
							});
							window.location.href = `/gsc/backend/Views/pages/scolarities/invoice/invoice.php?${tryQs.toString()}`;
						}
					} else {
						showPopup("danger", result.message);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau ou serveur.");
				}
			});
			break;
		}

		// ==========================
		// SETTINGS MANAGER – FEES
		// ==========================
		case "add-fee": {
			const form = document.getElementById("add-fee-form");
			if (!form) return;

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);

				try {
					const result = await GSC.API.settings.fees.add(formData);
					if (result.success) {
						showPopup(
							"success",
							result.message || "Frais ajouté avec succès."
						);
						form.reset();
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-fees/list-fee.php";
						}, 3000);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de l’ajout du frais."
						);
					}
				} catch (err) {
					console.error("Erreur du serveur", err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		case "list-fee": {
			const tbody = document.querySelector(".list__body");
			if (!tbody) return;

			try {
				const settings = await GSC.API.settings.fees.list();

				if (!settings || settings.length === 0) {
					tbody.innerHTML = `<tr><td colspan="14" class="list__row-item">Aucun frais trouvé</td></tr>`;
					const totalCell = document.querySelector(
						".list__footer .list__row-item[colspan]"
					);
					if (totalCell) totalCell.textContent = "0 frais enregistré";
					return;
				}

				tbody.innerHTML = "";
				let i = 1;

				settings.forEach((value) => {
					const tr = document.createElement("tr");
					tr.classList.add("list__row");
					tr.innerHTML = `
						<td class="list__row-item">${i++}</td>
						<td class="list__row-item">${value.schooling_name}</td>
						<td class="list__row-item">${value.level_name}</td>
						<td class="list__row-item">${value.fee_amount}</td>
						<td class="list__row-item">${value.tranche1}</td>
						<td class="list__row-item">${value.tranche2}</td>
						<td class="list__row-item">${value.tranche3}</td>
						<td class="list__row-item">${value.fee_date_add}</td>
						<td class="list__row-item">
							<a href="edit-fee.php?id=${value.fee_id}" class="list__btn btn-edit">Éditer</a>
						</td>
						<td class="list__row-item">
							<a href="" class="list__btn btn-delete" data-id="${value.fee_id}">Supprimer</a>
						</td>
					`;
					tbody.appendChild(tr);
				});

				const totalCell = document.querySelector(
					".list__footer .list__row-item[colspan]"
				);
				if (totalCell) {
					const total = settings.length;
					totalCell.textContent =
						total +
						(total > 1
							? " frais enregistrés"
							: " frais enregistré");
				}

				document.querySelectorAll(".btn-delete").forEach((btn) => {
					btn.addEventListener("click", (e) => {
						e.preventDefault();
						const id = btn.getAttribute("data-id");

						showConfirmPopup(
							"Êtes-vous sûr de vouloir supprimer ce frais ?",
							async () => {
								try {
									const result =
										await GSC.API.settings.fees.delete(id);
									if (result.success) {
										showPopup("success", result.message);
										btn.closest("tr").remove();

										const totalCell =
											document.querySelector(
												".list__footer .list__row-item[colspan]"
											);
										if (totalCell) {
											const newTotal =
												document.querySelectorAll(
													".list__body tr"
												).length;
											totalCell.textContent =
												newTotal +
												(newTotal > 1
													? " frais enregistrés"
													: " frais enregistré");
										}
									} else {
										showPopup("danger", result.message);
									}
								} catch (e) {
									console.error(e);
									showPopup("danger", "Erreur serveur.");
								}
							},
							() => {
								showPopup("warning", "Suppression annulée.");
							}
						);
					});
				});
			} catch (err) {
				console.error(err);
				showPopup(
					"danger",
					"Impossible de charger la liste des frais."
				);
			}
			break;
		}

		case "edit-fee": {
			const form = document.querySelector("#edit-fee-form");
			if (!form) return;

			const params = new URLSearchParams(window.location.search);
			const id = params.get("id");
			if (!id) {
				showPopup("danger", "Impossible de charger le frais.");
				break;
			}

			// load schoolings
			let schoolings = [];
			try {
				const resSchoolings = await fetch(
					"/gsc/backend/Models/SelectSchooling.php"
				);
				schoolings = await resSchoolings.json();
				const selectSchooing = form.querySelector(
					"[name='schooling_id']"
				);
				selectSchooing.innerHTML =
					"<option disabled>Type de scolarité</option>";
				schoolings.forEach((schooling) => {
					const opt = document.createElement("option");
					opt.value = schooling.schooling_id;
					opt.textContent = schooling.schooling_name;
					selectSchooing.appendChild(opt);
				});
			} catch (e) {
				showPopup(
					"danger",
					"Erreur lors du chargement des Types de scolarité."
				);
			}

			// load levels
			let levels = [];
			try {
				const resLevels = await fetch(
					"/gsc/backend/Models/SelectLevel.php"
				);
				levels = await resLevels.json();
				const selectLevel = form.querySelector("[name='level_id']");
				selectLevel.innerHTML = "<option disabled>Classe</option>";
				levels.forEach((level) => {
					const opt = document.createElement("option");
					opt.value = level.level_id;
					opt.textContent = level.level_name;
					selectLevel.appendChild(opt);
				});
			} catch (e) {
				showPopup("danger", "Erreur lors du chargement des classes.");
			}

			try {
				const res = await GSC.API.settings.fees.get(id);
				if (!res || !res.fee_id) {
					showPopup("danger", "Frais introuvable.");
					break;
				}
				document.getElementById("fee_id").value = res.fee_id;
				form.querySelector("[name='fee_amount']").value =
					res.fee_amount;
				form.querySelector("[name='tranche1']").value = res.tranche1;
				form.querySelector("[name='tranche2']").value = res.tranche2;
				form.querySelector("[name='tranche3']").value = res.tranche3;

				const selectSchooling = form.querySelector(
					"[name='schooling_id']"
				);
				selectSchooling.value = res.schooling_id;
				selectSchooling.dispatchEvent(new Event("change"));
			} catch (e) {
				console.error(e);
				showPopup(
					"danger",
					"Erreur du serveur lors du chargement du frais."
				);
			}

			form.addEventListener("submit", async (e) => {
				e.preventDefault();
				const formData = new FormData(form);
				try {
					const res = await GSC.API.settings.fees.update(
						id,
						formData
					);
					const result = await res;
					if (result.success) {
						showPopup(
							"success",
							result.message || "Frais modifié avec succès."
						);
						setTimeout(() => {
							window.location.href =
								"/gsc/backend/Views/pages/settings/school-fees/list-fee.php";
						}, 1500);
					} else {
						showPopup(
							"danger",
							result.message || "Erreur lors de la modification."
						);
					}
				} catch (err) {
					console.error(err);
					showPopup("danger", "Erreur réseau.");
				}
			});
			break;
		}

		default:
			console.log("Page inconnue :", page);
	}
});
