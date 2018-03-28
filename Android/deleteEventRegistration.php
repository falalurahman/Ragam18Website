<?php
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];
    $participantID = $_POST['ragam_id'];

    $stmt = $connection->prepare("DELETE FROM `EventsRegistration` WHERE `EventID` LIKE ? AND `ParticipantID` LIKE ?");
    $stmt->bind_param("ss",$eventID,$participantID);

    $stmt->execute();
    if($stmt->affected_rows == 1){
        echo "SUCCESS";
    }
    else{
        echo "FAILURE";
    }
    $stmt->close();
    $connection->close();