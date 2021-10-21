 <?php 

   // include "connect_oi_uas.php";
   include "connect_uas_test.php";

   $menus = [
        'menu_cis' => 'oi_mainapp_menu_app_cis',
        'menu_dmt' => 'oi_mainapp_menu_app_dmt',
        'menu_jms' => 'oi_mainapp_menu_app_jms',
        'menu_lms' => 'oi_mainapp_menu_app_lms',
        'menu_sms' => 'oi_mainapp_menu_app_sms',
        'menu_uas' => 'oi_mainapp_menu_app_uas',
        'menu_admin' => 'oi_mainapp_menu_app_admin',
        'menu_report' => 'oi_mainapp_menu_lms_report',
        'spay_branch' => 'sakpay_menu_app_branch',
        'spay_sub_branch' => 'sakpay_menu_app_sub_branch',
        'spay_approve' => 'sakpay_menu_app_hq_fin_approve',
        'spay_payment' => 'sakpay_menu_app_hq_fin_payment',
        'lms_pay2cust' => 'oi_mainapp_menu_app_lms_pay2cust',
        'spay_branch_mng' => 'sakpay_menu_app_branch_management',
        'spay_branch_as' => 'sakpay_menu_app_branch_assistant',
    ];

    $authorities = [
        "ACC" => [ 'menu_lms' , 'spay_branch' , 'spay_sub_branch' , 'lms_pay2cust' ],
        "ANA" => [ 'menu_lms' , 'spay_branch' , 'spay_sub_branch' , 'lms_pay2cust' ],
        "BMN" => [ 'menu_lms' , 'lms_pay2cust' , 'spay_branch_mng' ],
        "BAS" => [ 'menu_lms' , 'lms_pay2cust' , 'spay_branch_as' ],
        "BGR" => [ 'menu_lms' , 'spay_branch' , 'spay_sub_branch' , 'lms_pay2cust' ],
        "CHK" => [ 'menu_lms' , 'spay_approve' , 'spay_payment' ],
        "PAY" => [ 'menu_lms' , 'lms_pay2cust' , 'spay_payment'],
    ];

    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password); 
    
    if(isset($_POST['insert'])){

        $USER_ID =$_POST['USER_NO'];
        $USER_TITLE_NAME =$_POST['USER_TITLE_NAME'];
        $USER_FIRST_NAME=$_POST['EMP_FIRST_NAME'];
        $USER_LAST_NAME=$_POST['EMP_LAST_NAME'];
        $USER_NAME=$_POST['USER_NAME'];
        $USER_PASSWORD=$_POST['USER_PASSWORD'];
        $USER_DESCR=$_POST['USER_DESCR'];
        $USER_EMP_ID=$_POST['USER_EMP_NO'];
        $LOGIN_ORG_NO=$_POST['LOGIN_ORG_NO'];

        $sql = "INSERT INTO uas_user_login      (   USER_ID,
                                                    USER_TITLE_NAME,
                                                    USER_FIRST_NAME,
                                                    USER_LAST_NAME,
                                                    USER_NAME,
                                                    USER_PASSWORD,
                                                    USER_DESCR,
                                                    USER_EMP_ID,
                                                    USER_AVATAR_IMAGE,
                                                    USER_PROFILE_IMAGE,
                                                    LOGIN_ORG_NO)

                    VALUES                         (   '{$USER_ID}',
                                                    '{$USER_TITLE_NAME}',
                                                    '{$USER_FIRST_NAME}',
                                                    '{$USER_LAST_NAME}',
                                                    '{$USER_NAME}',
                                                    '{$USER_PASSWORD}',
                                                    '{$USER_DESCR}',
                                                    '{$USER_EMP_ID}',
                                                    '17054715-5601-11eb-a469-e41f13b5ba54',
                                                    '1b008b13-5603-11eb-a469-e41f13b5ba54',
                                                    '{$LOGIN_ORG_NO}'
            )";

            $query_run = mysqli_query($dbhandle,$sql);

            if($query_run){
                foreach( $menus as $menu => $code ){
                    if( isset($_POST['AUTHORITY']) ){
                        $allow_view = in_array( $menu , $authorities[$_POST['AUTHORITY']] ) ? 1 : 0;      
                    }else{
                        $allow_view = 0;
                    }            
                    $sql2 = "INSERT INTO uas_user_app_comp_authorization
                            (   
                                APP_COMP_AUTH_ID,USER_ID, APP_COMP_CODE,ALLOW_VIEW,ALLOW_EDIT,ALLOW_CREATE,ALLOW_DELETE,ALLOW_EXECUTE
                            ) 
                            VALUES (  UUID(), ${USER_ID},'${code}',${allow_view},0,0,0,0 )";

                    $sth =  $pdo->prepare($sql2);
                    $sth->execute();    
                    // mysqli_query($dbhandle,$sql);            

                }
                mysqli_close($dbhandle);

                $_SESSION['success'] = 'สร้าง User Authen สำเร็จ';
                // echo'<script type="text/javascript"> alert("Successfully")</script>';
                header("Location: authen.php");
	            exit();
            }
            else{
                $_SESSION['error'] = mysqli_error($dbhandle);
                // echo("Error description: " .  mysqli_error($dbhandle) );
            }

    }
    else if(isset($_POST['auth_update'])){

        $USER_ID = $_POST['USER_NO'];

        foreach( $menus as $menu => $code ){

            if( isset($_POST['AUTHORITY']) ){
                $allow_view = in_array( $menu , $authorities[$_POST['AUTHORITY']] ) ? 1 : 0;
            }else{
                $allow_view = 0;
            }
            $sql2 = "UPDATE uas_user_app_comp_authorization SET ALLOW_VIEW = ${allow_view}
            WHERE APP_COMP_CODE = '${code}' AND USER_ID = '${USER_ID}'";
            $sth =  $pdo->prepare($sql2);
            $sth->execute();    
            // mysqli_query($dbhandle,$sql);            
        }
        $_SESSION['success'] = 'Update สิทธิ์ Authen สำเร็จ';
        header("Location: authen_slicense.php");
	    exit();
    }
?> 