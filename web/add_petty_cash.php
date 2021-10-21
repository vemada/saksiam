<?php
session_start();

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<!doctype html>
<html lang="en">

<head>
  <title>Search</title>

  <?php 
      include('ic/headpassword.php');
    ?>

</head>

<body>

  <!-- begin::wrapper petty_cash -->
  <div class="wrapper d-flex align-items-stretch">
    <?php
      include('ic/sidebar.php');
      ?>

    <!-- begin::Page Content  -->
    <div id="content" class="p-4 p-md-5">

      <?php include('ic/navbar.php'); ?>
      <!-- begin::main header -->
      <h2 class="mb-4">เพิ่มข้อมูล Petty Cash Card</h2>
      <!-- end::main header -->

      <?php include('ic/messages.php');?>

      <!-- begin::form -->
      <form method="POST" action="../controllers/add_card.php" id="cardForm" autocomplete="off">

        <!-- begin::select branch -->
      <div class="form-group row">
        <label for="branchSearch" class="col-md-4 col-form-label text-md-right">กรุณาเลือกสาขา</label>
        <div class="col-md-6">
          <select style="width: 100%;" id="branchSearch" class="form-control" name="branchSearch">
            <option></option>
          </select>
        </div>
        <div class="col-md-2">
        </div>
      </div>
      <!-- end::select branch -->

        <!-- begin::cardNumber -->
        <div class="form-group row">
          <label for="cardNumber" class="col-md-4 col-form-label text-md-right">เลขบัตร</label>
          <div class="col-md-6">
            <input minlength="16" maxlength="16" pattern="[0-9]{16}" required title="Please enter 16 numbers" name='cardNumber' id="cardNumber"
              type="text" class="form-control">
          </div>
        </div>
        <!-- end::cardNumber -->

        <!-- begin::cardStatus -->
        <div class="form-group row">
          <label for="cardStatus" class="col-md-4 col-form-label text-md-right">สถานะบัตร</label>
          <div class="col-md-6">
                <select id="cardStatus" name="cardStatus" class="form-control">
                  <option value="1">ปกติ</option> 
                  <option value="2">Block S</option>
                  <option value="3">Block L</option>
                  <option value="4">Block R</option>
                  <option value="5">Expired</option>
              </select>
            <!-- <input pattern="^(ปกติ|Block S|Block L|Block R|Expired)$" required value="ปกติ" id="cardStatus" type="text"
              class="form-control" name="cardStatus"> -->
          </div>
        </div>
        <!-- end::cardStatus -->

        <!-- begin::expiredDate -->
        <div class="form-group row">
          <label for="cardExpireDated" class="col-md-4 col-form-label text-md-right">วันหมดอายุของบัตร</label>
          <div class="col-md-6">
            <input required type="date" id="cardExpireDated" class="form-control" name="cardExpireDated">
          </div>
        </div>
        <!-- end::expiredDate -->

        <!-- begin::cardBalance -->
        <div class="form-group row">
          <label for="cardBalance" class="col-md-4 col-form-label text-md-right">วงเงินบัตร</label>
          <div class="col-md-6">
            <input minlength="0" required type="number" id="cardBalance" class="form-control" name="cardBalance">
          </div>
        </div>
        <!-- end::cardBalance -->

        <!-- begin::hidden cardId -->
        <input required type="hidden" name="card_org_no" id="card_org_no">
        <!-- end::hidden cardId -->

        <!-- begin::Button div -->
        <div class="d-grid gap-2 col-4 mx-auto" style="text-align: center;">
          <button type="submit" class="btn btn-primary rounded-pill">ยืนยัน</button>
          <button type="button" class="btn btn-primary rounded-pill">ยกเลิก</button>
        </div>
        <!-- end::Button div -->
      </form>
      <!-- end::form -->
    </div>
    <!-- end::Page Content -->
  </div>
  <!-- end::wrapper petty_cash -->

  <?php
      include('ic/footer.php');
    ?>
    <script>
    //select2 initialize

    $.getJSON('../controllers/get_branch_wo_card.php', function (data) {

        $('#branchSearch').select2({
            data : data.results,
            theme: 'bootstrap4',
            placeholder: "เลือกสาขา/หน่วย",
            allowClear: true
        });

    });

    // $("#branchSearch").select2({
    //   ajax: {
    //     url: "../controllers/search_branch.php",
    //     dataType: 'json',
    //     delay: 500,
    //     data: function (params) {
    //       return {
    //         q: params.term, // search term
    //       };
    //     },
    //     cache: true
    //   },
    //   placeholder: 'ค้นหาสาขา',
    //   minimumInputLength: 0,
    //   templateResult: formatRepoSelection,
    //   templateSelection: formatRepo
    // });
    
    //callback when select2 is selected;
    $('#branchSearch').on('select2:select', function (e) {
      var data = e.params.data;
      console.log(data);
      document.getElementById("card_org_no").value=data.id;

      var now = new Date();
      now.setFullYear(now.getFullYear() + 5);
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);

      var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

      console.log(today);
      document.getElementById("cardExpireDated").value=today;
      document.getElementById("cardBalance").value=400000;
      
    });

    //template for select2 read doc;
    function formatRepo(repo) {
      return repo.name;
    }

    //template for select2 read doc;
    function formatRepoSelection(repo) {
      return repo.name;
    }
  </script>
</body>

</html>