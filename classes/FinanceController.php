<?php

class FinanceController {

    private $db;
    
    private $url = "/ec5rdn/hw5";
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function run($command) {
        
        switch($command) {
            case "insert":
                $this->transaction();
            case "logout":
                $this->destroySession();
            case "login":
            default:
                $this->login();
                break;
        }
            
    }
    
    private function destroySession() {          
        session_destroy();

        session_start();
    }
    
    public function login() {
        $error_msg = "";
        // Check if the user submitted the form.
        if (isset($_POST["email"])) { // validate the email coming in
            $data = $this->db->query("select * from user_hw5 where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                // user was found!  Verify password, then Send to the game (with a GET parameter containing their email)
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["name"]=$data[0]["name"];
                    $_SESSION["email"]=$data[0]["email"];
                    header("Location: {$this->url}/index.php?command=insert&moved=yes");
                    exit();
                } else {
                    $error_msg = "Incorrect password";
                }
            } else {
                // User was not found.  For our game, we'll just insert them!
                $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $insert = $this->db->query("insert into user_hw5 (email, password, name) values (?, ?, ?);", "sss", $_POST["email"], $hash, $_POST["name"]);
                if (!$insert === false) {
                    $error_msg = "Error creating new user";
                } 

                $_SESSION["name"]=$_POST["name"];
                $_SESSION["email"]=$_POST["email"];
                header("Location: {$this->url}/index.php?command=insert&moved=yes");
                return;
            }
        }
        
        if (!isset($_GET["moved"])) {
            include "templates/login.php";
        }
    }
    
    public function transaction() {
        if (isset($_POST["name"])) {
            $insert = $this->db->query("insert into transaction_hw5 (email, name, date, amount) values (?, ?, ?, ?, ?);", "sssis",
                $_SESSION["email"], $_POST["name"], $_POST["date"], $_POST["amount"], $_POST["type"]);
            if ($_POST["type"] == "debit") {
                $amount = -1 * $_POST["amount"];
                $insert = $this->db->query("insert into transaction_hw5 (email, name, date, amount) values (?, ?, ?, ?, ?);", "sssis",
                    $_SESSION["email"], $_POST["name"], $_POST["date"], $amount, $_POST["type"]);
            }
            if (!$insert === false) {
                $error_msg = "Error inserting transaction";
            } else {
                header("Location: {$this->url}/index.php?command=insert&moved=yes&inserted=yes");
            }
        }

        include("templates/transaction.php");
    }
}