<?php 
    include "connect.php";
    session_start();

    $search = $_GET['q'];
    $return_arr = [];

    $sql = "SELECT u.USER_NO,u.USER_NAME,e.EMP_FIRST_NAME,e.EMP_LAST_NAME,p.EMP_POS_DESCR,o.ORG_NAME
            FROM sys_user_login u
            LEFT JOIN sys_org o ON u.LOGIN_ORG_NO = o.ORG_NO  
            LEFT JOIN hr_emp e ON u.USER_EMP_NO = e.EMP_NO
            LEFT JOIN hr_emp_position p ON e.EMP_POS_NO = p.EMP_POS_NO
            WHERE u.USER_NAME LIKE '%{$search}%' OR CONCAT_ws(' ',e.EMP_FIRST_NAME,e.EMP_LAST_NAME) LIKE '%{$search}%'";

    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

    $sth =  $pdo->prepare($sql);
    $sth->execute();

    while($row = $sth->fetch()) {
        $id         = $row['USER_NO'];
        $username   = $row['USER_NAME'];
        $position   = $row['EMP_POS_DESCR'];
        $org        = $row['ORG_NAME'];
        $firstname  = $row['EMP_FIRST_NAME'];
        $lastname   = $row['EMP_LAST_NAME'];

        $result = array("id" => $id,"text" => $username,'position'=>$position,'org'=>$org,'firstname'=>$firstname,'lastname'=>$lastname );

        array_push($return_arr,$result);
    }
    
    // mysqli_close($dbhandle);

    echo json_encode(
        array("results"=>$return_arr)
    );

    exit();

?>
