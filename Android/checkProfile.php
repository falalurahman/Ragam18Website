<?php
include "connectDatabase.php";
$email = $_POST['email'];

$stmt = $connection->prepare("SELECT RagamID FROM Participants WHERE Email=?");
$stmt->bind_param("s",$email);
$stmt->execute();

$stmt->bind_result($ragamId);
if( $stmt->fetch() ){
    $result = array(
            "status"=>"SUCCESS",
            "ragamId"=>$ragamId
        );
    echo json_encode($result);
}else{
    $result = array(
        "status"=>"FAILURE"
    );
    echo json_encode($result);
}