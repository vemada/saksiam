<?php 

 include "connect.php"; 

if (isset($_POST['user_id'])){
   
if (isset($_POST['oldpassword']) && isset($_POST['newpassword'])
    && isset($_POST['conpassword'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$oldpassword = validate($_POST['oldpassword']);
	$newpassword = validate($_POST['newpassword']);
	$conpassword = validate($_POST['conpassword']);
    
    if(empty($oldpassword)){
      header("Location: LMISpassword.php?error=Old Password is required");
	  exit();
    }else if(empty($newpassword)){
      header("Location: LMISpassword.php?error=New Password is required");
	  exit();
    }else if($newpassword !== $conpassword){
      header("Location: LMISpassword.php?error=The confirmation password  does not match");
	  exit();
    }else if($oldpassword === $newpassword){
        header("Location: LMISpassword.php?error=Password is repeat");
        exit();
    }else {
     
    
    	$oldpassword = $oldpassword;
    	$newpassword = $newpassword;
        $conpassword = $conpassword;
        $user_id = $_POST['user_id'];

        if($newpassword === $conpassword){
        	
        	$sql_2 = "UPDATE sys_user_login
                      SET USER_PASSWORD ='{$newpassword}'
                      WHERE USER_NO ='{$user_id}'";
            
            $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

            $sth =  $pdo->prepare($sql);
            $sth->execute();

            $_SESSION['success'] = 'Your password has been changed successfully';
        	header("Location: change_password.php");
	        exit();

        }else {

            $_SESSION['error'] = 'Incorrect password';

        	header("Location: change_password.php");
	        exit();
        }

    }

    
}else{
	header("Location: change_password.php");
	exit();
}

}