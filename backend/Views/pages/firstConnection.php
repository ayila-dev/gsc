<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>gsc</title>
	<link rel="stylesheet" href="../../../public/assets/css/app.css" />
	<link rel="shortcut icon" href="../../../public/assets/images/gsc-logo.png" type="image/x-icon">
	<script src="../../../public/assets/js/crud.js" defer></script>
	<script src="../../../public/assets/js/api-crud.js" type="module" defer></script>
	<script src="../../../public/assets/js/main.js" type="module" defer></script>
</head>

<body data-page="first-connection">
	<div class="login-box">
		<div class="login-container">
			<div class="form__header">
				<img src="../../../public/assets/images/gsc-logo.png" alt="logo" class="form__logo" />
				<h1 class="form__title">Connectez-vous</h1>
			</div>

			<p class="form__title">Changez votre mot de passe pour continuer</p>

			<form method="POST" class="form__body" id="form">
				
				<div class="form__group">
					<label for="user_password_change" class="group__label">Entrez un nouveau mot de passe :</label>
					<input type="password" name="user_password_change" placeholder="Entrez un nouveau mot de passe" class="group__input"
						id="user_password_change" required autocomplete="off" />
				</div>

				<div class="form__group">
					<label for="user_password_confirm" class="group__label">Confirmer le mot de passe :</label>
					<input type="password" name="user_password_confirm" placeholder="Confirmer le mot de passe" class="group__input"
						id="user_password_confirm" required autocomplete="off" />
				</div>

				<div class="form__group">
					<button type="submit" name="login" class="group__button" id="login">
						VALIDER
					</button>
				</div>
			</form>
		</div>
	</div>
</body>

</html>