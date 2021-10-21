<?php

$host ="10.5.17.3:13301"; 
$db_username ="lmis_web";
$db_password ="lmisweb#2563";
$database ="lmis";

global $dbhandle;

$dbhandle = mysqli_init();

//specify the connection timeout
$dbhandle->options(MYSQLI_OPT_CONNECT_TIMEOUT, 30);

//specify the read timeout
$dbhandle->options(MYSQLI_OPT_READ_TIMEOUT, 30);

//specify the connection timeout
$dbhandle->options(MYSQLI_READ_DEFAULT_GROUP,"max_allowed_packet=50M");

$dbhandle->options(MYSQLI_SET_CHARSET_NAME, "utf8");

//initiate the connection to the server, using both previously specified timeouts
$dbhandle->real_connect($host, $db_username, $db_password, $database);

?>