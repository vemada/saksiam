<?php

// include "connect_fin_db.php";
include "connect_fin_test.php";
session_start();

$hasCardNumber = isset($_POST['cardNumber']);
$hasCardStatus = isset($_POST['cardStatus']);
$hasCardExpireDated = isset($_POST['cardExpireDated']);
$hasCardBalance = isset($_POST['cardBalance']);
$hasCardId = isset($_POST['cardId']);

$payloadIsValid = $hasCardNumber && $hasCardStatus && $hasCardExpireDated;
$payloadIsValid &= $hasCardBalance && $hasCardId;

if ($payloadIsValid) {
  $isValidCardNumber = false;
  $isValidCardStatus = false;
  $isValidBalance = false;

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
  $cardId = InjectionProtector($_POST['cardId']);

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

  //condition for saving.
  $isSafeData = $isValidCardNumber && $isValidCardStatus;
  $isSafeData &= $isValidBalance;

  //Update Database
  if ($isSafeData) {
    //today
    $todaydate = date("Y-m-d");
    $sqlDate = date('Y-m-d H:i:s', strtotime($todaydate));

    //SQL Command.
    $sql = "UPDATE fin_petty_cash_card
          SET 
            CARD_NUMBER = '{$cardNumber}', CARD_STATUS_NO = '{$cardStatus}', CARD_EXPIRATION_DATE='{$cardExpireDated}',
            CARD_AVAILABLE_BALANCE='{$cardBalance}', UPDATED_DTM='{$sqlDate}'
          WHERE PCC_UUID = '{$cardId}';";
    //query SQL.

    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password); 
    $sth =  $pdo->prepare($sql);
    $sth->execute();    

    $_SESSION['success'] = 'Update petty card สำเร็จ';

  }
  //redirect to .
  header("Location: ../web/petty_cash.php");
  exit();
} else {
  //response
  echo "Invalid payload";
}
