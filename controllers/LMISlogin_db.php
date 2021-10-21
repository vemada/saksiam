<?php

include('connect.php');
session_start();

$errors=[];

if(count($_POST)>0) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $findme   = 'admin';
    $post = strpos( $username , $findme);

    if ($post === false) {

        // $query  = "SELECT * FROM sys_user_login l LEFT JOIN sys_org o ON l.LOGIN_ORG_NO = o.ORG_NO 
        //             WHERE USER_NAME = '{$username}' AND USER_PASSWORD = '{$password}' AND USER_DESCR LIKE '%admin%' ";

        $query  = "SELECT * FROM sys_user_login l LEFT JOIN sys_org o ON l.LOGIN_ORG_NO = o.ORG_NO 
        WHERE USER_NAME = '{$username}' AND USER_PASSWORD = '{$password}'";

    } else {

        $query  = "SELECT * FROM sys_user_login l LEFT JOIN sys_org o ON l.LOGIN_ORG_NO = o.ORG_NO
                    WHERE USER_NAME = '{$username}' AND USER_PASSWORD = '{$password}'";

    }

    $result = mysqli_query($dbhandle,$query);
    $count  = mysqli_num_rows($result);

    if($count==0) {
        $errors[] = "Invalid Username or Password!";
    } else {       

        while($row = mysqli_fetch_array($result)) {
            
            $_SESSION['org_no']   =  $row['LOGIN_ORG_NO'];
            $_SESSION['username'] =  $row['USER_NAME'];

            if( strpos( $row['USER_DESCR'] , 'ผู้จัดการเขต') !== false ){

                $_SESSION['area_mgr'] = 1;
                $_SESSION['org_name'] = str_replace("เขต","สาขา",$row['ORG_NAME']); 

            } else if( strpos( $row['USER_DESCR'] , 'ผู้จัดการสาขา') !== false ){

                $_SESSION['branch_mgr'] = 1;
                $_SESSION['org_name'] =  $row['ORG_NAME'];

            } else if( strpos( $row['USER_DESCR'] , 'admin') !== false || $post){

                $_SESSION['is_admin'] = 1;
                $_SESSION['org_name'] = str_replace("เขต","สาขา",$row['ORG_NAME']); 

            }else {

                $_SESSION['org_name'] =  $row['ORG_NAME'];

            }   

        }

        mysqli_close($dbhandle);

        header("location: ../web/index.php");
        exit(0);
    }

}
    

?>
