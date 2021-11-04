<?php

class FinanceController {

    private $db;
    
    private $url = "/km9eg/HW5";
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function run($command) {
        
        switch($command) {
            case "insert":
                $this->transactionHistory();
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
                    header("Location: {$this->url}/index.php?command=insert");
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
                header("Location: {$this->url}/index.php?command=insert");
                return;
            }
        }
        

        include ("templates/login.php");
    }
    
    public function transaction() {
        if (isset($_POST["name"])) {
            $insert = $this->db->query("insert into transaction_hw5 (email, name, date, amount, type) values (?, ?, ?, ?, ?);", "sssds",
                $_SESSION["email"], $_POST["name"], $_POST["date"], $_POST["amount"], $_POST["type"]);
            if (!$insert === false) {
                $error_msg = "Error inserting transaction";
            } else {
                $error_msg = "Transaction Inserted";
            }
        }

        include "templates/transaction.php";
    }

    public function transactionHistory() {
        if ($_SESSION["email"]){
            $data = $this->db->query("select * from transaction_hw5 where email=? order by date desc;","s",$_SESSION["email"]);
        }
        include "transactionHistory.php";
    }
    
    public function question() {
        // Our php code from question.php last time!

        $data = $this->db->query("select id, question from question order by rand() limit 1;");
        if (!isset($data[0])) {
            die("No questions in the database");
        }
        $question = $data[0];

        $message = "";

        if (isset($_POST["questionid"])) {
            $qid = $_POST["questionid"];
            $answer = $_POST["answer"];
            
            $data = $this->db->query("select * from question where id = ?;", "i", $qid);
            if ($data === false) {
                // did not work
                $message = "<div class='alert alert-info'>Error: could not find previous question</div>";
            } else if (!isset($data[0])) {
                // worked
                $message = "<div class='alert alert-info'>Error: could not find previous question</div>";
            } else {
                // found question
                if ($data[0]["answer"] == $answer) {
                    // user answered correctly -- perhaps we should also be better about how we
                    // verify their answers, perhaps use strtolower() to compare lower case only.
                    $message = "<div class='alert alert-success'><b>$answer</b> was correct!</div>";
                    
                    // Update the score in the session object
                    $_SESSION["score"] += $data[0]["points"];
                    // Update the score in the database using the SQL UPDATE query
                    $this->db->query("update user set score  = ? where email = ?;", "is", $_SESSION["score"], $_SESSION["email"]);
                } else { 
                    $message = "<div class='alert alert-danger'><b>$answer</b> was incorrect! The answer was: {$data[0]['answer']}</div>";
                }
            }
        }
        
        // set user information for the page
        $user = [
            "name" => $_SESSION["name"],
            "email" => $_SESSION["email"],
            "score" => $_SESSION["score"]
        ];
        
        include("templates/question.php");
    }
}