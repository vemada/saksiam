

<?php 
    include "connect.php";
    session_start();

    $search = $_GET['q'];
    $return_arr = [];

    $sql = "SELECT USER_NO,USER_NAME,USER_PASSWORD,USER_DESCR,USER_EMP_NO,LOGIN_ORG_NO,e.EMP_FIRST_NAME,e.EMP_LAST_NAME,e.NAME_TITLE_NO
            FROM sys_user_login u
            LEFT JOIN hr_emp e ON u.USER_EMP_NO = e.EMP_NO
            WHERE USER_NO LIKE '%{$search}%' OR USER_NAME LIKE '%{$search}%' OR CONCAT_ws(' ',e.EMP_FIRST_NAME,e.EMP_LAST_NAME) LIKE '%{$search}%'";

$pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

$sth =  $pdo->prepare($sql);
$sth->execute();

$records = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach( $records as $index => $row ) {
    $row['id'] = $row['USER_NO'];

    switch( $row['NAME_TITLE_NO']){
        case 1  : $row['USER_TITLE_NAME'] = "นาย"; break;
        case 2  : $row['USER_TITLE_NAME'] = "นาง"; break;
        default : $row['USER_TITLE_NAME'] = "นางสาว";
    }

    array_push($return_arr,(array)$row); 
}

mysqli_close($dbhandle);

echo json_encode(
    array("results"=>$return_arr),JSON_UNESCAPED_UNICODE 
);

exit();

?>
