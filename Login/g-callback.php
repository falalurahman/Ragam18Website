<?php
require_once "config.php";
include 'connectDatabase.php';


if (isset($_SESSION['access_token'])&&isset($_SESSION['ragam_id']))
{
    $gClient->setAccessToken($_SESSION['access_token']);
}
else if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
} else {
    echo "<script>window.location.href='../';</script>";
    exit();
}

$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();

$email = $userData['email'];

$stmt = $connection->prepare("SELECT RagamID FROM Participants WHERE Email=?");
$stmt->bind_param("s",$email);

$stmt->execute();
$stmt->bind_result($ragamId);

if( $stmt->fetch() ){

    $_SESSION['ragam_id'] = $ragamId;
    echo '<script>window.history.go(-2);</script>';
}else {
    ?>

    <html>
    <head>
        <title>Enter Personal Information</title>

        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    <form action="saveProfile.php" method="post">
        <h1>Enter Personal Information</h1>
        <div class="info"><span class="heading">Name: </span> <input type="text" name="Name" placeholder="Name"
                                                                     value="<?php echo $userData['givenName']; ?>"
                                                                     required></div>
        <input type="hidden" name="Email" placeholder="Email Address" value="<?php echo $email; ?>">
        <div class="info"><span class="heading">College Name: </span> <input type="text" name="College"
                                                                             placeholder="College" required></div>
        <div class="info"><span class="heading">Phone Number: </span> <input type="tel" name="Phone"
                                                                             placeholder="Phone Number" required></div>
        <input type="submit" value="Submit">
    </form>
    </body>
    </html>
    <?
}

$stmt->close();
$connection->close();

?>