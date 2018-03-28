<?php
    include 'connectDatabase.php';

    $eventID = $_POST['event_id'];
    $participantID = $_POST['ragam_id'];

    $stmt = $connection->prepare("SELECT ParticipantID FROM `EventsRegistration` WHERE EventID LIKE ? AND `ParticipantID` LIKE ?");
    $stmt->bind_param("ss",$eventID,$participantID);

    $stmt->execute();
    $res = $stmt->bind_result($ragamId);
    if($stmt->fetch()){
        echo "SUCCESS";
    }
    else{
        echo "FAILURE";
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
