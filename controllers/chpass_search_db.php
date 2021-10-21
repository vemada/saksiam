<?php

include('connect.php');
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($dbhandle, $_POST["query"]);
 $query = "
  SELECT * FROM sys_user_login 
  WHERE USER_NAME LIKE '%".$search."%'
 ";
}
else
{
 $query = "
  SELECT * FROM sys_user_login ORDER BY  USER_NAME
 ";
}
$result = mysqli_query($dbhandle, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
  <div class="col-md-6">
   echo $USER_PASSWORD; 
 ';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
  <div class="col-md-6">
  echo $USER_PASSWORD; 
';
 }
 echo $output;
}
else
{
 echo 'Data Not Found';
}



?>