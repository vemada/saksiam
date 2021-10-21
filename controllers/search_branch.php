<?php

include "connect.php";

//get parameter from only http verb get;
$search = $_GET['q'];
$return_arr = [];

//SQL Command.
$sql = "SELECT *
            FROM sys_org 
            WHERE ORG_NAME LIKE '%{$search}%'";

//query SQL Command.
$query = mysqli_query($dbhandle, $sql);

// If query fails, show the reason 
if (!$query) {
    die("SQL query failed: " . mysqli_error($dbhandle));
}

//fetch row and add to array
while ($row = mysqli_fetch_assoc($query)) {
    $tempRow = array("id" => $row["ORG_CODE"], "name" => $row["ORG_NAME"]);
    array_push($return_arr, $tempRow);
}

//return as json format
echo json_encode(
    array("results" => $return_arr)
);

exit();
