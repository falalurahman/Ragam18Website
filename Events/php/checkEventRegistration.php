<?php
    session_start();
    include 'connectDatabase.php';

    $participantID = $_SESSION['ragam_id'];

    $stmt = $connection->prepare("SELECT `EventID` FROM `EventsRegistration` WHERE `ParticipantID` LIKE ?");
    $stmt->bind_param("s",$participantID);

    $stmt->execute();
    $res = $stmt->bind_result($eventId);
    $finalResult = array();
    while($stmt->fetch()){
        array_push($finalResult,$eventId);
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
