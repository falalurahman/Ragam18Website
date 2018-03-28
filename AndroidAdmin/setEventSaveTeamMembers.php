<?php
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];
    $teamNumber = $_POST['TeamNumber'];
    $ragamIDList = $_POST['RagamIDList'];

    $stmt = $connection->prepare("UPDATE EventsRegistration SET Participating=1, TeamNumber=? WHERE EventID=? AND ParticipantID IN (".$ragamIDList.")");
    $stmt->bind_param("is", $teamNumber, $eventID);

    $stmt->execute();

    if($stmt->affected_rows != 1) {
        echo "SUCCESS";
    }else{
        echo "FAILURE";
    }
    $stmt->close();
    $connection->close();
