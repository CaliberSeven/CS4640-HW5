<?php

include "classes/Database.php"; // we must include the code with any classes we wish to use

$db = new Database(); // create a new Database object

/** Create the required tables **/
echo "<p>Creating tables</p>";
$db->query("drop table if exists hw5_user;");
$db->query("create table hw5_user (
    id int not null auto_increment,
    email text not null,
    name text not null,
    password text not null,
    primary key (id)
);");


// Note that "--" is a comment in SQL
$db->query("drop table if exists hw5_transaction;");
$db->query("create table hw5_transaction (
    id int not null auto_increment,
    user_id int not null, -- the user id who inserted this transaction
    name text not null,
    t_date date not null, -- date is a reserved word
    amount decimal(10,2) not null, -- two decimal places
    primary key (id)
);");

echo "<p>Done creating tables</p>";
