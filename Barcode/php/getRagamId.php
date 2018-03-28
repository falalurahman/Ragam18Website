<?php

session_start();

if(!isset($_SESSION['access_token']) || !isset($_SESSION['ragam_id'])){
    echo 'False';
}else{
    echo $_SESSION['ragam_id'];
}