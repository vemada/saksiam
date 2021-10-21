<?php 
    include "connect_test.php";
    session_start();

    $table = $_GET['table_name'];
    $id    = $_GET['field_id'];
    $text  = $_GET['field_text'];
    $desc  = $_GET['field_desc'] ?? null;
    $condition = $_GET['condition'] ?? null;

    $results = [];

    if( isset($desc) ){
        $sql = "SELECT {$id},{$text},{$desc} FROM {$table}";
    } else {
        $sql = "SELECT {$id},{$text} FROM {$table}";
    }

    if( isset($condition) ){
        $sql .= " WHERE " . $condition;
    }

    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

    $sth =  $pdo->prepare($sql);
    $sth->execute();

    $records = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach( $records as $index => $row ) { 

        $result['id']   = $row[$id];
        $result['text'] = $row[$text];

        if( isset($desc) ){
            $result['text'] .= ' (' . $row[$desc] . ')';
        }
       
        array_push($results,$result);
    }
    
    // mysqli_close($dbhandle);

    echo json_encode(
        array("results"=>$results,JSON_UNESCAPED_UNICODE )
    );

    exit();

?>
