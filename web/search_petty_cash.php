<?php
session_start();

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<?php 
  include('../controllers/update_card.php');
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
      <h2 class="mb-4">แก้ไขข้อมูล Petty Cash Card</h2>
      <!-- end::main header -->

      <?php include('ic/messages.php');?>
      <!-- begin::select branch -->
      <div class="form-group row">
        <label for="branchSearch" class="col-md-4 col-form-label text-md-right">กรุณาเลือกสาขา</label>
        <div class="col-md-6">
          <select style="width: 100%;" id="branchSearch" class="form-control" name="branchSearch">
          </select>
        </div>
        <div class="col-md-2">
        </div>
      </div>
      <!-- end::select branch -->

      <!-- begin::disabled card number -->
      <div class="form-group row">
        <label for="disabledCardNumber" class="col-md-4 col-form-label text-md-right">เลขบัตร</label>
        <div class="col-md-6">
          <input disabled id="disabledCardNumber" type="text" class="form-control">
        </div>
      </div>
      <!-- end::disabled card number -->

      <!-- begin::disabled card balance -->
      <div class="form-group row">
        <label for="disabledCardBalance" class="col-md-4 col-form-label text-md-right">วงเงินบัตร</label>
        <div class="col-md-6">
          <input id="disabledCardBalance" type="text" class="form-control" disabled>
        </div>
      </div>
      <!-- end::disabled card balance -->

      <!-- begin::disabled card status -->
      <div class="form-group row">
        <label for="disabledCardStatus" class="col-md-4 col-form-label text-md-right">สถานะบัตร</label>
        <div class="col-md-6">
          <input type="text" id="disabledCardStatus" class="form-control" disabled>
        </div>
      </div>
      <!-- end::disabled card status -->

      <!-- begin::disabled latest update -->
      <div class="form-group row">
        <label for="disabledLatestUpdated"
          class="col-md-4 col-form-label text-md-right">วันที่อัพเดตข้อมูลล่าสุด</label>
        <div class="col-md-6">
          <input type="text" id="disabledLatestUpdated" class="form-control" disabled>
        </div>
      </div>
      <!-- begin::disabled latest update -->

      <!-- begin::sub header -->
      <div class="form-group row">
        <label for="password" class="col-md-5 col-form-label text-md-right">กรุณาใส่ข้อมูลที่ต้องการเปลี่ยนแปลง</label>
      </div>
      <!-- end::sub header -->

      <!-- begin::form -->
      <form method="POST" action="controllers/update_card.php" id="cardForm" autocomplete="off">

        <!-- begin::cardNumber -->
        <div class="form-group row">
          <label for="cardNumber" class="col-md-4 col-form-label text-md-right">เลขบัตร</label>
          <div class="col-md-6">
            <input minlength="16" maxlength="16" pattern="[0-9]{16}" required name='cardNumber' id="cardNumber"
              type="text" class="form-control">
          </div>
        </div>
        <!-- end::cardNumber -->

        <!-- begin::cardStatus -->
        <div class="form-group row">
          <label for="cardStatus" class="col-md-4 col-form-label text-md-right">สถานะบัตร</label>
          <div class="col-md-6">
            <input pattern="^(ปกติ|Block S|Block L|Block R|Expired)$" required value="ปกติ" id="cardStatus" type="text"
              class="form-control" name="cardStatus">
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
        <input type="hidden" name="cardId" id="cardId">
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
    $("#branchSearch").select2({
      ajax: {
        url: "../controllers/search_branch.php",
        dataType: 'json',
        delay: 500,
        data: function (params) {
          return {
            q: params.term, // search term
          };
        },
        cache: true
      },
      placeholder: 'ค้นหาสาขา',
      minimumInputLength: 0,
      templateResult: formatRepoSelection,
      templateSelection: formatRepo
    });
    
    //callback when select2 is selected;
    $('#branchSearch').on('select2:select', function (e) {
      var data = e.params.data;
      $.ajax({
        url: "../controllers/GetCardDataFromBranch.php",
        method: "get",
        data: {
          branchId: data.id
        },
        success: function (e) {
          //json string->obj
          let tempData = JSON.parse(e);
          //set value for each element;
          document.getElementById("disabledCardNumber").value = tempData.card_number;
          document.getElementById('disabledCardBalance').value = tempData.available_balance;
          document.getElementById('disabledLatestUpdated').value = (tempData.latest_updated).split(' ')[0];
          let tempStatus = '';
          switch (tempData.card_status) {
            case '1':
              tempStatus = 'ปกติ';
              break;
            case '2':
              tempStatus = 'Block S';
              break;
            case '3':
              tempStatus = 'Block L';
              break;
            case '4':
              tempStatus = 'Block R';
              break;
            case '5':
              tempStatus = 'Expired';
              break;
            default:
              break;
          }
          //set value for each element;
          document.getElementById('disabledCardStatus').value = tempStatus;
          document.getElementById('cardId').value = tempData.id;
        }
      });

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