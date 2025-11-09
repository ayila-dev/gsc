<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>gsc</title>
	<link rel="stylesheet" href="./public/assets/css/app.css" />
	<link rel="shortcut icon" href="./public/assets/images/gsc-logo.png" type="image/x-icon">
	<script src="./public/assets/js/crud.js" defer></script>
	<script src="./public/assets/js/api-crud.js" type="module" defer></script>
	<script src="./public/assets/js/main.js" type="module" defer></script>
</head>

<body data-page="index">
	<div class="login-box">
		<div class="login-container">
			<div class="form__header">
				<img src="./public/assets/images/gsc-logo.png" alt="logo" class="form__logo" />
				<h1 class="form__title">Connectez-vous</h1>
			</div>

			<p class="form__title">Entrez vos identifiants pour vous connectez</p>

			<form method="POST" class="form__body" id="form">
				<div class="form__group">
					<label for="user_email" class="group__label">Email : </label>
					<input type="email" name="user_email" placeholder="Adresse email" class="group__input" id="user_email"
						required autocomplete="off" />
				</div>

				<div class="form__group">
					<label for="user_password" class="group__label">Mot de passe :</label>
					<input type="password" name="user_password" placeholder="Mot de passe" class="group__input"
						id="user_password" required autocomplete="off" />
				</div>

				<div class="form__group">
					<button type="submit" name="login" class="group__button" id="login">
						Connexion
					</button>
				</div>
			</form>
		</div>
	</div>
</body>

</html>