<?php
    session_start();
    include "connectDatabase.php";
    $participantID = $_SESSION['ragam_id'];
    //$participantID = 'RID00502';

    $stmt = $connection->prepare("SELECT MainRegistration, HospitalityRegistration FROM `Participants` WHERE `RagamID` LIKE ?");
    $stmt->bind_param("s",$participantID);
    $stmt->execute();

    $stmt->bind_result($mainRegistration,$hospitalityRegistration);
    $finalResult = array();
    if($stmt->fetch()){
        if($mainRegistration == 1){
            array_push($finalResult,'MainReg');
        }
        if($hospitalityRegistration == 1){
            array_push($finalResult,'HospiReg');
        }
    }
    $stmt->close();

    $stmt = $connection->prepare("SELECT WorkshopID FROM WorkshopRegistration WHERE `ParticipantID` LIKE ?");
    echo mysqli_error($connection);
    $stmt->bind_param("s",$participantID);
    $stmt->execute();

    $stmt->bind_result($workshopId);
    while($stmt->fetch()){
        array_push($finalResult,$workshopId);
    }
    $stmt->close();

    $stmt = $connection->prepare("SELECT ProshowID FROM ProshowRegistration WHERE `ParticipantID` LIKE ?");
    $stmt->bind_param("s",$participantID);
    $stmt->execute();

    $stmt->bind_result($proshowId);
    while($stmt->fetch()){
        if($proshowId == 'PID04'){
            array_push($finalResult,'PID01');
            array_push($finalResult,'PID02');
            array_push($finalResult,'PID03');
        }else{
            array_push($finalResult,$proshowId);
        }
    }
    $stmt->close();

    $stmt = $connection->prepare("SELECT MerchandiseID FROM MerchandiseRegistration WHERE `ParticipantID` LIKE ?");
    $stmt->bind_param("s",$participantID);
    $stmt->execute();

    $stmt->bind_result($merchandiseId);
    while($stmt->fetch()){
        array_push($finalResult,$merchandiseId);
    }
    $stmt->close();

    echo json_encode($finalResult);
    $connection->close();

