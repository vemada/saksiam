<?php

    $rows   = array_map('str_getcsv', file('../logs/dmt.csv'));
    array_shift($rows);
    $logs = array();
    $i=1;
    $header = ["contract_code","username","org_name","type","data","dtm"];

    foreach($rows as $k => $row) {

        $log = array_combine($header, $row);
        $log['no'] = $i;

        $data = unserialize($log['data']);
        $log['data']=[];

        $c=1;

        foreach( $data as $k => $v){

            $old_val = $v['old_value'] == null || $v['old_value'] == "" ? "null" : $v['old_value'];
            $data = $k . ' : ' .  $old_val . ' -> ' . $v['new_value'] . ' ';
            array_push($log['data'],  $data);
            $c++;
        }

        $i++;

        array_push($logs,$log);
    }  

    $json = json_encode(
        array("data"=>$logs),JSON_UNESCAPED_UNICODE
    );

    if ($json)
        echo $json;
    else
        echo json_last_error_msg();


?>
