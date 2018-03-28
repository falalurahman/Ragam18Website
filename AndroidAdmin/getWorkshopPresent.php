<?php
    include 'connectDatabase.php';

    $workshopID = $_POST['WorkshopID'];

    $stmt = $connection->prepare("SELECT A.Name, A.College, A.PhoneNumber FROM Participants A, WorkshopRegistration B WHERE B.WorkshopID LIKE ? AND A.RagamID=B.ParticipantID AND B.Participating=1");
    $stmt->bind_param("s",$workshopID);

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