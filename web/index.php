<?php
session_start();

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>แก้ไขวันสัญญาลูกค้า</title>
    <?php 
      include('ic/head.php');
    ?>

   
  </head>
  <body>
		
  <div class="wrapper d-flex align-items-stretch">
			<?php
      include('ic/sidebar.php');
      ?>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <?php
        include('ic/navbar.php');
        ?>
            <h1 style="font-size: 18px; margin-top: 50px">Have a nice days :) </h1>

		</div>
    </div>

    <?php
    include('ic/footer.php');
    ?>
    
    
    
  </body>
</html>