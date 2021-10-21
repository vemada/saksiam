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

        <h2 class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 25px">กำหนดสิทธิ์ Authen พนักงาน</h2>

        
                    <?php include('ic/messages.php'); ?>

                    
                      <form action="../controllers/authen_db.php" method="POST">

                        <div class="form-group">
                            <label for="user">SEARCH USER Authen</label>
                            
                            <select class="custom-select my-1 mr-sm-2" id="search_UAS" name="USER_NO" >
                            </select>
                          </div>

                          <div class="form-group">
                                  <label for="emp_id">รหัสพนักงาน</label>
                                  <input type="text" class="form-control" id="USER_ID_1" name="USER_ID" disabled> 
                          </div> 

                          <div class="form-row">
                            <div class="form-group col-md-3">
                                    <label for="firstname">คำนำหน้า</label>
                                    <input type="text" class="form-control"  name="USER_TITLE_NAME" disabled> 
                                    
                            </div>

                            <div class="form-group col-md-4">
                                    <label for="firstname">ชื่อจริง</label>
                                    <input type="text" class="form-control" name="USER_FIRST_NAME" disabled>
                                </div>
                            <div class="form-group col-md-5">
                                    <label for="lastname">นามสกุล</label>
                                    <input type="text" class="form-control" name="USER_LAST_NAME" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                              <label for="position">ตำแหน่ง</label>
                              <input type="position" class="form-control" name="USER_DESCR" disabled>
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

                          <button type="submit" class="btn btn-success" name="auth_update">บันทึก</button>
                      </form>                 
		      </div>
    </div>

    <?php
        include('ic/footer.php');
    ?>



    <script>    
            /* $.getJSON('../controllers/get_emp_uas.php', function (data) {

                $('#search_emp').select2({
                    data : data.results,
                    theme: 'bootstrap4'
                }); 
            */

            $(document).ready(function () {     
                $("#search_UAS").select2({
                    ajax: {
                    url: "../controllers/search_UAS.php",
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                        q: params.term, // search term
                        };
                    },
                    cache: true
                    },
                    placeholder: 'ค้นหารหัสพนักงาน',
                    minimumInputLength: 1,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection, 
                    escapeMarkup: function (markup) { return markup; }, 
                    theme: 'bootstrap4'
                }); 


                $('#search_UAS').on('select2:select', function (e) {
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
                
                if ( repo.USER_ID !== undefined ) {
                return 'รหัสพนักงาน: ' + repo.USER_ID + ('  ,' + repo.USER_TITLE_NAME + ' ' + repo.USER_FIRST_NAME + ' ' + repo.USER_LAST_NAME );
                }

                return repo.USER_ID;
                }

                function formatRepoSelection (repo) {

                if (repo.loading) {
                return repo.text;
                }
                
                if ( repo.USER_ID !== undefined ) {
                return 'รหัสพนักงาน: ' + repo.USER_ID + ('  ,' + repo.USER_TITLE_NAME + ' ' +  repo.USER_FIRST_NAME + ' ' + repo.USER_LAST_NAME );
                }
                return repo.USER_NO;
                }
        }); 
          
             
    
</script> 


        