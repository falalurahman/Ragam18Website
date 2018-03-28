<?php
    include 'connectDatabase.php';

    $ragamID = $_POST['RagamID'];

    $stmt = $connection->prepare("SELECT Name, College, Email, PhoneNumber FROM Participants WHERE RagamID=?");
    $stmt->bind_param("s",$ragamID);

    $stmt->execute();
    $res = $stmt->bind_result($name, $college, $email, $phonenumber);
    $finalResult = array();
    if($stmt->fetch()){
      $finalResult['RagamID'] = $ragamID;
      $finalResult['Name'] = $name;
      $finalResult['College'] = $college;
      $finalResult['Email'] = $email;
      $finalResult['PhoneNumber'] = $phonenumber;
    }else {
      echo "FAILURE";
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
