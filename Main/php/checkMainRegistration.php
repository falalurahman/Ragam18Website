<?php
    session_start();
    include 'connectDatabase.php';

    $participantID = $_SESSION['ragam_id'];

    $stmt = $connection->prepare("SELECT `RagamID` FROM `Participants` WHERE `RagamID` LIKE ? AND `MainRegistration` = 1");
    $stmt->bind_param("s",$participantID);

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