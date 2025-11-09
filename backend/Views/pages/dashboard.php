<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	include_once __DIR__ . "/checkLogin.php";
	include_once __DIR__ . "/../partials/header.php";
?>

	<div class="main-panel">
		<h1>
			Bienvenu dans ton espace de travail 
			<?php echo $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']; ?> !
		</h1>
	</div>

<?php
	include_once __DIR__ . "/../partials/footer.php";
?>