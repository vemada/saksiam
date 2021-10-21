<?php
session_start();
include('../controllers/slicense_db.php');

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Copy สิทธิ์การเข้าใช้งานระบบ</title>
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

        <h2 class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 25px">ระบบงาน LMIS(การ Copy สิทธิ์การเข้าใช้งานระบบ)</h2>
        
        <form action="" method="POST">
                    <br/>
                    <?php include('ic/messages.php'); ?>
                    
                        <h2 class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 18px;  font-weight: bold;">กรุณาเลือก User Name พนักงาน( เลือกได้มากกว่า 1 )</h2>
                        <br/>
                        <div class="form-group row">
                            <label for="num" class="col-sm-3 col-form-label" style="font-size: larger;">Username พนักงาน</label>
                            <div class="col-sm-6">
                            <!-- <input type="num" class="form-control" id="num" placeholder=""> -->
                            <select id="search_username_1" class="search_username form-control" name="user_id_1[]" multiple="multiple">
                            </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="firstname">ชื่อจริง</label>
                            <input type="firstname" class="form-control" id="firstname_1" placeholder="" readonly>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="lastname">นามสกุล</label>
                            <input type="lastname" class="form-control" id="lastname_1" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="olddate">สาขา/หน่วย</label>
                            <input type="brand" class="form-control" id="org_1" placeholder="" readonly>
                        </div>
                      
                        <div class="form-group">
                            <label for="position">ตำแหน่ง</label>
                            <input type="position" class="form-control" id="position_1" placeholder="" readonly>
                        </div>
                        <!-- <input name="user_id_1" type="hidden" id="user_id_1" /> -->
              
                <br/>
                <br/>
                <br/>

                <h2 class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 18px; font-weight: bold;">กรุณาเลือก User Name พนักงานที่ต้องการ copy สิทธิ์</h2>
                <br/>
                <div class="form-group row" >
                    
                    <label for="num" class="col-sm-3 col-form-label" style="font-size: larger;">Username พนักงาน</label>
                    <div class="col-sm-6">
                    <!-- <input type="num" class="form-control" id="num" placeholder=""> -->
                    <select id="search_username_2" name="user_id_2" class="search_username form-control">
                    </select>

                    </div>
                </div>
                <br/>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="firstname">ชื่อจริง</label>
                    <input type="firstname" class="form-control" id="firstname_2" placeholder="" readonly>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="lastname">นามสกุล</label>
                    <input type="lastname" class="form-control" id="lastname_2" placeholder="" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="brand">สาขา/หน่วย</label>
                    <input type="brand" class="form-control" id="org_2" placeholder="" readonly>
                </div>
               
                <div class="form-group">
                    <label for="position">ตำแหน่ง</label>
                    <input type="position" class="form-control" id="position_2" placeholder="" readonly>
                </div>

                <!-- <input name="user_id_2" type="hidden" id="user_id_2" /> -->
                <button type="submit" id="submitBtn" class="btn btn-success" disabled>Copy สิทธิ์</button>  
        </form>

		</div>
    </div>

    <?php
        include('ic/footer.php');
    ?>
    
    <script>
          $(".search_username").select2({
              ajax: {
              url: "../controllers/search_username.php",
              dataType: 'json',
              delay: 2000,
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

        $('#search_username_1').on('select2:select', function (e) {
            var data = e.params.data;
            $('#position_1').val(data.position);
            $('#firstname_1').val(data.firstname);
            $('#lastname_1').val(data.lastname);
            $('#org_1').val(data.org);
            // $('#user_id_1').val(data.id);
        });

        $('#search_username_2').on('select2:select', function (e) {
            var data = e.params.data;
            $('#position_2').val(data.position);
            $('#firstname_2').val(data.firstname);
            $('#lastname_2').val(data.lastname);
            $('#org_2').val(data.org);
            $('#submitBtn').prop('disabled',false);
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