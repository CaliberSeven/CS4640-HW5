<?php
/** DATABASE SETUP **/
include("database_credentials.php"); // define variables

/** SETUP **/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($dbhost, $dbusername, $dbpasswd, $dbname);
$transactions = null;

// Deal with the current session 
if (isset($_GET["email"])) { // validate the email coming in
    $stmt = $db->prepare("select * from transaction_hw5 where email = ?;");
    $stmt->bind_param("s", $_GET["email"]);
    if (!$stmt->execute()) {
        die("Error checking for user");
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);
        
        if (empty($data)) {
            // user was NOT found!
            header("Location: templates/login.php");
            exit();
        } 
        // The user WAS found (SECURITY ALERT: we only checked against
        // their email address -- this is not a secure method of
        // keeping track of users!  We more likely want a unique
        // session ID for this user instead!
        $transactions = $data[0];
    }
} else {
    // User did not supply email GET parameter, so send them
    // to the login page
    header("Location: templates/login.php");
    exit();
}








?>