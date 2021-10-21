<?php 

include('../controllers/LMISlogin_db.php');?>

<html lang="en">
<head>

<!-- Required meta tags -->
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/style.css">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    
    <title>login</title>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
            <a href="#" class="navbar-brand" >
                <img src="picture/logo.png" idth="45" height="45" class="d-inline-block align-content-center" alt="" >
            </a>
            <a class="navbar-brand">Saksiam Leasing</a>
            <button class="navbar-toggler " type="button " data-bs-toggle="collapse " data-bs-target="#navbarNav " aria-controls="navbarNav " aria-expanded="false " aria-label="Toggle navigation ">
                   <span class="navbar-toggler-icon "></span>
            </button>

            <div class="collapse navbar-collapse " id="navbarNav ">
                <ul class="navbar-nav ">
                    <li class="nav-item ">
                        <a class="nav-link active " aria-current="page ">admin</a>
                    </li>
                </ul>
            </div>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-7">
                           <div class="form-group1 row">
                                <label for="text" class="col-md-12 col-form-label text-md-center">เข้าสู่ระบบ Admin</label>
                            </div>
                    <div class="card-body1">
                        <form action="" method="post">
                        <?php include('ic/errors.php'); ?>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">ชื่อผู้ใช้</label>
                                <div class="col-md-6">
                                    <input type="text" id="username" class="form-control" name="username" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่าน</label>                                             
                                <div class="col-md-6">
                                    <input id="password-field" type="password" class="form-control" name="password" value="">
                                      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>                                
                            </div>
                           

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                เข้าสู่ระบบ
                                </button>
                                <!-- 
                                <a href="LMISpassword.php" class="btn btn-link ">
                                    ลืมรหัสผ่าน?
                                </a> -->
                            </div>
                            </form>
                    </div>
                    
              
            </div>
        </div>
    </div>
    
</main>



<script >
 
$(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
</script>
</body>
</html>