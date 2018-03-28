<?php
    include 'connectDatabase.php';

    $teamNumber = $_POST['TeamNumber'];
    $eventID = $_POST['EventID'];

    $stmt = $connection->prepare("UPDATE EventsRegistration SET Participating=0, TeamNumber=-1 WHERE EventID=? AND TeamNumber=?");
    $stmt->bind_param("si", $eventID, $teamNumber);

    $stmt->execute();

    if($stmt->affected_rows != -1) {
        echo "SUCCESS";
    }else{
        echo "FAILURE";
    }
    $stmt->close();
    $connection->close();
