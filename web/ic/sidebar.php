<nav id="sidebar">
  
				<div class="p-4 pt-5">
		    <a href="index.php" class="img logo rounded-circle mb-5" style="background-image: url(picture/logo.jpg);"></a>

            
	        <ul class="list-unstyled components mb-5">
              <li>
                  <a  href="index.php">Home</a>
              </li>

            <?php if( $_SESSION['username'] == 'sys_admin' || $_SESSION['is_admin'] ){ ?>
              <li>
                <a href="#LMISSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">LMIS USER</a>
                <ul class="collapse list-unstyled" id="LMISSubmenu">
                  <li>
                  <a href="change_password.php">แก้ไขรหัสผ่าน user</a>
                  </li>
                  <li>
                  <a href="slicense.php">แก้ไขสิทธิ์เข้าใช้งาน</a>
                  </li>                 
                </ul>

                <li>
                  <a href="#AUTHEN" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">AUTHEN USER</a>
                    <ul class="collapse list-unstyled" id="AUTHEN">
                        <li>
                        <a href="authen.php">สร้าง user ใหม่พนักงาน</a>
                        </li> 
                        <li>
                        <a href="authen_slicense.php">copy สิทธิ authen</a>
                        </li>
                      </ul>
                </li>               
              <li>
            <?php } ?>
         


              <?php if( $_SESSION['username'] == 'sys_admin' || $_SESSION['is_admin'] ){ ?>
                <li>
                <a href="contract.php">แก้ไขสัญญาลูกค้า</a>
                </li>
              <?php } ?>


              <?php if( $_SESSION['username'] == 'sys_admin' || $_SESSION['is_admin'] ){ ?>
                <li>
                    <a href="#Report" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Report & Bank</a>
                      <ul class="collapse list-unstyled" id="Report">
                        <li>
                          <a href="report.php">RTP-040 Report</a>
                        </li> 

                        <li>
                          <a href="search_petty_cash.php">แก้ไขบัตร Pretty cash</a>
                        </li>

                        <li>
                          <a href="add_petty_cash.php">เพิ่มบัตร Pretty cash</a>
                        </li>

                        <li>
                          <a href="log.php">log</a>
                        </li>
                      </ul>
                </li>
              <?php } ?>

             
             
	         
	        </ul>

            <!-- FOOTER -->
	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
	        </div>

	      </div>
    	</nav>