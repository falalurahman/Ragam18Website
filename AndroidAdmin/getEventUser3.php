<?php
    include 'connectDatabase.php';

    $ragamID = $_POST['RagamID'];
    $eventID = $_POST['EventID'];

    $stmt = $connection->prepare("SELECT Name, College FROM Participants WHERE RagamID=?");
    $stmt->bind_param("s",$ragamID);

    $stmt->execute();
    $res = $stmt->bind_result($name, $college);
    $finalResult = array();
    if($stmt->fetch()){
      $finalResult['RagamID'] = $ragamID;
      $finalResult['Name'] = $name;
      $finalResult['College'] = $college;
    }
    $stmt->close();

    $stmt = $connection->prepare("SELECT ParticipantID FROM EventsRegistration WHERE EventID LIKE ? AND ParticipantID=?");
    $stmt->bind_param("ss", $eventID, $ragamID);

    $stmt->execute();

    $res = $stmt->bind_result($id);

    if($stmt->fetch()){
      $finalResult['Registered'] = 1;
    }else {
      $finalResult['Registered'] = 0;
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
