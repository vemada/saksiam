 
 <?php 
    // include "connect_oi_uas.php";
    include "connect_uas_test.php";

    
    if (isset($_POST['USER_ID_1']) && isset($_POST['USER_ID']) ){
    
            $user_2 = intval($_POST['USER_ID']);
        
            foreach( $_POST['USER_ID_1'] as $user_id ){
                $user_1 = intval($USER_ID_1);    
                if( $user_2 == '62'){   
                    $sql = "UPDATE uas_user_app_comp_authorization AS u2 
                            JOIN uas_user_login AS u1 ON u2.USER_ID = u1.USER_ID
                            /* 
                                SET u1.ALLOW_VIEW = '0', 
                                u1.APP_COMP_CODE = 'oi_mainapp_menu_app_cis', 
                                u1.ALLOW_ADD = u1.ALLOW_ADD, 
                                u2.ALLOW_DELETE = u1.ALLOW_DELETE,
                                u2.APP_COMP_AUTH_ID =u1.APP_COMP_AUTH_ID, 
                                u2.APP_COMP_CODE = u1.APP_COMP_CODE
                                WHERE u1.USER_ID ={$user_1} AND u2.USER_ID ={$user_2} 
                            */
                            SET u1.ALLOW_VIEW = '0'
                            WHERE u1.APP_COMP_CODE = 'oi_mainapp_menu_app_cis';
                            SET u1.ALLOW_VIEW = '0'
                            WHERE u1.APP_COMP_CODE = 'oi_mainapp_menu_app_dmt';
                            ";
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