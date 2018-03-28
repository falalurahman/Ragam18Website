<?php
    include 'connectDatabase.php';

    $ragamID = $_POST['RagamID'];
    $workshopID = $_POST['WorkshopID'];

    $stmt = $connection->prepare("UPDATE WorkshopRegistration SET Participating=1 WHERE WorkshopID=? AND ParticipantID=?");
    $stmt->bind_param("ss", $workshopID, $ragamID);

    $stmt->execute();

    if($stmt->affected_rows != -1) {
        echo "SUCCESS";
    }else{
        echo "FAILURE";
    }
    $stmt->close();
    $connection->close();
