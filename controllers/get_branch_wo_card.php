<?php

// include "connect_fin_db.php";

include "connect_fin_test.php";

$sql = "SELECT CARD_ORG_NO FROM fin_petty_cash_card ORDER BY CARD_ORG_NO";

$pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

$sth =  $pdo->prepare($sql);
$sth->execute();

$card_nos = $sth->fetchAll(PDO::FETCH_COLUMN,0);

$card_nos = implode(',' , $card_nos);

include "connect.php";

$return_arr = [];

// $sql = "SELECT ORG_NO,ORG_NAME
//         FROM sys_org
//         WHERE ORG_TYPE_NO = 5";

// $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

// $sth =  $pdo->prepare($sql);
// $sth->execute();

// $areas = $sth->fetchAll(PDO::FETCH_ASSOC);

// $sql = "SELECT o1.ORG_NO,o1.ORG_NAME,o1.ORG_CODE,o2.ORG_CODE AS UNIT_CODE,o2.ORG_NO AS UNIT_NO,o2.ORG_NAME AS UNIT_NAME
//         FROM sys_org AS o1
//         LEFT JOIN sys_org AS o2 ON (o2.ORG_TYPE_NO = 2 AND o2.ORG_NO = o1.BASE_ORG_NO)
//         WHERE o1.ORG_NO IN ({$card_nos})
//         ORDER BY o1.ORG_NO";

$sql = "SELECT o1.ORG_NO,o1.ORG_NAME,o1.ORG_TYPE_NO,o2.ORG_NO AS BRANCH_NO,o2.ORG_NAME AS BRANCH_NAME
         FROM sys_org AS o1
JOIN sys_org AS o2 ON o2.ORG_TYPE_NO = 2 AND o2.ORG_NO = o1.BASE_ORG_NO OR (o2.ORG_TYPE_NO = 2 AND o2.ORG_NO = o1.ORG_NO)
WHERE o1.ORG_NO NOT IN ({$card_nos})
ORDER BY o2.ORG_NO,o1.ORG_NO";

$pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

$sth =  $pdo->prepare($sql);
$sth->execute();

$records = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach( $records as $index => $row ) {

    // $id   = $row["ORG_NO"];
    // $name =  $row["ORG_NAME"];
    // $text =  $name;
    $id   = $row["ORG_NO"];
    $name =  $row["ORG_NAME"];

    if( $row['ORG_TYPE_NO'] == 2 ){

        $text =  $name;

    }else{

        $text =  $name . ' ( ' .  $row["BRANCH_NAME"] .' ) ';

    }

    $tempRow = array("id" => $id, "text"=> $text, "name" => $name );

    array_push($return_arr,  $tempRow);

}

// foreach( $areas as $area ){

//     $area_no   = $area['ORG_NO'];
//     $area_name = $area['ORG_NAME'];

//     $sql = "SELECT o1.ORG_NO,o1.ORG_NAME,o1.ORG_CODE,o2.ORG_CODE AS UNIT_CODE,o2.ORG_NO AS UNIT_NO,o2.ORG_NAME AS UNIT_NAME
//     FROM sys_org AS o1
//     JOIN sys_org AS o2 ON (o2.ORG_TYPE_NO = 2 AND o2.ORG_NO = o1.ORG_NO) OR o2.BASE_ORG_NO = o1.ORG_NO
//     WHERE o1.ORG_TYPE_NO = 2 AND o1.BASE_ORG_NO = {$area_no} AND o2.ORG_CODE IN ({$card_codes})
//     ORDER BY o1.ORG_NO,o2.ORG_NO";

//     $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

//     $sth =  $pdo->prepare($sql);
//     $sth->execute();

//     $records = $sth->fetchAll(PDO::FETCH_ASSOC);

//     foreach( $records as $index => $row ) {

//         if( $row['UNIT_NO'] == $row['ORG_NO'] ){

//             $id   = $row["ORG_NO"];
//             $name =  $row["ORG_NAME"];
//             $code =  $row["ORG_CODE"];
        
//             $text =  $name . ' ( ' .  $area_name . ' )';

//         }else{

//             $id = $row["UNIT_NO"];
//             $name =  $row["UNIT_NAME"];
//             $code =  $row["UNIT_CODE"];

//             $text =  $name . ' : ' .  $row["ORG_NAME"] .' ( ' .  $area_name . ' )';
//         }

//         $card = $card_arr[$code];

//         $tempRow = array("id" => $id, "text"=> $text, "name" => $name, "code"=> $code , "card" => $card );
        
//         array_push($return_arr,  $tempRow);
//     }



// }

echo json_encode(
    array("results" => $return_arr),JSON_UNESCAPED_UNICODE 
);

exit();
