<?php
	require_once "config.php";
	unset($_SESSION['access_token']);
	session_destroy();
	echo '<script>window.history.go(-1);</script>';
	exit();
?>