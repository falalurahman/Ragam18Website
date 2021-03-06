<?php
    include 'connectDatabase.php';

    $eventID = $_POST['EventID'];

    $stmt = $connection->prepare("SELECT A.Name, A.College, A.PhoneNumber FROM Participants A, EventsRegistration B WHERE B.EventID LIKE ? AND A.RagamID=B.ParticipantID AND B.Participating=0");
    $stmt->bind_param("s",$eventID);

    $stmt->execute();
    $res = $stmt->bind_result($name, $college, $phonenumber);
    $finalResult = array();
    while($stmt->fetch()){
    	$temp_array = array(
    		'Name'    => $name,
    		'College'	=> $college,
        'Phonenumber'   => $phonenumber
    	);
        array_push($finalResult,$temp_array);
    }
    echo json_encode($finalResult);
    $stmt->close();
    $connection->close();
