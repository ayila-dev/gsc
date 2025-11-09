<?php
include_once "checkLogin.php";
include_once "../partials/headerDashboard.php";
?>
<div class="wks" id="wks-box">
	<div class="header-wks" id="header-wks-box">
		<ul class="header-wks__menu--left menu-left" id="menu-left">
			<li class="menu-left__menu-left-item menu-left-item" id="user-item">
				MB
			</li>
			<li class="menu-left__menu-left-item menu-left-item user-dropdown-parent" id="user-email">
				utilisateur@gmail.com
			</li>
		</ul>

		<ul class="user-dropdown-menu" id="user-dropdown-menu">
			<li class="user-dropdown-item">Nom et Prénom</li>
			<li class="user-dropdown-item">Rôle</li>
			<a href="profil.php" class="user-dropdown-item-link">Profil</a>
		</ul>

		<ul class="header-wks__menu--center menu-center">
			<li class="menu-center__menu-center-item menu-center-item">
				Bienvenu dans GSC - Accès Facile à l'Éducation
			</li>
		</ul>

		<ul class="header-wks__menu--right menu-right">
			<li class="menu-right__menu-right-item menu-right-item">
				Paramètres
				<ul class="submenu">
					<li class="submenu-item">
						<span class="submenu-text">Années</span>
						<nav class="subitem-menu">
							<a href="settings/school-years/add-school-year.php" class="subitem-item">Ajouter une
								année</a>
							<a href="settings/school-years/list-school-year.php" class="subitem-item">Listes des
								années</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Centres</span>
						<nav class="subitem-menu">
							<a href="settings/school-places/add-school-place.php" class="subitem-item">Ajouter un
								centre</a>
							<a href="settings/school-places/list-school-place.php" class="subitem-item">Liste des
								centres</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Cycles</span>
						<nav class="subitem-menu">
							<a href="settings/school-cycles/add-school-cycle.php" class="subitem-item">Ajouter un
								cycle</a>
							<a href="settings/school-cycles/list-school-cycle.php" class="subitem-item">Liste des
								cycles</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Classes</span>
						<nav class="subitem-menu">
							<a href="settings/school-grades/add-school-grade.php" class="subitem-item">Ajouter
								une classe</a>
							<a href="settings/school-grades/list-school-grade.php" class="subitem-item">Liste des
								classes</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Séries</span>
						<nav class="subitem-menu">
							<a href="settings/school-series/add-school-serie.php" class="subitem-item">Ajouter
								une série</a>
							<a href="settings/school-series/list-school-serie.php" class="subitem-item">Liste des
								séries</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Matières</span>
						<nav class="subitem-menu">
							<a href="settings/school-courses/add-school-course.php" class="subitem-item">Ajouter
								une matière</a>
							<a href="settings/school-courses/list-school-course.php" class="subitem-item">Liste
								des matières</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Rôles</span>
						<nav class="subitem-menu">
							<a href="settings/school-roles/add-school-role.php" class="subitem-item">Ajouter un
								rôle</a>
							<a href="settings/school-roles/list-school-role.php" class="subitem-item">Liste des
								rôles</a>
						</nav>
					</li>
					<li class="submenu-item">
						<span class="submenu-text">Droits</span>
						<nav class="subitem-menu">
							<a href="settings/school-access/add-school-access.php" class="subitem-item">Ajouter
								un droit</a>
							<a href="settings/school-access/list-school-access.php" class="subitem-item">Liste
								des droits</a>
						</nav>
					</li>
				</ul>
			</li>
			<li class="menu-right__menu-right-item menu-right-item" id="logout">
				Déconnexion
			</li>
		</ul>
	</div>

	<div class="main-panel">
		<div class="form-container">

			<div class="form__header">
				<h1 class="form__title">Mon compte VHY92</h1>
			</div>

			<form action="" class="form__body">

				<div class="form__group">
					<label for="lastname" class="group__label">Nom : </label>
					<input type="text" name="lastname" placeholder="Nom" id="lastname"
						class="group__input lastname" required />
				</div>

				<div class="form__group">
					<label for="firstname" class="group__label">Prénom : </label>
					<input type="text" name="firstname" placeholder="Prénom" id="firstname"
						class="group__input firstname" required />
				</div>

				<div class="form__group">
					<label for="phone" class="group__label">Téléphone : </label>
					<input type="tel" name="phone" placeholder="Téléphone" id="phone" class="group__input"
						autocomplete="off" required />
				</div>

				<div class="form__group">
					<label for="email" class="group__label">Email : </label>
					<input type="email" name="email" placeholder="Adresse email" id="email" class="group__input"
						autocomplete="off" required />
				</div>

				<div class="form__group">
					<label for="sex" class="group__label">Sexe : </label>
					<select name="sex" id="sex" class="group__input">
						<option value="sex" disabled selected>Sexe</option>
						<option value="Masculin">Masculin</option>
						<option value="Féminin">Féminin</option>
					</select>
				</div>

				<div class="form__group">
					<label for="start-time" class="group__label">Heure de début : </label>
					<input type="text" name="start-time" placeholder="Heure de début (Ex : 07 : 00)"
						id="start-time" class="group__input" required />
				</div>

				<div class="form__group">
					<label for="end-time" class="group__label">Heure de fin : </label>
					<input type="text" name="end-time" placeholder="Heure de fin (Ex : 10 : 00)" id="end-time"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="course" class="group__label">Matière : </label>
					<select name="course" id="course" class="group__input">
						<option value="Matière" disabled selected>Matière</option>
						<option value="Français">Français</option>
						<option value="Anglais">Anglais</option>
						<option value="Histoire-Géographie">Histoire-Géographie</option>
						<option value="SVT">SVT</option>
					</select>
				</div>

				<div class="form__group">
					<label for="school-grade" class="group__label">Classe : </label>
					<select name="school-grade" id="school-grade" class="group__input">
						<option value="Classe" disabled selected>Classe</option>
						<option value="6ème">6ème</option>
						<option value="5ème">5ème</option>
						<option value="4ème">4ème</option>
						<option value="3ème">3ème</option>
					</select>
				</div>

				<div class="form__group">
					<label for="serie" class="group__label">Série : </label>
					<select name="serie" id="serie" class="group__input">
						<option value="Série" disabled selected>Série</option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
					</select>
				</div>

				<div class="form__group">
					<button type="submit" name="signup" class="group__button">création</button>
				</div>

			</form>

		</div>
	</div>


	<?php
	include_once ("../partials/footer.php");
	?>