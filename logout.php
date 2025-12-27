<?php
session_start();
session_destroy(); // Détruit la session
header("Location: login.php"); // Renvoie vers le login
exit;
?>