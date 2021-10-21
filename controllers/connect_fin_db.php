<?php

// for production
 $host ="10.5.17.11:3306"; 
 $db_username ="oi_fin";
 $db_password ="oi#2562";
 $database ="oi_fin";


global $dbhandle,$dbinfo;

$dbinfo = ['host' => $host, 'username' => $db_username,'password' => $db_password,'db' => $database];

//connect to database by sent the variables for authenticate;
$dbhandle = mysqli_connect($host,$db_username, $db_password,$database)
  or die("Couldn't connect to SQL Server on $myServer"); 

mysqli_set_charset($dbhandle, "utf8");
