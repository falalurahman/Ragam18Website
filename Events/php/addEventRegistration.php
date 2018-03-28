<?php
    session_start();
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];
    $participantID = $_SESSION['ragam_id'];

    $stmt = $connection->prepare("INSERT INTO `EventsRegistration`(`EventID`, `ParticipantID`, `TeamNumber`, `Participating`) VALUES (?,?,-1,0)");
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
