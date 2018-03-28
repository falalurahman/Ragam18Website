<?php
	session_start();
	require_once "vendor/autoload.php";
    
	$gClient = new Google_Client();
	$gClient->setClientId("857369032092-36qltoii0gafbq0m45b4b46rsahh9i7d.apps.googleusercontent.com");
	$gClient->setClientSecret("sPbpSaWgMor0WhyM3jxImlXg");
	$gClient->setApplicationName("Ragam Login");
	$gClient->setRedirectUri("http://ragam.org.in/Login/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
      
?>
