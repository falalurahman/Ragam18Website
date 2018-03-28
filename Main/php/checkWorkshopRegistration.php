<?php
    session_start();
    include 'connectDatabase.php';

    $participantID = $_SESSION['ragam_id'];

    $stmt = $connection->prepare("SELECT `ParticipantID` FROM `WorkshopRegistration` WHERE `ParticipantID` LIKE ?");
    $stmt->bind_param("s",$participantID);

    $stmt->execute();
    $res = $stmt->bind_result($ragamId);
    if($stmt->fetch()){
        echo "SUCCESS";
    }
    else{
        echo "FAILURE";
    }
    $stmt->close();
    $connection->close();