<?php

    include "connect.php";

    session_start();
    $location = [];
    // $strJsonFileContents = file_get_contents("../web/json/province.json");
    // $provinces = json_decode($strJsonFileContents, true);
    // $strJsonFileContents = file_get_contents("../web/json/amphur.json");
    // $amphurs = json_decode($strJsonFileContents, true);
    $strJsonFileContents = file_get_contents("../web/json/zipcodes.json");
    $zipcodes = json_decode($strJsonFileContents, true);

    // foreach( $provinces as $province ){

    //     $location[$province['ADDR_PROVINCE_NO']] = array_filter($amphurs, function($v) use ($province) {
    //         return $v['ADDR_PROVINCE_NO'] == $province['ADDR_PROVINCE_NO'];
    //     }, ARRAY_FILTER_USE_BOTH);
    // }

    // $json = json_encode(
    //     array("province"=>$location),JSON_UNESCAPED_UNICODE
    // );

    // $file = fopen( 'provinces.json' ,'w');
    // fwrite($file, $json);
    // fclose($file);

    // $location = [];
    // foreach( $zipcodes as $zipcode ){
    //     $location[$zipcode['district_code']] = array_filter($districts, function($v) use ($amphur) {
    //         return $v['ADDR_AMPHUR_NO'] == $amphur['ADDR_AMPHUR_NO'];
    //     }, ARRAY_FILTER_USE_BOTH);
    // }

    foreach( $zipcodes as $zipcode ){
        $location[$zipcode['district_code']] = $zipcode['zipcode_name'];
    }

    $json = json_encode(
        array($location),JSON_UNESCAPED_UNICODE
    );

    $file = fopen( 'zipcodes.json' ,'w');
    fwrite($file, $json);
    fclose($file);


    
?>