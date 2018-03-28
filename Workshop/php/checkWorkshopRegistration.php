<?php
    session_start();
    include 'connectDatabase.php';

    $participantID = $_SESSION['ragam_id'];

    $stmt = $connection->prepare("SELECT `WorkshopID` FROM `WorkshopRegistration` WHERE `ParticipantID`=?");
    $stmt->bind_param("s",$participantID);

    $stmt->execute();
    $res = $stmt->bind_result($workshopId);
    $finalResult = array();
    while($stmt->fetch()){
        array_push($finalResult,$workshopId);
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();