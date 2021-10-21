<?php
session_start();
include('../controllers/change_password_db.php');
if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>



<!doctype html>
<html lang="en">
  <head>
  	<title>change password</title>

    <?php 
      include('ic/headpassword.php');
    ?>

  </head>
  <body>
		
  <div class="wrapper d-flex align-items-stretch">
  <?php
      include('ic/sidebar.php');
      ?>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

      <?php include('ic/navbar.php'); ?>

        <form action="" method="POST">
        <h2 class="mb-4"  >เปลี่ยนรหัสผ่าน user</h2>

            <?php include('ic/messages.php');?>
            
             <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">username</label>
                        <div class="col-md-6">
                            <select id="search_username"  class="form-control" name="user_id">
                            </select>
                          </div>
                        
             </div>  

             <div class="form-group row">
                    <label for="password-field" class="col-md-4 col-form-label text-md-right">รหัสผ่านเก่า</label>
                        <div class="col-md-6">
                                  <input id="password-field" type="password" class="form-control"  readonly>
                                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                  <input type="hidden" id="old_password" name="oldpassword">
                        </div>
            </div>

             <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่านใหม่</label>
                        <div class="col-md-6">
                                      <input id="password-field2" type="password" class="form-control" name="newpassword" required>
                                      <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
            </div>

            <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">ยืนยันรหัสผ่านใหม่</label>
                        <div class="col-md-6">
                             <input type="password" id="conpassword" class="form-control" name="conpassword" required>
                        </div>
            </div>

             <div class="d-grid gap-2 col-4 mx-auto">
                     <button class="btn btn-success" type="submit">ยืนยัน</button>
                                    
                          <a href="#" > 
                                <button type="button" class="btn btn-dark">ยกเลิก</button>
                          </a>             
              </div>

        </form>
        
      </div>
		</div>

    <?php
      include('ic/footer.php');
    ?>

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
      $(".toggle-password2").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
      });
    </script>
    <script>
      /* # from id */
          $("#search_username").select2({
              ajax: {
              url: "../controllers/search_password.php",
              dataType: 'json',
              delay: 500,
              data: function (params) {
                return {
                  q: params.term, // search term
                };
              },
              cache: true
            },
            placeholder: 'ค้นหา username',
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        $('#search_username').on('select2:select', function (e) {
            var data = e.params.data;
            $('#password-field,#old_password').val(data.oldpassword);
            // $('#user_id').val(data.user_id);
        });

    

        function formatRepo (repo) {
          if (repo.loading) {
            return repo.text;
          }
          
          if ( repo.position !== undefined ) {
            return repo.text + '(' + repo.firstname + ' ' + repo.lastname + ' - ' + repo.position + ',' + repo.org + ')';
          }

          return repo.text;
        }

        function formatRepoSelection (repo) {

          if ( repo.position !== undefined ) {
            return repo.text + '(' + repo.firstname + ' ' + repo.lastname + ' - ' + repo.position + ',' + repo.org + ')';
          }
          return repo.text;
        }

    </script>
    
  </body>
</html>