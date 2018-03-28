<?php
    include 'connectDatabase.php';

    $ragamID = $_POST['RagamID'];
    $eventID = $_POST['EventID'];

    $stmt = $connection->prepare("INSERT INTO EventsRegistration VALUES (?, ?, -1, 0)");
    $stmt->bind_param("ss", $eventID, $ragamID);

    $stmt->execute();

    echo "SUCCESS";
    $stmt->close();
    $connection->close();
