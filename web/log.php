<?php
session_start();

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Logs</title>
    <?php 
      include('ic/head.php');
    ?>
    <link rel="stylesheet" href="../libs/datatables/datatables.min.css">
    <link rel="stylesheet" href="../libs/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">

    <style>

        td.data-cell{
            white-space: break-spaces !important;
        }
    </style>

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
        
        <h2 id="title" class="mb-4" style="font-family: 'Prompt', sans-serif; font-size: 25px">
          DMT Logs
        </h2>
        
        <table id="log" class="row-border nowrap" width="100%" style="word-wrap:break-word;table-layout: fixed;">
            <thead>
                <tr>
                    <th>no</th>
                    <th>Contract</th>
                    <th>Username</th>
                    <th>Org</th>
                    <th>Type</th>
                    <th>Data</th>
                    <th>DTM</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>no</th>
                    <th>Contract</th>
                    <th>Username</th>
                    <th>Org</th>
                    <th>Type</th>
                    <th>Data</th>
                    <th>DTM</th>
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

              // reportTable.destroy();
          var reportTable = $('#log').DataTable( {
              "lengthMenu": [ [ 50, 100, -1], [ 50, 100, "All"] ],
              // "scrollX": true,
              "processing": true,
              "deferRender": true,
              "cache": false,
              // "serverSide": true,
              "ajax": {
                "url": "../controllers/get_log.php"
              },
              "columns": [
                { "data": "no" },
                { "data": "contract_code" },
                { "data": "username" },
                { "data": "org_name" },
                { "data": "type" },
                { "data": "data" },
                { "data": "dtm" },
              ],
              "columnDefs": [
                {
                    targets: 4,
                    className:'data-cell'
                },
                { "width": "2.5%", "targets": 0 },
                { "width": "5%", "targets": 4 },
                { "width": "10%", "targets": [1,2,3] },
                { "width": "15%", "targets": 6 },
                { "width": "47.5%", "targets": 5 }
              ],
              dom: 'Bfrtip',
              buttons: [
                  {
                      extend: 'excelHtml5',
                      text: 'Export excel',
                      className: 'mb-4',
                      title: 'dmt_logs' , 
                      filename: 'dmt_logs' ,
                  }
              ], 
          });

        });
    </script>
    
  </body>
</html> 