<?php
if (session_status() === PHP_SESSION_NONE) {
     session_start();
}

if (!$_SESSION['user_id']) {
     header("location: ../../../../index.php");
}

if ($_SERVER['REQUEST_URI'] === "/gsc/backend/Views/pages/profil.php") {
     if (!$_SESSION['user_id']) {
          header("location: ../../../index.php");
     }
} elseif ($_SERVER['REQUEST_URI'] === "/gsc/backend/Views/pages/dashboard.php") {
     if (!$_SESSION['user_id']) {
          header("location: ../../../index.php");
     }
} else {
     if (!$_SESSION['user_id']) {
          header("location: ../../../index.php");
     }
}

// echo var_dump($_SERVER);
