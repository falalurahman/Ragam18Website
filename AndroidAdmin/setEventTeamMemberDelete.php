<?php
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];
    $ragamID = $_POST['RagamID'];

    $stmt = $connection->prepare("UPDATE EventsRegistration SET Participating=0, TeamNumber=-1 WHERE EventID=? AND ParticipantID=?");
    $stmt->bind_param("ss", $eventID, $ragamID);

    $stmt->execute();

    if($stmt->affected_rows != -1) {
        echo "SUCCESS";
    }else{
        echo "FAILURE";
    }
    $stmt->close();
    $connection->close();
