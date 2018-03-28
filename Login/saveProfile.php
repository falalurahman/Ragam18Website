<?php
    session_start();
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
            $_SESSION['ragam_id'] = $ragamid;
            echo "<script>window.location.href='../';</script>";
        }else{
            echo "<script>alert('Error Adding Ragam ID');</script>";
            echo "<script>window.location.href='./logout.php'</script>";
        }
    }
    else{
            echo "<script>alert('Error Adding User');</script>";
            echo "<script>window.location.href='./logout.php'</script>";
    }

    $stmt->close();
    $connection->close();

