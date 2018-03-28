<?php
    include 'connectDatabase.php';

?>
    <html>
        <body>
            <table style="width: 500px;" border="1">
            <tr>
                <td>
                    <b>Sl No</b>
                </td>
                <td>
                    <b>Workshop Name</b>
                </td>
                <td>
                    <b>Participant Name</b>
                </td>
                <td>
                    <b>College</b>
                </td>
            </tr>
<?php

    $workshop = array("WID01"=>"Logophilia Vocabulary Workshop",
                    "WID02"=>"Photography Workshop",
                    "WID03" =>"Hip Hop International Dance Workshop",
                    "WID04" => "Social Entrepreneurship Workshop",
                    "WID05" => "Ethical Hacking Workshop",
                    "WID06" => "Robotics And IoT Workshop",
                    "WID07" => "Film Workshop");
    $currentname = "";
    $i = 0;

    $stmt = $connection->prepare("SELECT `WorkshopID`,`Name`,`College` FROM `Participants`,`WorkshopRegistration` WHERE `RagamID` = `ParticipantID` ORDER BY `WorkshopID`");
    $stmt->execute();
    $stmt->bind_result($wid,$name,$clg);
    while($stmt->fetch()){
        $wname = $workshop[$wid];
        if($currentname != $wname){
            $i=1;
            $currentname = $wname;
        }
        echo "<tr>
                <td>$i</td>
                <td>$wname</td>
                <td>$name</td>
                <td>$clg</td>
            </tr>";
            $i = $i + 1;
    }
?>

            </table>
        </body>
    </html>
<?php
    $stmt->close();
    $connection->close();
    ?>