<?php 

session_start();

include "connect_test.php";

$data = json_decode($_POST['data']);
$rec_no = $data->rec_no;
$contract_code = $data->contract_code;
$old_data  = (array)$data->old_data;
$new_data = (array)$data->new_data;
$errorInfos=[];

$update_data = $new_data;

$log = [];
$log['contract_code']   = $contract_code;
$log['username'] = $_SESSION['username'];
$log['org_name']   = $_SESSION['org_name'];
$log['type']     = "update";
$log['data']     = [];
$log['dtm']      = date('Y-m-d H:i:s');

if (isset($rec_no) ){
    
    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password); 

    $g_POST = [];
    $c_POST = [];

    foreach ( $new_data as $key => $value){

        $old = $old_data[$key] ?? null;
     
        if( str_contains( $key, 'g_') ){
            
            $g_key = str_replace('g_',"",$key);
            $g_POST[$g_key] = $value;
            unset($new_data[$key]);
        
            $log['data']['guarantor.'.$g_key] = ['old_value'=>$old,'new_value'=>$value];

        }else{

            $c_POST[$key] = $value;
            $log['data'][$key] = ['old_value'=>$old,'new_value'=>$value];
        }
    }

    if( !empty($c_POST) ){
        $sql = "UPDATE sale_loan_contract SET ";
    
        foreach( $new_data as $key => $value){

            if(is_numeric($value)){
                $sql .= $key . " = " . $value . ", "; 
            }else{
                $sql .= $key . " = '" . $value . "', "; 
            }
        }

        $sql = trim($sql, ' ');
        $sql = trim($sql, ',');

        $sql .= " WHERE REC_NO = {$rec_no}";         ; 

        $sth =  $pdo->prepare($sql);
        $sth->execute();

        $errorInfos = $sth->errorInfo();

        if($errorInfos[0] != 0){
   
            echo json_encode(
                array("status"=>'error','errors'=>$errorInfos),JSON_UNESCAPED_UNICODE 
            );

            exit();
        }

    }

    if( !empty($g_POST) ){
        $sql = "UPDATE sale_loan_contract_guarantor SET ";
 
        foreach( $g_POST as $key => $value){
    
            if(is_numeric($value)){
                $sql .= $key . " = " . $value . ", "; 
            }else{
                $sql .= $key . " = '" . $value . "', "; 
            }
        }
    
        $sql = trim($sql, ' ');
        $sql = trim($sql, ',');
    
        $sql .= " WHERE CONTRACT_REC_NO = {$rec_no}";
      
        $sth =  $pdo->prepare($sql);
        $sth->execute();    

        $errorInfos = $sth->errorInfo();
    }

    if($errorInfos[0] != 0){
   
        echo json_encode(
            array("status"=>'error','errors'=>$errorInfos),JSON_UNESCAPED_UNICODE 
        );

    }else{
       
        $log['data'] = serialize($log['data']);
    
        $header = array_keys($log);
        $row = array_values($log);

        // $filepath = '../logs/dmt_' . date('m-Y') . '.csv';
        $filepath = '../logs/dmt.csv';
        if (!file_exists($filepath)) {
            
            $file = fopen( $filepath,'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv( $file, $header );

        }else{
            $file = fopen( $filepath,'a');
        }

        fputcsv( $file, $row );
        fclose($file);

        echo json_encode(
            array("status"=>'success','data'=>$update_data)
        );
    }

}

?>