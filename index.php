<?php

spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});


// Join session or start one
session_start();

// Parse the URL
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$path = str_replace("/ec5rdn/hw5/", "", $path);
$parts = explode("/", $path);

if (isset($_GET["command"])) {
    if ($_GET["command"] == "login") {
        $parts = ["login"];
    } elseif ($_GET["command"] == "insert") {
        $parts = ["insert"];
    } elseif ($_GET["command"] == "transactions") {
        $parts = ["transactions"];
    } else {
        echo $_GET["command"];
        exit("Fail #4");
    }
}

// If the user's email is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if (!isset($_SESSION["email"])) {
    // they need to see the login
    $parts = ["login"];
}

// Instantiate the controller and run
$trivia = new FinanceController();
$trivia->run($parts[0]);