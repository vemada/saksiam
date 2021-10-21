<?php
session_start();

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>สร้าง user ระบบ authen</title>
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

        <h2 class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 25px">สร้าง USER Authen</h2>

        
                    <?php include('ic/messages.php'); ?>

                    
                      <form action="../controllers/authen_db.php" method="POST">

                        <div class="form-group">
                            <label for="user">ค้นหารหัสพนักงาน/username/ชื่อ-นามสกุล</label>
                            <select class="custom-select my-1 mr-sm-2" id="search_lmis" name="search_lmis">
                              <option></option>
                            </select>
                          </div>

                          <div class="form-group">
                                  <label for="emp_id">USER_ID</label>
                                  <input type="text" class="form-control" id="USER_ID" name="USER_NO" maxlength="5" required onkeypress="return isNumberKey(event)" /> 
                          </div> 

                          <div class="form-row">
                          <div class="form-group col-md-3">
                                    <label for="inputtitlename">คำนำหน้า</label>
                                    <select id="inputState" name="USER_TITLE_NAME" class="form-control">
                                    <option selected>Choose...</option>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                  </select>                                  
                            </div>

                            <div class="form-group col-md-4">
                                    <label for="firstname">ชื่อจริง</label>
                                    <input type="text" class="form-control" id="USER_FIRST_NAME" name="EMP_FIRST_NAME" placeholder="" required>
                                </div>
                            <div class="form-group col-md-5">
                                    <label for="lastname">นามสกุล</label>
                                    <input type="text" class="form-control" id="USER_LAST_NAME" name="EMP_LAST_NAME" placeholder="" required>
                            </div>
                          </div>
                        
                          
                            <div class="form-group">
                                    <label for="firstname">USER_NAME</label>
                                    <input type="text" class="form-control" id="USER_NAME" name="USER_NAME" placeholder="" required>
                                </div>
                            <div class="form-group">
                                    <label for="lastname">USER_PASSWORD</label>
                                    <input type="text" class="form-control" id="USER_PASSWORD" name="USER_PASSWORD" placeholder="" required>
                            </div>
                          

                          <div class="form-group">
                              <label for="position">ตำแหน่ง</label>
                              <input type="position" class="form-control" id="USER_DESCR" name="USER_DESCR" placeholder="" required>
                          </div>

                     
                                                
                          <div class="form-row">
                          <div class="form-group col-md-6">
                                  <label for="firstname">USER_EMP_NO</label>
                                  <input type="text" class="form-control" id="USER_EMP_ID" name="USER_EMP_NO" required  onkeypress="return isNumberKey(event)" />
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="lastname">LOGIN_ORG_NO</label>
                                  <input type="text" class="form-control" id="LOGIN_ORG_NO" name="LOGIN_ORG_NO" placeholder="" maxlength="2" onkeypress="return isNumberKey(event)" /> 
                              </div>
                          </div> 

                        <div class="form-group">
                            <label for="user">สิทธิ EMP_NO</label>
                            <select class="custom-select my-1 mr-sm-2" id="AUTHORITY" name="AUTHORITY" placeholder="ค้นหารหัสพนักงาน">
                            <option >-- เลือกตำแหน่งที่ต้องการ copy สิทธิ --</option>
                              <option value="ACC">พนักงานการเงิน</option>
                              <option value="ANA">พนักงานวิเคราะห์สินเชื่อ</option>
                              <option value="BMN">ผู้จัดการสาขา</option>
                              <option value="BAS">ผู้ช่วยผู้จัดการสาขา</option>
                              <option value="BGR">รักษาการหัวหน้าหน่วย</option>
                              <option value="CHK">พนักงานการเงินสำนักงานใหญ่</option>
                              <option value="PAY">หัวหน้างานกำกับการโอนเงิน</option>
                            </select>
                        </div>    


                          <button type="submit" class="btn btn-success" name="insert">บันทึก</button>
                      </form>                 
		      </div>
    </div>

    <?php
        include('ic/footer.php');
    ?>
    
        <script>
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }    
        </script>

<script>

    $(document).ready(function () {   

          $("#search_lmis").select2({
            ajax: {
            url: "../controllers/search_lmis.php",
            dataType: 'json',
            delay: 500,
            data: function (params) {
              return {
                q: params.term, // search term
              };
            },
            cache: true,
          },
          placeholder: 'ค้นหารหัสพนักงาน',
          minimumInputLength: 1,
          templateResult: formatRepo,
          templateSelection: formatRepoSelection, 
          escapeMarkup: function (markup) { return markup; },  
          theme: 'bootstrap4'
        }); 

        $('#search_lmis').on('select2:select', function (e) {
          var data = e.params.data;

          $.each( data , function( key, value ) {

            if( $('[name="'+ key +'"]').length ){
                var $this = $('[name="'+ key +'"]');
              
                $this.val(value).change();
            
            }
          });

        });
        
        function formatRepo (repo) {
        
        if (repo.loading) {
          return repo.text;
        }
        
        if ( repo.USER_NO !== undefined ) {
          return 'รหัสพนักงาน: ' + repo.USER_NO + ('  ,' + repo.USER_TITLE_NAME + ' ' + repo.EMP_FIRST_NAME + ' ' + repo.EMP_LAST_NAME + ' ตำแหน่ง ' + repo.USER_DESCR);
        }

        return repo.USER_NO;
      }

      function formatRepoSelection (repo) {

        if (repo.loading) {
          return repo.text;
        }
        
        if ( repo.USER_NO !== undefined ) {
          return 'รหัสพนักงาน: ' + repo.USER_NO + ('  ,' + repo.USER_TITLE_NAME + ' ' + repo.EMP_FIRST_NAME + ' ' + repo.EMP_LAST_NAME + ' ตำแหน่ง ' + repo.USER_DESCR);
        }
        return repo.USER_NO;
      }

    });   
 
        
    
</script> 


        