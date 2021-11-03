<?php

include "classes/Database.php"; // we must include the code with any classes we wish to use

$db = new Database(); // create a new Database object

// Example 1: Insert an example user
$email = "example@email.com";
$name = "Jane Doe";
$password = "this_is_insecure"; // Don't directly insert a password for real!
$db->query("insert into hw5_user (email, name, password) values (?, ?, ?);", "sss", $email, $name, $password);

// Example 2: Insert an example transaction (assuming the current user is user_id 1)
$userid = 1;
$name = "Macbook Pro M1 Max";
$date = "2021-10-31"; // Halloween - notice the date format we need!
$amount = "1999.99";
$insert = $db->query("insert into hw5_transaction (user_id, name, t_date, amount) values (?, ?, ?, ?);", "isss", $userid, $name, $date, $amount);

// Example 2: Return the transaction list for a particular user in descending order
$userid = 1;
$transactions = $db->query("select * from hw5_transaction where user_id = ? order by t_date desc;", "i", $userid);

print_r($transactions); // just for example, print the array

// Example 3: Return the current balance for a particular user
$userid = 1;
$balanceArray = $db->query("select sum(amount) as balance from hw5_transaction where user_id = ?;", "i", $userid);

print_r($balanceArray); // print the resulting array
echo "<p>{$balanceArray[0]["balance"]}</p>"; // get the balance


