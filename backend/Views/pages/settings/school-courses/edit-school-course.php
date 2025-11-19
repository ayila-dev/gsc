<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/../../checkLogin.php";
	include_once __DIR__ . "/../../../partials/header.php";
?>

	<div class="main-panel">
		
		<div class="form-container">

			<div class="main__header">
				<h1 class="form__title">Modifier une matière</h1>
				<a href="list-school-course.php" class="btn__add" title="Liste des matières">&#8801;</a>
			</div>

			<form action="" method="POST" class="form__body" id="edit-course-form">

				<div class="form__group">
					<label for="course_id" class="group__label">Matière : </label>
					<input type="text" name="course_id" placeholder="Matière" id="course_id"
						class="group__input field-hidden" required />
				</div>

				<div class="form__group">
					<label for="course_name" class="group__label">Matière : </label>
					<input type="text" name="course_name" placeholder="Matière" id="course_name"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="course_coef" class="group__label">Cœfficient : </label>
					<input type="number" name="course_coef" placeholder="Cœfficient" id="course_coef"
						class="group__input" required />
				</div>

				<div class="form__group">
					<label for="level_id" class="group__label">Classe : </label>
					<select name="level_id" id="level_id" class="group__input"></select>
				</div>

				<div class="form__group">
					<button type="submit" name="edit" class="group__button">Édition</button>
				</div>

			</form>

		</div>
	</div>

<?php
	include_once __DIR__ . "/../../../partials/footer.php";
?>