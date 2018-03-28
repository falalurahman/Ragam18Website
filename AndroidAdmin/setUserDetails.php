<?php
    include 'connectDatabase.php';
        //mysqli_report(MYSQLI_REPORT_ALL);

    $oldRagamID = $_POST['OldRagamID'];
    $newRagamID = $_POST['NewRagamID'];
    $name = $_POST['Name'];
    $college = $_POST['College'];
    $phonenumber = $_POST['PhoneNumber'];

    $updated = 0;

    $stmt = $connection->prepare("UPDATE Participants SET RagamID=?, Name=?, College=?, PhoneNumber=? WHERE RagamID=?");
    $stmt->bind_param("sssss", $newRagamID, $name, $college, $phonenumber, $oldRagamID);
    $stmt->execute();
    if($stmt->affected_rows != -1) {
        $updated++;
    }
    $stmt->close();

    $stmt = $connection->prepare("UPDATE EventsRegistration SET ParticipantID=? WHERE ParticipantID=?");
    $stmt->bind_param("ss", $newRagamID, $oldRagamID);
    $stmt->execute();
    if($stmt->affected_rows != -1) {
        $updated++;
    }
    $stmt->close();

    $stmt = $connection->prepare("UPDATE MerchandiseRegistration SET ParticipantID=? WHERE ParticipantID=?");
    $stmt->bind_param("ss", $newRagamID, $oldRagamID);
    $stmt->execute();
    if($stmt->affected_rows != -1) {
        $updated++;
    }
    $stmt->close();

    $stmt = $connection->prepare("UPDATE ProshowRegistration SET ParticipantID=? WHERE ParticipantID=?");
    $stmt->bind_param("ss", $newRagamID, $oldRagamID);
    $stmt->execute();
    if($stmt->affected_rows != -1) {
        $updated++;
    }
    $stmt->close();

    $stmt = $connection->prepare("UPDATE WorkshopRegistration SET ParticipantID=? WHERE ParticipantID=?");
    $stmt->bind_param("ss", $newRagamID, $oldRagamID);
    $stmt->execute();
    if($stmt->affected_rows != -1) {
        $updated++;
    }
    $stmt->close();

    if($updated == 5){
      echo "SUCCESS";
    }else {
      echo "FAILURE";
    }

    $connection->close();
