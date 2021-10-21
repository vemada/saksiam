<?php
include "connect_fin_db.php";
// include "connect_fin_test.php";
//get parameter for only http verb get;
$search = $_GET['branchCode'];

//SQL Command.
$sql = "SELECT *
            FROM fin_petty_cash_card
            WHERE CARD_ORG_NO = {$search}";

//query SQL;
$query = mysqli_query($dbhandle, $sql);

//if failed to connect;
if (!$query) {
    die("SQL query failed: " . mysqli_error($dbhandle));
}

//is duplicated or not;
if(mysqli_num_rows($query) == 1){
    $row = mysqli_fetch_assoc($query);
    // print_r($row);
    $temp=array(
        "id"=>$row['PCC_UUID'],
        "card_number"=>$row['CARD_NUMBER'],
        "available_balance"=>$row['CARD_AVAILABLE_BALANCE'],
        'card_status'=>$row['CARD_STATUS_NO'],
        'latest_updated'=>$row['UPDATED_DTM'],
        'card_expiration_date'=>$row['CARD_EXPIRATION_DATE'],
    );
    $status = "success";
   
}else{
    $status = "fail";
    $temp = [];
}

echo json_encode( ['status' =>  $status , 'data' => $temp ]);
