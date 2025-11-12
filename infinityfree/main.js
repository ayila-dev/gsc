import { showCustomFieldAmount } from "./lib.js";
import { gradeEditor } from "./lib.js";
import { userDropdownMenu } from "./lib.js";
import { logoutUser } from "./lib.js";
import { selectUserRole } from "./lib.js";
import { selectSchooing } from "./lib.js";
import { selectLevel } from "./lib.js";
import { selectPlace } from "./lib.js";
import { selectCourse } from "./lib.js";
import { selectSerie } from "./lib.js";
import { selectYear } from "./lib.js";
import { selectCycle } from "./lib.js";
import { selectRoom } from "./lib.js";
import { selectTeacher } from "./lib.js";
import { selectParent } from "./lib.js";
import { currentLinkSidebar } from "./lib.js";
import { toggleContainerOnOptionText } from "./lib.js";

/**
 * Main script for the GSC application
 * Handles page-specific functionality based on the current URL path
 */

const setBodyDataPageFromPath = () => {
	if (!document || !document.body) return;
	// Ne pas écraser si data-page déjà défini côté serveur
	if (document.body.dataset.page && document.body.dataset.page.trim() !== "")
		return;

	const pathname = window.location.pathname || "";
	const parts = pathname.split("/").filter(Boolean);
	if (parts.length === 0) return;

	let last = parts[parts.length - 1];

	// Si l'URL se termine par un dossier (pas de fichier), prends le dernier dossier
	if (!last.includes(".")) {
		last = parts[parts.length - 1] || "";
	} else {
		// enlève l'extension si présente
		last = last.split(".")[0];
	}

	// fallback : si vide, prends 'dashboard'
	const slug = last || "dashboard";
	document.body.dataset.page = slug;
};

document.addEventListener("DOMContentLoaded", (e) => {
	let path = window.location.pathname;

	// initialise data-page automatiquement
	try {
		setBodyDataPageFromPath();
	} catch (err) {
		console.error("Erreur setBodyDataPageFromPath:", err);
	}

	// met à jour le lien actif dans le sidebar
	try {
		currentLinkSidebar();
	} catch (err) {
		console.error("Erreur currentLinkSidebar:", err);
	}

	switch (path) {
		/**
		 * Page index
		 */
		case "":
		case "/":
		case "/index":
		case "/index.php":
			console.log("Page de connexion");
			break;

		case "/backend/Views/pages/firstConnection.php":
			console.log("Page de première connexion");
			break;

		/**
		 * Page center
		 * to choose center user want to connect
		 */
		case "/backend/Views/pages/place.php":
			selectYear();
			selectCycle();
			logoutUser();
			console.log("Page de choix du centre");
			break;

		case "/backend/Views/pages/place.php/":
			selectYear();
			selectCycle();
			logoutUser();
			console.log("Page de choix du centre");
			break;

		/**
		 * Pages of personals
		 */
		case "/backend/Views/pages/personals/add-personal.php":
			userDropdownMenu();
			selectPlace();
			selectUserRole();
			logoutUser();
			console.log("Page d'ajout d'un personnel");
			break;

		case "/backend/Views/pages/personals/edit-personal.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page de mise à jour d'un personnel");
			break;

		case "/backend/Views/pages/personals/list-personal.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage des personnels");
			break;

		/**
		 * Pages of professors
		 */
		case "/backend/Views/pages/teachers/add-teacher.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'un professeur");
			break;

		case "/backend/Views/pages/teachers/edit-teacher.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un professeur");
			break;

		case "/backend/Views/pages/teachers/list-teacher.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des professeurs");
			break;

		/**
		 * Pages of parents
		 */
		case "/backend/Views/pages/parents/add-parent.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'un parent");
			break;

		case "/backend/Views/pages/parents/edit-parent.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un parent");
			break;

		case "/backend/Views/pages/parents/list-parent.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des parents");
			break;

		/**
		 * Pages of students
		 */
		case "/backend/Views/pages/students/add-student.php":
			userDropdownMenu();
			selectPlace();
			selectLevel();
			selectSerie();
			selectRoom();
			selectParent();
			logoutUser();
			console.log("Page d'inscription d'un élève");
			break;

		case "/backend/Views/pages/students/reinscription-student.php":
			userDropdownMenu();
			selectPlace();
			selectLevel();
			selectSerie();
			selectRoom();
			selectParent();
			logoutUser();
			console.log("Page de reinscription d'un élève");
			break;

		case "/backend/Views/pages/students/edit-student.php":
			userDropdownMenu();
			selectPlace();
			selectLevel();
			selectSerie();
			selectRoom();
			selectParent();
			logoutUser();
			console.log("Page d'édition d'un utilisateur");
			break;

		case "/backend/Views/pages/students/list-student.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des élèves");
			break;

		/**
		 * Pages of schedules
		 */
		case "/backend/Views/pages/schedules/add-schedule.php":
			userDropdownMenu();
			selectTeacher();
			selectPlace();
			selectCourse();
			selectLevel();
			selectRoom();
			selectSerie();
			logoutUser();
			console.log("Page d'ajout d'un programme");
			break;

		case "/backend/Views/pages/schedules/edit-schedule.php":
			userDropdownMenu();
			selectTeacher();
			selectPlace();
			selectCourse();
			selectLevel();
			selectRoom();
			selectSerie();
			logoutUser();
			console.log("Page d'édition d'un programme");
			break;

		case "/backend/Views/pages/schedules/list-schedule.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des programmes");
			break;

		case "/backend/Views/pages/schedules/timetable/generate-timetable.php":
			userDropdownMenu();
			selectLevel();
			selectSerie();
			selectRoom();
			logoutUser();
			console.log("Page de génération de l'emploi du temps");
			break;

		case "/backend/Views/pages/schedules/timetable/timetable.php":
			console.log("Page de génération de l'emploi du temps");
			break;

		/**
		 * Pages of scolarities
		 */
		case "/backend/Views/pages/scolarities/edit-scolarity.php":
			userDropdownMenu();
			logoutUser();
			showCustomFieldAmount();
			console.log("Page d'édition de la scolarités d'un élève");
			break;

		case "/backend/Views/pages/scolarities/list-scolarity.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la gestion des scolarités");
			break;

		/**
		 * Pages of grades
		 */
		case "/backend/Views/pages/grades/order-grade.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page de demande d'ajout des notes");
			break;

		case "/backend/Views/pages/grades/edit-list-grade.php":
			userDropdownMenu();
			logoutUser();
			gradeEditor();
			console.log("Page d'édition et d'affichage des notes");
			break;

		case "/backend/Views/pages/grades/add-grade.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout des notes");
			break;

		case "/backend/Views/pages/grades/report-card/generate-report-card.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page de génération des bulletins des notes");
			break;

		/**
		 * Page profil
		 */
		case "/backend/Views/pages/profil.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page de profil");
			break;

		/**
		 * Settings pages
		 * Pages of school-years
		 */
		case "/backend/Views/pages/settings/school-years/add-school-year.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'une année scolaire");
			break;

		case "/backend/Views/pages/settings/school-years/edit-school-year.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition de l'année scolaire");
			break;

		case "/backend/Views/pages/settings/school-years/list-school-year.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des années scolaires");
			break;

		/**
		 * Pages of school-places
		 */
		case "/backend/Views/pages/settings/school-places/add-school-place.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'un centre");
			break;

		case "/backend/Views/pages/settings/school-places/edit-school-place.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un centre");
			break;

		case "/backend/Views/pages/settings/school-places/list-school-place.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des centres");
			break;

		/**
		 * Pages of school-cycle
		 */
		case "/backend/Views/pages/settings/school-cycles/add-school-cycle.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'un cycle");
			break;

		case "/backend/Views/pages/settings/school-cycles/edit-school-cycle.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un cycle");
			break;

		case "/backend/Views/pages/settings/school-cycles/list-school-cycle.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des cycles");
			break;

		/**
		 * Pages of school-grades
		 */
		case "/backend/Views/pages/settings/school-grades/add-school-grade.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'une classe");
			break;

		case "/backend/Views/pages/settings/school-grades/edit-school-grade.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'une classe");
			break;

		case "/backend/Views/pages/settings/school-grades/list-school-grade.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des classes");
			break;

		/**
		 * Pages of school-rooms
		 */
		case "/backend/Views/pages/settings/school-rooms/add-school-room.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'une salle");
			break;

		case "/backend/Views/pages/settings/school-rooms/edit-school-room.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'une salle");
			break;

		case "/backend/Views/pages/settings/school-rooms/list-school-room.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des salles");
			break;

		/**
		 * Pages of school-series
		 */
		case "/backend/Views/pages/settings/school-series/add-school-serie.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'une série");
			break;

		case "/backend/Views/pages/settings/school-series/edit-school-serie.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'une série");
			break;

		case "/backend/Views/pages/settings/school-series/list-school-serie.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des séries");
			break;

		/**
		 * Pages of school-courses
		 */
		case "/backend/Views/pages/settings/school-courses/add-school-course.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'une matière");
			break;

		case "/backend/Views/pages/settings/school-courses/edit-school-course.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'une matière");
			break;

		case "/backend/Views/pages/settings/school-courses/list-school-course.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des matières");
			break;

		/**
		 * Pages of school-roles
		 */
		case "/backend/Views/pages/settings/school-roles/add-school-role.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'un rôle");
			break;

		case "/backend/Views/pages/settings/school-roles/edit-school-role.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un rôle");
			break;

		case "/backend/Views/pages/settings/school-roles/list-school-role.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des rôles");
			break;

		/**
		 * Pages of school-access
		 */
		case "/backend/Views/pages/settings/school-access/add-school-access.php":
			userDropdownMenu();
			selectUserRole();
			logoutUser();
			console.log("Page d'ajout d'un droit");
			break;

		case "/backend/Views/pages/settings/school-access/edit-school-access.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un droit");
			break;

		case "/backend/Views/pages/settings/school-access/list-school-access.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des droits");
			break;

		/**
		 * Pages of school-schooling
		 */
		case "/backend/Views/pages/settings/school-schooling/add-schooling.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'ajout d'un type de scolarité");
			break;

		case "/backend/Views/pages/settings/school-schooling/edit-schooling.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'édition d'un type de scolarité");
			break;

		case "/backend/Views/pages/settings/school-schooling/list-schooling.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des type de scolarités");
			break;

		/**
		 * Pages of school-fees
		 */
		case "/backend/Views/pages/settings/school-fees/add-fee.php":
			userDropdownMenu();
			selectSchooing();
			selectLevel();
			toggleContainerOnOptionText(
				"schooling_id",
				"tranches-container",
				"contribution"
			);
			logoutUser();
			console.log("Page d'ajout d'un frais de scolarité");
			break;

		case "/backend/Views/pages/settings/school-fees/edit-fee.php":
			userDropdownMenu();
			toggleContainerOnOptionText(
				"schooling_id",
				"tranches-container",
				"contribution"
			);
			logoutUser();
			console.log("Page d'édition d'un frais de scolarité");
			break;

		case "/backend/Views/pages/settings/school-fees/list-fee.php":
			userDropdownMenu();
			logoutUser();
			console.log("Page d'affichage de la liste des frais de scolarités");
			break;

		/**
		 * Pages of Dashboard landing
		 */
		case "/backend/Views/pages/dashboard.php":
			userDropdownMenu();
			logoutUser();
			console.log("Dashboard accueil");
			break;

		/**
		 * Pages of error 404
		 */
		default:
			console.error("Page inconnue:", window.location.pathname);
			break;
	}
});
