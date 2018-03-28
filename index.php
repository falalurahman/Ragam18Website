<?php

require_once 'php/Mobile_Detect.php';
$detect = new Mobile_Detect;

if(isset($_GET['events'])){
	if ( $detect->isMobile() || $detect->isTablet()) {
    		echo '<script>window.location.replace("./Mobile/#events");</script>';
	}else{
    		echo '<script>window.location.replace("./Main/#events");</script>';
	}
}else{
	if ( $detect->isMobile() || $detect->isTablet()) {
    		echo '<script>window.location.replace("./Mobile/");</script>';
	}else{
    		echo '<script>window.location.replace("./Main/");</script>';
	}
}