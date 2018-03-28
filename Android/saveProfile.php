<?php
    require 'connectDatabase.php';
  
    $name = mysqli_real_escape_string($connection,$_POST['Name']);
    $email = mysqli_real_escape_string($connection,$_POST['Email']);
    $college = mysqli_real_escape_string($connection,$_POST['College']);
    $phone = mysqli_real_escape_string($connection,$_POST['Phone']);


    $stmt = $connection->prepare("INSERT INTO Participants VALUES( NULL, NULL,?,?,?,?,0,0,0)");
    $stmt->bind_param("ssss",$name,$college,$email,$phone);

    $stmt->execute();
    if($stmt->affected_rows == 1) {
        $ragamid = sprintf("RID%05d", $stmt->insert_id);

        $stmt = $connection->prepare("UPDATE Participants SET RagamID = ? WHERE Email=?");
        $stmt->bind_param("ss",$ragamid, $email);
        $stmt->execute();
        
        if($stmt->affected_rows == 1) {
            	$result = array(
            		"status"=>"SUCCESS",
            		"ragamId"=>$ragamid
        	);
    		echo json_encode($result);
        }else{
            $result = array(
            		"status"=>"FAILURE"
        	);
    		echo json_encode($result);
        }
    }
    else{
            $result = array(
            		"status"=>"FAILURE"
        	);
    		echo json_encode($result);
    }

    $stmt->close();
    $connection->close();

