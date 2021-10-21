<?php 
    session_start();
    include "connect_test.php";

    $search = trim($_GET['q']);
    $org_no = $_SESSION['org_no'];
    $return_arr = [];

    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);  

    $sql = "SELECT DISTINCT REC_NO,CONTRACT_CODE,c.FIRST_NAME,c.LAST_NAME,CONTRACT_DATE,LOAN_VAL,c.ID_CARD_NO,LOAN_TYPE_NO,
            LOAN_CONTRACT_STATUS_DESCR,LOAN_FEE_RECEIPT_BY_EMP_NO,c.NAME_TITLE_NO,TERM,VEHICLE_TYPE_NO,c.MOBILE_NO,
            VEHICLE_BRAND_NO,CAR_POSSESS_DATE,CAR_REGISTRATION_DATE,VEHICLE_COLOR_COMMENT,CONTRACT_STATUS_NO
            ,c.ADDR5,c.ADDR_NO,c.ADDR4_NO,c.ADDR3_NO,c.ADDR2_NO,c.ADDR_SOI,c.ADDR_ROAD,c.ADDR_BUILDING,c.ADDR_MOO,
            CAR_REGISTRATION_PROVINCE_NO,c.SALE_CONT_TYPE_NO,
            CUST_CONTACT_FIRST_NAME,CUST_CONTACT_LAST_NAME,CUST_CONTACT_PHONE_NO,CUST_SPOUSE_FIRST_NAME,
            CUST_SPOUSE_LAST_NAME,CUST_SPOUSE_AGE,CUST_OCCUPATION_NO,c.INCOME_PER_MONTH,o.ORG_NAME,
            c.ID_CARD_ISSUED_DATE,c.ID_CARD_EXPIRE_DATE,CAR_REGISTRATION_01,CAR_REGISTRATION_02,

            g.ADDR5 as g_ADDR5,g.ADDR_NO as g_ADDR_NO,g.ADDR4_NO as g_ADDR4_NO,g.ADDR3_NO as g_ADDR3_NO,
            g.ADDR2_NO as g_ADDR2_NO,g.ADDR_SOI as g_ADDR_SOI,g.ADDR_ROAD as g_ADDR_ROAD, g.ADDR_BUILDING as g_ADDR_BUILDING, 
            g.ADDR_MOO as g_ADDR_MOO,g.FIRST_NAME as g_FIRST_NAME,g.LAST_NAME as g_LAST_NAME,g.ID_CARD_NO as g_ID_CARD_NO,
            g.MOBILE_NO as g_MOBILE_NO,g.INCOME_PER_MONTH as g_INCOME_PER_MONTH,g.ID_CARD_ISSUED_DATE as g_ID_CARD_ISSUED_DATE,
            g.ID_CARD_EXPIRE_DATE as g_ID_CARD_EXPIRE_DATE,g.GRT_RELATIONSHIP as g_GRT_RELATIONSHIP,g.GRT_AGE as g_GRT_AGE,
            g.OCCUPATION_NO as g_OCCUPATION_NO,g.OCCUPATION_TEXT as g_OCCUPATION_TEXT,g.NAME_TITLE_NO as g_NAME_TITLE_NO

    FROM sale_loan_contract c
    LEFT JOIN sale_loan_contract_guarantor g ON c.REC_NO = g.CONTRACT_REC_NO 
    LEFT JOIN sale_loan_contract_status s ON c.CONTRACT_STATUS_NO = s.LOAN_CONTRACT_STATUS_NO 
    -- LEFT JOIN hr_emp h ON h.EMP_NO = c.LOAN_FEE_RECEIPT_BY_EMP_NO 
    LEFT JOIN sys_org o ON c.ORG_NO = o.ORG_NO 
    WHERE (CONTRACT_CODE LIKE '%{$search}%' OR c.ID_CARD_NO LIKE '%{$search}%' 
          OR CONCAT_ws(' ',c.FIRST_NAME,c.LAST_NAME) LIKE '%{$search}%')
    AND c.CONTRACT_STATUS_NO IN (1,5,6)";
  
    if( $org_no != 1 && !isset($_SESSION['is_admin']) ){
        if( isset($_SESSION['area_mgr']) ){

            $o_sql = "SELECT ORG_NO FROM sys_org 
                      WHERE BASE_ORG_NO = {$org_no}
                      OR BASE_ORG_NO IN (SELECT ORG_NO FROM sys_org WHERE BASE_ORG_NO = {$org_no})";

            $sth =  $pdo->prepare($o_sql);
            $sth->execute();
        
            $branch_units = $sth->fetchAll(PDO::FETCH_COLUMN,0);

            $sql .= " AND c.ORG_NO IN (". implode(',',$branch_units).")";

        }else if( isset($_SESSION['branch_mgr']) ){

            $o_sql = "SELECT ORG_NO FROM sys_org 
                      WHERE BASE_ORG_NO = {$org_no})";

            $sth =  $pdo->prepare($o_sql);
            $sth->execute();
        
            $units = $sth->fetchAll(PDO::FETCH_COLUMN,0);
         
            $sql .= " AND c.ORG_NO IN (". implode(',',$units).")";
        }else{
            $sql .= " AND c.ORG_NO = " . $org_no;
        }
    }

    $sql .= " ORDER BY CONTRACT_DATE DESC,c.ORG_NO LIMIT 50";

    $sth =  $pdo->prepare($sql);
    $sth->execute();

    $records = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach( $records as $index => $row ) { 

        $row['id'] = $row['REC_NO'];
        array_push($return_arr,$row);
    }

    echo json_encode(
        array("results"=>$return_arr),JSON_UNESCAPED_UNICODE 
    );

    exit();

?>
