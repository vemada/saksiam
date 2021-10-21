<?php 
    // include "connect.php";
    include "connect_oi_uas.php";
    session_start();

    // $search = $_GET['q'];
    $return_arr = [];

    $sql = "SELECT USER_ID,USER_DESCR,USER_TITLE_NAME,USER_FIRST_NAME,USER_LAST_NAME
            FROM uas_user_login
            WHERE USER_ID != '1'";
            // WHERE o.ORG_CODE LIKE '%{$search}%' OR CONCAT_ws(' ',e.EMP_FIRST_NAME,e.EMP_LAST_NAME) LIKE '%{$search}%'";

        $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

        $sth =  $pdo->prepare($sql);
        $sth->execute();

        $records = $sth->fetchAll(PDO::FETCH_ASSOC);

        // var_dump( $records); die();
    foreach( $records as $index => $row ) {
        $id         = $row['USER_ID'];
        $position   = $row['USER_DESCR'];
        $firstname  = $row['USER_FIRST_NAME'];
        $lastname   = $row['USER_LAST_NAME'];

        
        $result = array("id" => $id,"text" =>  $id.' '.$firstname.' '.$lastname.' ,'.$position);

        array_push($return_arr,$result);
    }
    
    mysqli_close($dbhandle);

    echo json_encode(
        array("results"=>$return_arr),JSON_UNESCAPED_UNICODE 
    );

    exit();

?>
