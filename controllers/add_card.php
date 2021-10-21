<?php

// include "connect_fin_db.php";
include "connect_fin_test.php";
session_start();

$hasCardNumber = isset($_POST['cardNumber']);
$hasCardStatus = isset($_POST['cardStatus']);
$hasCardExpireDated = isset($_POST['cardExpireDated']);
$hasCardBalance = isset($_POST['cardBalance']);
$hasCardOrgNo = isset($_POST['card_org_no']);

$payloadIsValid = $hasCardNumber && $hasCardStatus && $hasCardExpireDated;
$payloadIsValid &= $hasCardBalance && $hasCardOrgNo;

if ($payloadIsValid) {
  $isValidCardNumber = false;
  $isValidCardStatus = false;
  $isValidBalance = false;
  $isValidCardOrgNo=false;

  $cardStatusList = array("1", "2", "3", "4", "5");

  function InjectionProtector($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  function CardNumberValidator($cardNumberArg)
  {
    if (strlen($cardNumberArg) == 16) {
      if (is_numeric($cardNumberArg)) {
        $GLOBALS["isValidCardNumber"] = true;
      }
    }
  }
  function CardOrgNoValidator($cardOrgNoArg){
    if (strlen($cardOrgNoArg)>0) {
      if (is_numeric($cardOrgNoArg)) {
        $GLOBALS["isValidCardOrgNo"] = true;
      }
    }
  }

  function CardStatusValidator($cardStatusArg)
  {
    if (in_array($cardStatusArg, $GLOBALS["cardStatusList"], TRUE)) {
      $GLOBALS["isValidCardStatus"] = true;
    }
  }
  function CardBalanceValidator($cardExpireDateArg)
  {
    if (is_numeric($cardExpireDateArg)) {
      $GLOBALS["isValidBalance"] = true;
    }
  }

  //prevent injection.
  $cardNumber = InjectionProtector($_POST['cardNumber']);
  $cardStatus = InjectionProtector($_POST['cardStatus']);
  $cardExpireDated = InjectionProtector($_POST['cardExpireDated']);
  $cardBalance = InjectionProtector($_POST['cardBalance']);
  $cardOrgNo=InjectionProtector($_POST['card_org_no']);

  // $tempCardStatus = 1;
  // switch ($cardStatus) {
  //   case $cardStatusList[0]:
  //     $tempCardStatus = 1;
  //     break;
  //   case $cardStatusList[1]:
  //     $tempCardStatus = 2;
  //     break;
  //   case $cardStatusList[2]:
  //     $tempCardStatus = 3;
  //     break;
  //   case $cardStatusList[3]:
  //     $tempCardStatus = 4;
  //     break;
  //   case $cardStatusList[4]:
  //     $tempCardStatus = 5;
  //     break;
  // }

  //Add Validator.
  CardNumberValidator($cardNumber);
  CardStatusValidator($cardStatus);
  CardBalanceValidator($cardBalance);
  CardOrgNoValidator($cardOrgNo);

  //condition for saving.
  $isSafeData = $isValidCardNumber && $isValidCardStatus;
  $isSafeData &= $isValidBalance&&$isValidCardOrgNo;

  // echo $isValidCardNumber;
  // echo $isValidCardStatus;
  // echo $isValidBalance;
  // echo $isValidCardOrgNo;
  // die;
  //Update Database
  if ($isSafeData) {

    //today
    $todaydate = date("Y-m-d");
    $sqlDate = date('Y-m-d', strtotime($todaydate));
    $null='NULL';

    //SQL Command.
    $sql="INSERT INTO fin_petty_cash_card(
        `PCC_UUID`, 
        `CARD_NUMBER`, 
        `CARD_NAME`,
        `CARD_HOLDER_NAME`,
        `CARD_EXPIRATION_DATE`,
        `CARD_ACTIVE_STATUS_NO`,
        `CARD_STATUS_NO`,
        `CREATED_DTM`,
        `UPDATED_DTM`,
        `CARD_AVAILABLE_BALANCE`,
        `CARD_ORG_NO`,
        `PCC_MEMO`
        ) 
        VALUES (
        UUID(), 
        {$cardNumber}, 
        'AAC3', 
        'SAKSIAM LEASING PUBLIC COMPANY LIMITED', 
        '${cardExpireDated}', 
        1, 
        '${cardStatus}', 
        '${sqlDate}',
        '${sqlDate}',
        ${cardBalance},
        ${cardOrgNo},
        ${null});
        ";
    //query SQL.
    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password); 
    $sth =  $pdo->prepare($sql);
    $sth->execute();    
    // $query = mysqli_query($dbhandle, $sql);

    $_SESSION['success'] = 'Add petty card สำเร็จ';

  }else{
    echo 1; die;
  }

  

  //redirect to .
  header("Location: ../web/add_petty_cash.php");
  exit();
}
