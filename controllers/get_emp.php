<?php 
    // include "connect.php";
    include "connect_test.php";
    session_start();

    // $search = $_GET['q'];
    $return_arr = [];

    $sql = "SELECT EMP_NO,e.EMP_FIRST_NAME,e.EMP_LAST_NAME,p.EMP_POS_DESCR,o.ORG_NAME,o.ORG_CODE
            FROM hr_emp e
            LEFT JOIN sys_org o ON e.EMP_ORG_NO = o.ORG_NO  
            LEFT JOIN hr_emp_position p ON e.EMP_POS_NO = p.EMP_POS_NO
            WHERE EMP_NO != '1'";
            // WHERE o.ORG_CODE LIKE '%{$search}%' OR CONCAT_ws(' ',e.EMP_FIRST_NAME,e.EMP_LAST_NAME) LIKE '%{$search}%'";

        $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

        $sth =  $pdo->prepare($sql);
        $sth->execute();

        $records = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach( $records as $index => $row ) {
        $id         = $row['EMP_NO'];
        $position   = $row['EMP_POS_DESCR'] ? '('. $row['EMP_POS_DESCR'] .')' : '';
        $org_name   = $row['ORG_NAME'] ?  '-' . $row['ORG_NAME'] : '';
        $firstname  = $row['EMP_FIRST_NAME'];
        $lastname   = $row['EMP_LAST_NAME'];

        
        $result = array("id" => $id,"text" =>  $firstname . ' ' . $lastname . $position . $org_name );

        array_push($return_arr,$result);
    }
    
    mysqli_close($dbhandle);

    echo json_encode(
        array("results"=>$return_arr),JSON_UNESCAPED_UNICODE 
    );

    exit();

?>
