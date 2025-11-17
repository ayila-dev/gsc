<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once __DIR__ . "/checkLogin.php";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<link rel="stylesheet" href="../../../public/assets/css/app.css" />
		<link rel="shortcut icon" href="../../../public/assets/images/gsc-logo.png" />
		<script src="../../../public/assets/js/crud.js" defer></script>
		<script src="../../../public/assets/js/api-crud.js" type="module" defer></script>
		<script src="../../../public/assets/js/main.js" type="module" defer></script>
	</head>
	<body data-page="school-session">
		<header class="header-page">
			<h1 class="header__title">
				Choisissez le centre auquel vous souhaitez vous connecter
			</h1>
			<button type="button" class="exit" id="logout">Quitter</button>
		</header>
		<main>
			<?php if($_SESSION['role_name'] !== "Enseignant") {  ?>
				<section class="content">
					<div class="session">
						<form action="<?php echo 'checkSchool.php' ?>" class="school-session" method="POST" id="school-session-form">
							<h2 class="form__title"><?php echo $_SESSION['place_name']; ?></h2>

							<div class="form__group">
								<label for="year_id" class="group__label">Année Scolaire :</label>
								<select
									name="year_id"
									id="year_id"
									class="group__input"
								></select>
							</div>

							<div class="form__group">
								<label for="cycle_id" class="group__label">Cycle Scolaire :</label>
								<select
									name="cycle_id"
									id="cycle_id"
									class="group__input"
								></select>
							</div>

							<div class="form__group">
								<button
									type="submit"
									name="connect"
									class="group__button"
								>
									Connexion
								</button>
							</div>
						</form>
					</div>
				</section>
			<?php 
				} elseif ($_SESSION['role_name'] === "Enseignant") { 
			?>
				<section class="content"></section>
			<?php } ?>
		</main>
		<footer class="footer-page">
			<p class="footer-content">&copy; 2023 GSC. All rights reserved.</p>
		</footer>
	</body>
</html>
