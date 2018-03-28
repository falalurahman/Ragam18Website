<?php
    include 'connectDatabase.php';

    $participantID = $_POST['ragam_id'];
    $workshopID = $_POST['WorkshopID'];

    $stmt = $connection->prepare("SELECT `ParticipantID` FROM `WorkshopRegistration` WHERE WorkshopID LIKE ? AND `ParticipantID` LIKE ?");
    $stmt->bind_param("ss",$workshopID,$participantID);

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