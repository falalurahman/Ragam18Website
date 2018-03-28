<?php
    include 'connectDatabase.php';

    $ragamID = $_POST['RagamID'];
    $eventID = $_POST['EventID'];

    $stmt = $connection->prepare("SELECT Name, College, MainRegistration FROM Participants WHERE RagamID=?");
    $stmt->bind_param("s",$ragamID);

    $stmt->execute();
    $res = $stmt->bind_result($name, $college, $mainreg);
    $finalResult = array();
    if($stmt->fetch()){
      $finalResult['RagamID'] = $ragamID;
      $finalResult['Name'] = $name;
      $finalResult['College'] = $college;
      if($mainreg == 1){
        $finalResult['Registered'] = 1;
      }else {
        $finalResult['Registered'] = 0;
      }
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
