<?php 
    // include "connect_oi_uas.php";
    include "connect_uas_test.php";
    session_start();

    $search = $_GET['q'];
    $return_arr = [];

    $sql = "SELECT USER_ID,USER_NAME,USER_DESCR,USER_FIRST_NAME,USER_LAST_NAME,USER_TITLE_NAME
            FROM uas_user_login
            WHERE USER_ID LIKE '%{$search}%' OR CONCAT_ws(' ',USER_FIRST_NAME,USER_LAST_NAME) LIKE '%{$search}%'";

$pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

$sth =  $pdo->prepare($sql);
$sth->execute();

$records = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach( $records as $index => $row ) {
    $row['id'] = $row['USER_ID'];
    array_push($return_arr,$row); 
}

// mysqli_close($dbhandle);

echo json_encode(
    array("results"=>$return_arr),JSON_UNESCAPED_UNICODE 
);

exit();

?>
