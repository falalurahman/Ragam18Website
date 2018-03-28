<?php
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];
    $teamNumber = $_POST['TeamNumber'];

    $stmt = $connection->prepare("SELECT A.RagamID, A.Name, A.College, A.PhoneNumber FROM Participants A, EventsRegistration B WHERE B.EventID LIKE ? AND A.RagamID=B.ParticipantID AND B.Participating=1 AND B.TeamNumber=?");
    $stmt->bind_param("si", $eventID, $teamNumber);

    $stmt->execute();
    $res = $stmt->bind_result($ragamId, $name, $college, $phonenumber);
    $finalResult = array();
    while($stmt->fetch()){
    	$temp_array = array(
    	'RagamID' => $ragamId,
        'Name'    => $name,
        'College'    => $college,
        'PhoneNumber'    => $phonenumber
    	);
        array_push($finalResult,$temp_array);
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
