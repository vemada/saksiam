<?php
  session_start();

  if( !isset( $_SESSION['username']) ){
    header("location: LMISlogin.php");
  }

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Payment Report</title>
    <?php 
      include('ic/head.php');
    ?>
    <link rel="stylesheet" href="../libs/datatables/datatables.min.css">
    <link rel="stylesheet" href="../libs/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
   
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

        $month_arr=array(
          "1"=>"มกราคม",
          "2"=>"กุมภาพันธ์",
          "3"=>"มีนาคม",
          "4"=>"เมษายน",
          "5"=>"พฤษภาคม",
          "6"=>"มิถุนายน", 
          "7"=>"กรกฎาคม",
          "8"=>"สิงหาคม",
          "9"=>"กันยายน",
          "10"=>"ตุลาคม",
          "11"=>"พฤศจิกายน",
          "12"=>"ธันวาคม"                 
        );

        $month = date("Y-m-t");
        $last_month = date("Y-m-t", strtotime( date( 'Y-m-01' )." -1 month"));

        $year  = date("Y");
        $month_name = $month_arr[date("n", strtotime($month) )];

        ?>
        <h2 id="title" class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 25px">
          รายงานปิดทริป(RTP-040) : <span id="org_name"><?php echo $_SESSION['org_no'] == '1' ? 'สาขาอุตรดิตถ์' : $_SESSION['org_name'];?></span>  ประจำเดือน <span id="month-year"><?php echo $month_name;?> - <?php echo $year;?></span>
        </h2>
        
        <div class="row mb-4">
          <div class="col-auto">
            <label for="month" class="h5">เลือกเดือนที่ต้องการ</label>
          </div>
          <div class="col-auto">
            <select id="month" name="mont" class="form-control">
              <?php 
              for ($i = 0; $i <= 1; $i++) {
                  $month = date("Y-m-t", strtotime( date( 'Y-m-01' )." -$i months"));
                  $year  = date("Y", strtotime( date( 'Y-m-01' )." -$i months"));
                  $month_name =  $month_arr[date("n", strtotime($month) )];
              ?>
                <option value="<?php echo $month;?>"><?php echo $month_name;?> - <?php echo $year;?></option>
              <?php } ?>
            </select>
          </div>

          <?php if( $_SESSION['org_no'] == '1' || $_SESSION['username'] == 'sys_admin' ){ ?>
            <!-- <div class="col-auto">
              <select id="org2_no" class="form-control">
              </select>
            </div>
              <div class="col-auto">
              <select id="org3_no" class="form-control">
                  <option value="2" selected>สาขาอุตรดิตถ์</option>
              </select>
            </div> -->
            <div class="col-3">
              <select id="org_search" class="form-control">
              </select>
            </div>
          <?php }else if( isset($_SESSION['area_mgr']) && $_SESSION['area_mgr'] == 1 ){ ?>
                <input type="hidden" id="areaMgr" val="1"/>
                <div class="col-auto">
                  <select id="org2_no" class="form-control">
                  </select>
                </div>
                <div class="col-auto">
                  <select id="org3_no" class="form-control">
                  </select>
              </div>
          <?php }else if( isset($_SESSION['branch_mgr']) && $_SESSION['branch_mgr'] == 1 ){ ?>
                <input type="hidden" id="branchMgr" val="1"/>
               <div class="col-auto">
                    <select id="org3_no" class="form-control">
                    </select>
                </div>
          <?php } ?>

          <div class="col-auto">
            <button id="genReport" class="btn btn-secondary" type="button">
                Generate
            </button>
          </div>

          <input type="hidden" id="org_no" value="<?php echo $_SESSION['org_no'] == 1 ? 2 : $_SESSION['org_no'];?>" />

          <?php if( $_SESSION['username'] == 'sys_admin' ){ ?>

            <div class="col-auto">
                <form id="genForm" action="">
                    <button id="genAll" class="btn btn-danger">
                        Gen Reports
                    </button>
                    <!-- <input type="hidden" id="gen" val="0"/> -->
                    <input type="hidden" name="gen_month" val="<?php echo $last_month;?>" />
                </form>
            </div>
          <?php } ?>

        </div>

        <table id="report" class="row-border nowrap" style="width:150%">
            <thead>
                <tr>
                    <th>no</th>
                    <th>รหัส</th>
                    <th>ชื่อ-สกุล</th>
                    <th>ค่างวดต่อเดือน</th>
                    <th>งวดที่เก็บ</th>
                    <th>จำนวนเงิน</th>
                    <th>ยอดค้าง</th>
                    <th>เป้าหมาย</th>
                    <th>ยอดเก็บ</th>
                    <th>ค้างใหม่</th>
                    <th>ล่วงหน้า</th>
                    <th>ปรับ</th>
                    <th>ปิดสด</th>
                    <th>รถยึด</th>
                    <th>เงินต้นชำระ</th>
                    <th>ดอกเบี้ย</th>
                    <th>ค่าธรรมเนียมบริการ</th>
                    <th>ประเภทสินเชื่อ</th>
                    <th>สถานะลูกค้า</th>
                    <th>สถานะสัญญา</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                  <th>no</th>
                  <th>รหัส</th>
                  <th>ชื่อ-สกุล</th>
                  <th>ค่างวดต่อเดือน</th>
                  <th>งวดที่เก็บ</th>
                  <th>จำนวนเงิน</th>
                  <th>ยอดค้าง</th>
                  <th>เป้าหมาย</th>
                  <th>ยอดเก็บ</th>
                  <th>ค้างใหม่</th>
                  <th>ล่วงหน้า</th>
                  <th>ปรับ</th>
                  <th>ปิดสด</th>
                  <th>รถยึด</th>
                  <th>เงินต้นชำระ</th>
                  <th>ดอกเบี้ย</th>
                  <th>ค่าธรรมเนียมบริการ</th>
                  <th>ประเภทสินเชื่อ</th>
                  <th>สถานะลูกค้า</th>
                  <th>สถานะสัญญา</th>
                  <th>Type</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php
    include('ic/footer.php');
    ?>

<script src="../libs/datatables/datatables.min.js"></script>

    <script>
      $(document).ready(function() {

            if(  $('#org2_no').length ){
            
                var url = 'json/org_2.json';

                if( $('#areaMgr').length ){
          
                    var count = 0;
                    var branch_no,branch_name;
                  
                    $.getJSON(url, function (data) {
                      $.each(data, function (key, entry) {

                        var base_org = $('#org_no').val();
                      
                        if(entry.BASE_ORG_NO == base_org ){

                            if( count == 0 ){
                                $("#org2_no").append('<option value="'+entry.ORG_NO+'" selected="selected">'+ entry.ORG_NAME +'</option>');
                                branch_no = entry.ORG_NO;
                                branch_name = entry.ORG_NAME;
                                count++;
                                
                            }else{
                                $("#org2_no").append($('<option></option>').attr('value', entry.ORG_NO).text(entry.ORG_NAME));
                            }
                        }
                      })
                     
                      $("#org_no").val(branch_no);

                      url = 'json/org_3.json';
               
                      $("#org3_no").append($('<option></option>').attr('value',branch_no).text(branch_name));
 
                      $.getJSON(url, function (data) {
                        $.each(data, function (key, entry) {

                          if(entry.BASE_ORG_NO == branch_no ){
                        
                              $("#org3_no").append($('<option></option>').attr('value', entry.ORG_NO).text(entry.ORG_NAME));
                          }
                        })
                      });

                    });

                }else {

                  $.getJSON(url, function (data) {
                    $.each(data, function (key, entry) {
                      $('#org2_no').append($('<option></option>').attr('value', entry.ORG_NO).text(entry.ORG_NAME));
                    })
                  });

                }

            }

            if(  $('#org3_no').length ){

               url = 'json/org_3.json';
               if( $('#branchMgr').length ){

                  var base_org = $('#org_no').val();
                  var base_org_name = $('#org_name').text();
              
                   $("#org3_no").append($('<option></option>').attr('value',base_org).text(base_org_name));

                  $.getJSON(url, function (data) {
                    $.each(data, function (key, entry) {

                      if(entry.BASE_ORG_NO == base_org ){
                          $("#org3_no").append($('<option></option>').attr('value', entry.ORG_NO).text(entry.ORG_NAME));
                      }
                    })
                  });

                }else{

                    $.getJSON(url, function (data) {
                      $.each(data, function (key, entry) {
                        if(entry.BASE_ORG_NO == '2' ){
                            $("#org3_no").append($('<option></option>').attr('value', entry.ORG_NO).text(entry.ORG_NAME));
                        }
                      })
                    });

                }

            }

            $('#org2_no').on('change' , function(e){
                
                var base_org   = $("#" + this.id).val();
                var base_org_name = $("#" + this.id + " > option:selected").text();
                $('#org_name').html( base_org );
                $('#org_no').val( base_org_name );

                $("#org3_no").empty();
                $("#org3_no").append($('<option></option>').attr('value',base_org).text(base_org_name));
                
                var url = 'json/org_3.json';

                $.getJSON(url, function (data) {
                  $.each(data, function (key, entry) {
                    
                    if(entry.BASE_ORG_NO == base_org ){
                        $("#org3_no").append($('<option></option>').attr('value', entry.ORG_NO).text(entry.ORG_NAME));
                    }
                  })
                });
            }); 

            $('#org3_no').on('change' , function(e){

                var org_no   = $("#" + this.id).val();
                var org_name = $("#" + this.id + " > option:selected").text();
                $('#org_name').html( org_name );
                $('#org_no').val( org_no );
            
            }); 
          
          $.getJSON('json/sys_org.json', function (data) {

              $("#org_search").select2({
                placeholder: 'ค้นหา สาขา/หน่วย',
                selectOnClose: false,
                theme: 'bootstrap4',
                data: data.results,
              }).on('select2:select', function (e) {

                  var data = e.params.data;
                  $('#org_name').html( data.text );
                  $('#org_no').val( data.id );

              });
          });
      
          // $('#org_search').on('select2:select', function (e) {

          //     var data = e.params.data;
          //     $('#org_name').html( data.text );
          //     $('#org_no').val( data.id );
        
          // });
          
          // $('body').on('initTableDraw' , function( e , url){

            var reportTable = $('#report').DataTable({
                "scrollX": true,
                "columns": [
                    { "data": "no" },
                    { "data": "code" },
                    { "data": "name" },
                    { "data": "a" },
                    { "data": "b" },
                    { "data": "c" },
                    { "data": "d" },
                    { "data": "e" },
                    { "data": "f" },
                    { "data": "g" },
                    { "data": "h" },
                    { "data": "i" },
                    { "data": "j" },
                    { "data": "k" },
                    { "data": "l" },
                    { "data": "m" },
                    { "data": "n" },
                    { "data": "o" },
                    { "data": "p" },
                    { "data": "q" },
                    { "data": "r" }
                  ]
            });

            $('body').on('initTableDraw' , function( e , url ){

              reportTable.destroy();
              reportTable = $('#report').DataTable( {
                  "lengthMenu": [ [ 20, 100, -1], [ 20, 100, "All"] ],
                  "scrollX": true,
                  "processing": true,
                  "deferRender": true,
                  "cache": false,
                  // "serverSide": true,
                  "ajax": {
                    "url": url,
                    "data": function ( d ) {
                        d.month  = $('#month').val();
                        d.org_no = $('#org_no').val();
                    }
                  },
                  "columns": [
                    { "data": "no" },
                    { "data": "code" },
                    { "data": "name" },
                    { "data": "a" },
                    { "data": "b" },
                    { "data": "c" },
                    { "data": "d" },
                    { "data": "e" },
                    { "data": "f" },
                    { "data": "g" },
                    { "data": "h" },
                    { "data": "i" },
                    { "data": "j" },
                    { "data": "k" },
                    { "data": "l" },
                    { "data": "m" },
                    { "data": "n" },
                    { "data": "o" },
                    { "data": "p" },
                    { "data": "q" },
                    { "data": "r" }
                  ],
                  "columnDefs": [
                    {
                        targets: "_all",
                        className:'text-right'
                    }
                  ],
                  dom: 'Bfrtip',
                  buttons: [
                      {
                          extend: 'excelHtml5',
                          text: 'Export excel',
                          className: 'mb-4',
                          title: function(){ return $.trim($('#title').text()); }, 
                          filename: function(){ return $.trim($('#title').text()); }, 
                      }
                  ],
                  // "initComplete": function( settings, json ) {

                  //     if( $('#gen').val() == 1 ){
                  //         $('.buttons-excel').click();
                  //     }

                  // }
              });
            });

            // var json_url = '../reports/rtp-040/' + $('#org_no').val() + '_' +  $('#month').val()  + '.json';
            // var report_url = "../controllers/get_report.php";

            // $.getJSON(json_url)
            // .done(function (data, textStatus, jqXHR) { 
            //     /* success */ 
            //     $('body').trigger('initTableDraw', [json_url]);
                
            // }).fail(function (data, textStatus, jqXHR) { 
            //     /* fail */ 
            //     $('body').trigger('initTableDraw', [report_url]);
            // });

          $('#month').on('change', function () {
        
              $('#month-year').html( $("#month > option:selected").text() );
              // $('body').trigger('initTableDraw');
              // reportTable.ajax.reload();
              // reportTable.draw().ajax.reload(function() {
              //     $('.buttons-excel').click()
              // });
          });

          $('#genReport').on('click',function(){

            var json_url = '../reports/rtp-040/' + $('#org_no').val() + '_' +  $('#month').val()  + '.json';

            $.getJSON(json_url)
            .done(function (data, textStatus, jqXHR) { 
                /* success */ 
                var json_url = '../reports/rtp-040/' + $('#org_no').val() + '_' +  $('#month').val()  + '.json';
               
                $('body').trigger('initTableDraw', [json_url]);
                
            }).fail(function (data, textStatus, jqXHR) { 
                /* fail */ 
                var report_url = "../controllers/get_report.php";

                $('body').trigger('initTableDraw', [report_url] );
            });

            // reportTable.ajax.url(report_url).load()
          
          });
 
          // const timer = ms => new Promise(res => setTimeout(res, ms))
          $('#genAll').on('click',function(){

              $(this).prop('disabled',true);
              $('#genReport').prop('disabled',true);
              $('.buttons-excel').prop('disabled',true);

              $.ajax({
                  url: '../controllers/gen_report.php',
                  type: 'post',
                  dataType: 'json',
                  data: $("#genForm").serialize(),
                  contentType: 'application/json',
                  success: function (data) {
                    
                    $('#genAll').prop('disabled',false);
                    $('#genReport').prop('disabled',false);
                    $('.buttons-excel').prop('disabled',false);
                    
                  },

              });

          });

      });
    </script>
    
  </body>
</html> 