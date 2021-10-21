<?php 

include "connect.php";

// include "connect_test.php";

if (isset($_POST['user_id_1']) && isset($_POST['user_id_2']) ){

        $user_2 = intval($_POST['user_id_2']);
        
    // $sql = "SELECT * FROM sys_user_app_comp_privilege WHERE USER_NO = {$user_2}";
    // $query = mysqli_query($dbhandle, $sql);

    // while($row = mysqli_fetch_array($query)) { 

    //     echo $row['ALLOW_VIEW'];

    //     $sql = "UPDATE sys_user_app_comp_privilege
    //             SET ALLOW_VIEW = {$row['ALLOW_VIEW']},ALLOW_EDIT = {$row['ALLOW_EDIT']},ALLOW_ADD = {$row['ALLOW_ADD']},ALLOW_DELETE = {$row['ALLOW_DELETE']}
    //             WHERE USER_NO = {$user_1} AND APP_COMP_NO = {$row['APP_COMP_NO']} ";

    //     mysqli_query($dbhandle, $sql);

    // }
        foreach( $_POST['user_id_1'] as $user_id ){

            $user_1 = intval($user_id);

            if( $user_1 != $user_2){

                $sql = "UPDATE sys_user_app_comp_privilege AS p1 
                        JOIN sys_user_app_comp_privilege AS p2 ON p1.APP_COMP_NO = p2.APP_COMP_NO
                        SET p1.ALLOW_VIEW = p2.ALLOW_VIEW,p1.ALLOW_EDIT = p2.ALLOW_EDIT, p1.ALLOW_ADD = p2.ALLOW_ADD, p1.ALLOW_DELETE = p2.ALLOW_DELETE
                        WHERE p1.USER_NO ={$user_1} AND p2.USER_NO ={$user_2}";
        
                $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  
            
                $sth =  $pdo->prepare($sql);
                $sth->execute();

            }
        }

        $_SESSION['success'] = 'Copy privileges successfully';

        header("Location: slicense.php");

        exit();
}

?>