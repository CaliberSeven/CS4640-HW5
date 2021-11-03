<?php
/** DATABASE SETUP **/
include("database_credentials.php"); // define variables

/** SETUP **/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($dbhost, $dbusername, $dbpasswd, $dbname);
session_start();
session_destroy();

session_start();

$error_msg = "";
// Check if the user submitted the form.
if (isset($_POST["name"]) && isset($_POST["email"] && isset($_POST["password"])) { // validate the email coming in
    $stmt = $db->prepare("select * from user_HW5 where email = ?;");
    $stmt->bind_param("s", $_POST["email"]);
    if (!$stmt->execute()) {
        $error_msg = "Error checking for user";
    } else { 
        // result succeeded
        $res = $stmt->get_result();
        $data = $res->fetch_all(MYSQLI_ASSOC);
        
        if (!empty($data)) {
            // user was found!  Verify password, then Send to the game (with a GET parameter containing their email)
            if (password_verify($_POST["password"], $data[0]["password"])) {
              $_SESSION["email"]=$data[0]["email"];
              $_SESSION["name"]=$data[0]["name"];
              header("Location: index.php");
              exit();
            }
            else {
              $error_msg = "Incorrect password";
            }
        } else {
            // User was not found.  For our game, we'll just insert them!
            $insert = $db->prepare("insert into user_HW5 (email, password, name) values (?, ?, ?);");
            $insert->bind_param("sss", $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["name"]);
            if (!$insert->execute()) {
                $error_msg = "Error creating new user";
            } 
            $_SESSION["email"]=$_POST["email"];
            $_SESSION["name"]=$_POST["name"];
            header("Location: index.php");
            exit();
            }
        }
    }
}


?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="author" content="Kiran Manicka and Ethan Chen"> 
    <meta name="description" content="Finance Login">
    <meta name="keywords" content="finance login"> 
    <title>CS4640 Financial</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/login.css">       
  </head>  
  <body>
    <header>
      <div class="header">
        <h1> CS4640 Financial </h1>
      </div>
    </header>
    <?php
      if (!empty($error_msg)) {
          echo "<div class='alert alert-danger'>$error_msg</div>";
      }
    ?>
    <form action="login.php" method="post">
      <div class="imgcontainer"> 
        <!-- uva picture -->
        <img src="uva.png" alt="UVA Logo" class="avatar">
      </div>
      <div class="container">
        <label for="name"><b>Name</b></label>
        <div>
          <input type="text" placeholder="Enter Name" id="name" name="name" required>
        </div>
        <label for="email"><b>Email</b></label>
        <div>
          <input type="text" placeholder="Enter Email" id="email" name="email" required>
        </div>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" id="password" name="password" required>      
        <button type="submit">Login</button>
      </div>
    </form>
  </body>
</html>