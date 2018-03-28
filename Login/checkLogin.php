<?php

require_once "config.php";

if(!isset($_SESSION['access_token']) || !isset($_SESSION['ragam_id'])){
    $loginURL = $gClient->createAuthUrl();

    $result = array(
        'status'        => "Failure",
        'redirectUrl'   => $loginURL);
}else{
    $result = array(
        'status'    => "Success",
        'ragamId'   => $_SESSION['ragam_id']);
}

echo json_encode($result);