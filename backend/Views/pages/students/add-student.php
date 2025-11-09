<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/../checkLogin.php";
	include_once __DIR__ . "/../../partials/header.php";
?>

	<div class="main-panel">
		<div class="form-container">

			<div class="form__header">
				<h1 class="form__title">Inscrire un élève</h1>
			</div>

			<form class="form__body" id="add-student-form" method="POST">

				<div class="form__group">
					<label for="user_lastname" class="group__label">Nom de l'élève : </label>
					<input type="text" name="user_lastname" placeholder="Nom de l'élève" id="user_lastname"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="user_firstname" class="group__label">Prénom de l'élève : </label>
					<input type="text" name="user_firstname" placeholder="Prénom de l'élève" id="user_firstname"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="user_birth_date" class="group__label">Date de naissance : </label>
					<input type="date" name="user_birth_date" id="user_birth_date" class="group__input" required />
				</div>

				<div class="form__group">
					<label for="user_sex" class="group__label">Sexe : </label>
					<select name="user_sex" id="user_sex" class="group__input">
						<option value="sexe" disabled selected>Sexe</option>
						<option value="Masculin">Masculin</option>
						<option value="Féminin">Féminin</option>
					</select>
				</div>

				<div class="form__group">
					<label for="user_phone" class="group__label">Téléphone : </label>
					<input type="tel" name="user_phone" placeholder="Téléphone" id="user_phone" class="group__input"
						autocomplete="off" required />
				</div>

				<div class="form__group">
					<label for="user_email" class="group__label">Email : </label>
					<input type="email" name="user_email" placeholder="Adresse email" id="user_email" class="group__input"
						autocomplete="off" required />
				</div>

				<div class="form__group">
					<label for="parent_id" class="group__label">Parent :</label>
					<select name="parent_id" id="parent_id" class="group__input" required></select>
				</div>

				<div class="form__group">
					<label for="place_id" class="group__label">Centre : </label>
					<select name="place_id" id="place_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<label for="level_id" class="group__label">Classe : </label>
					<select name="level_id" id="level_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<label for="serie_id" class="group__label">Série : </label>
					<select name="serie_id" id="serie_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<label for="room_id" class="group__label">Salle : </label>
					<select name="room_id" id="room_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<button type="submit" name="add" class="group__button">Inscription</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../partials/footer.php";
?>