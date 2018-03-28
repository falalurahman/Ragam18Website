<?php
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];

    $stmt = $connection->prepare("SELECT B.TeamNumber,A.Name FROM Participants A, EventsRegistration B WHERE B.EventID LIKE ? AND A.RagamID=B.ParticipantID AND B.Participating=1 AND B.TeamNumber<>-1 ORDER BY B.TeamNumber ASC");
    $stmt->bind_param("s",$eventID);

    $stmt->execute();
    $res = $stmt->bind_result($teamnumber, $name);
    $finalResult = array();
    while($stmt->fetch()){
    	$temp_array = array(
        'TeamNumber' => $teamnumber,
    		'Name'    => $name
    	);
        array_push($finalResult,$temp_array);
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
