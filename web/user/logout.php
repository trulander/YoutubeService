<?php 
	require (dirname(__FILE__).'/../sys/db_user.php');
	unset($_SESSION['logged_user']);
	header("Location: /user/login.php");
?>
