<?php
	session_start();
	include "connectDatabase.php";
	$participantID = $_SESSION['ragam_id'];
	$programName = $_POST['ProgramName'];
	
	$stmt = $connection->prepare("SELECT `Name`,`Email`,`PhoneNumber`,`College` FROM `Participants` WHERE `RagamID` LIKE ?");
	$stmt->bind_param("s",$participantID);
	$stmt->execute();
	
	$stmt->bind_result($participantName,$email,$phone,$collegeName);
	if((!$stmt->fetch()) || (is_null($email)) || (!isset($email))){
		echo "Failure";
		die();
	}
	
	$fare = 0;
	$sex = "MALE";
	$programID = 0;
	
	
	switch ($programName){
            case "Main Event Registration" :
            	$fare = 300;
                $programID = 7273;
	        break;
            case "Hospitality Registration": 
            	$fare = 300;
                $programID = 7400;
                break;
            case "Logophilia Vocabulary Workshop": 
            	$fare = 700;
                $programID = 7401;
	        break;                    
            case "Photography Workshop":
            	$fare = 600;
                $programID = 7402;
	        break;
            /*case "Hip Hop International Dance Workshop": 
            	$fare = 250;
                $programID = 7403;
	        break;*/
            case "Social Entrepreneurship Workshop": 
            	$fare = 1200;
            	$programID = 7404;
	        break;
            /*case "Ethical Hacking Workshop": 
            	$fare = 1200;
            	$programID = 7405;
	        break;*/
            /*case "Robotics And IoT Workshop": 
            	$fare = 1200;
            	$programID = 7406;
	        break;*/
            case "Film Workshop": 
            	$fare = 800;
            	$programID = 7411;
	        break;
            case "Proshow Day 1": 
            	$fare = 1000;
            	$programID = 7412;
	        break;
       	   case "Proshow Day 2": 
            	$fare = 500;
            	$programID = 7413;
	        break;
           case "Proshow Day 3": 
            	$fare = 800;
            	$programID = 7414;
	        break;
           case "Nites Combo": 
            	$fare = 300;
            	$programID = 7415;
                break;
           case "Compete.Sleep.Rave.Repeat Combo":
                $fare = 2500;
                $programID = 7416;
                break;
           case "Vest and Nest Combo":
                $fare = 800;
                $programID = 7417;
                break;
           	
        }

	$data2 = array("eventId" => 3238,
	    "totalFare" => $fare,
	    "attendingEvents" => array(
	        array(
	            "programId" => $programID,
	            "programName" => "Ragam '18",
	            "subProgramName" => $programName,
	            "fare" => $fare,
	            "attendees" => array(
	                array("name" => $participantName,
	                    "email" => $email,
	                    "phone" => $phone,
	                    "college" => $collegeName,
	                    "sex" => "MALE",
	                    "extraInfoValue" => $participantID)))),
	    "merchandise" => array());

	$payload2 = json_encode($data2);
	//echo $payload2;
	
	$stmt->close();
	$connection->close();

	//API URL
	$url = 'https://www.thecollegefever.com/v1/auth/basiclogin';

	//create a new cURL resource
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);


	//setup request to send json via POST

	$data = array("email" => "registration@ragam.org.in","password" => "tcf@ragam18");
	$payload = json_encode($data);

	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	//set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

	//return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute the POST request
	
	$actualResult = curl_exec($ch);
	$result = json_decode($actualResult);


	//close cURL resource

	curl_close($ch);
	
	
	//API URL
	$url = 'https://www.thecollegefever.com/v1/booking/bookticket';

	//create a new cURL resource
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);


	//setup request to send json via POST

	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, '\tmp\cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, '\tmp\cookie.txt');
	$cookie = "auth=".$result->sessionId."; path=/; domain=.thecollegefever.com; Expires=Tue, 19 Jan 2038 03:14:07 GMT; ";
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload2);
	//set the content type to application/json

	//return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute the POST request
	$actualResult = curl_exec($ch);
	$actualResult = "{".explode("{",$actualResult)[1];
	$result = json_decode($actualResult);
	echo ($result->pgUrl);


	//close cURL resource

	curl_close($ch);

	//echo $result->pgURL;


?>