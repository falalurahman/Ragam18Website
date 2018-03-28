<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, application/json");
    header("Content-Type: application/json; charset=UTF-8");
    include "connectDatabase.php";
    $input = file_get_contents('php://input');
    echo $input;
    $attendingevents = json_decode($input);
        $programName = $attendingevents->subProgramName;
        $amountPaid = $attendingevents->fare;
        $participantMail = $attendingevents->email;
        $mainregistration = 0;
        $hospitalityregistration = 0;
        $workshopregistration = 0;
        $workshopid = "";
        $proshowregistration = 0;
        $proshowid = "";
        $tshirt = 0;
	$merchandiseid = "";
        switch ($programName){
            case "Main Event Registration":
            	$mainregistration = 1;
 		break;
            case "Hospitality Registration":
            	$hospitalityregistration = 1;	
            	break;
            case "Logophilia Vocabulary Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID01";
                break;
            case "Photography Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID02";
                break;
            case "Hip Hop International Dance Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID03";
                break;
            case "Social Entrepreneurship Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID04";
                break;
            case "Ethical Hacking Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID05";
                break;
            case "Robotics And IoT Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID06";
                break;
            case "Film Workshop":
            	$workshopregistration = 1;
                $workshopid = "WID07";
                break;
            case "Proshow Day 1":
            	$proshowregistration = 1;
                $proshowid = "PID01";
                break;
       	   case "Proshow Day 2":
            	$proshowregistration = 1;
                $proshowid = "PID02";
                break;
           case "Proshow Day 3":
            	$proshowregistration = 1;
                $proshowid = "PID03";
                break;
           case "Nites Combo":
            	$proshowregistration = 1;
                $proshowid = "PID04";
                break;
           case "Compete.Sleep.Rave.Repeat Combo":
           	$mainregistration = 1;
           	$hospitalityregistration = 1;
           	$tshirt = 1;
           	$merchandiseid = "MID01";
           	$proshowregistration = 1;
           	$proshowid = "PID04";
           	break;
           case "Vest and Nest Combo":
           	$mainregistration = 1;
           	$hospitalityregistration = 1;
           	$tshirt = 1;
           	$merchandiseid = "MID01";
           	break;
           	
        }
            
            $changed1 = -1;
            $changed2 = -1;
            $changed3 = -1;
            $changed4 = -1;
            $changed5 = -1;

        if($mainregistration == 1){
            $stmt = $connection->prepare("UPDATE `Participants` SET `MainRegistration` = 1 WHERE `Email` LIKE ?");
            $stmt->bind_param("s",$participantMail);
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
            	$changed1 = 1;
            }else{
            	$changed1 = 0;
            }

            $stmt->close();
        }
        if($hospitalityregistration == 1){
            $stmt = $connection->prepare("UPDATE `Participants` SET `HospitalityRegistration` = 1 WHERE `Email` LIKE ?");
            $stmt->bind_param("s",$participantMail);
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
            	$changed2 = 1;
            }else{
            	$changed2 = 0;
            }

            $stmt->close();
        }
        $stmt = $connection->prepare("SELECT `RagamID` FROM `Participants` WHERE `Email` LIKE ?");
        $stmt->bind_param("s" , $participantMail);
        $stmt->execute();
        $stmt->bind_result($ragamID);

        $stmt->fetch();
        $stmt->close();
        if($workshopregistration == 1){
            $stmt = $connection->prepare("INSERT INTO `WorkshopRegistration`(`WorkshopID`, `ParticipantID`, `Participating`) VALUES (?,?,0)");
            $stmt->bind_param("ss",$workshopid,$ragamID);
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
            	$changed3 = 1;
            }else{
            	$changed3 = 0;
            }

            $stmt->close();
        }
        if($proshowregistration == 1){
            $stmt = $connection->prepare("INSERT INTO `ProshowRegistration`(`ProshowID`, `ParticipantID`, `ProshowGiven`) VALUES (?,?,0)");
            $stmt->bind_param("ss",$proshowid,$ragamID);
            $stmt->execute();
            
	    if($stmt->affected_rows == 1){
            	$changed4 = 1;
            }else{
            	$changed4 = 0;
            }

            $stmt->close();
        }
        if($tshirt == 1){
            $stmt = $connection->prepare("INSERT INTO `MerchandiseRegistration`(`MerchandiseID`, `ParticipantID`, `MerchandiseGiven`) VALUES (?,?,0)");
            $stmt->bind_param("ss",$merchandiseid,$ragamID);
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
            	$changed5 = 1;
            }else{
            	$changed5 = 0;
            }

            $stmt->close();
    	}
    	
    	if($changed1!=0 && $changed2!=0 && $changed3!=0 && $changed4!=0 && $changed5!=0){
    	    $stmt = $connection->prepare("UPDATE `Participants` SET `AmountPaid` = `AmountPaid` + ? WHERE `Email` LIKE ?");
            $stmt->bind_param("is",$amountPaid,$participantMail);
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
            	echo 'SUCCESS';
            }else{
            	echo 'FAILURE';
            }

            $stmt->close();
    	}

    $connection->close();
   ?>