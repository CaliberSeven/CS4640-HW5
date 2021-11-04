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
    <form action="<?=$this->url?>/index.php?command=login" method="post">
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