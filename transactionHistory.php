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
    
    <h1>Your Transaction History</h1>
    

    <table>
    <?php foreach($data as $item): ?>
    <tr>
        <td><?= $item["name"]; ?></td>
        <td><?= $item["amount"]; ?></td>
        <td><?= $item["date"]; ?></td>
        <td><?= $item["type"]; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    
    
  </body>
</html>