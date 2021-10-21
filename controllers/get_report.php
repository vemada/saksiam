<?php
    include "connect.php";

    session_start();

    // $org_no   = $_GET['org_no'] ?? $_SESSION['org_no'] ;
    $org_no   = $_GET['org_no'] ;
    $month    = $_GET['month'];

    $start_month = date('Y-m-01 0:0:0', strtotime($month));
    $end_month   = date("Y-m-d 23:59:59", strtotime($month));

    $month_1 = strtotime($start_month);
    $month_2 = strtotime($end_month);

    // $start_month = date('Y-m-01', strtotime($_GET['month']));
    // $end_month   = date("Y-m-d", strtotime($_GET['month']));

    $results = [];

    $sql = "SELECT REC_NO FROM sale_loan_contract
            WHERE `ORG_NO` = '{$org_no}' AND CONTRACT_DATE <= '{$end_month}' AND
            (
                    (`CONTRACT_STATUS_NO` = '1' AND LOAN_CONTRACT_GRP_NO ='2' AND `CONTRACT_STATUS_DATE` < '{$start_month}' AND `CONTRACT_CUST_STATUS_NO` <> '6')
                 OR (`CONTRACT_STATUS_NO` = '1' AND LOAN_CONTRACT_GRP_NO ='2' AND `CONTRACT_STATUS_DATE` >= '{$start_month}' AND `CONTRACT_CUST_STATUS_NO` ='6')
                 OR (`CONTRACT_STATUS_NO` = '2' AND LOAN_CONTRACT_GRP_NO ='2' AND `CONTRACT_STATUS_DATE` >= '{$start_month}')
                 OR (`CONTRACT_STATUS_NO` IN ('3','5','6') AND `CONTRACT_STATUS_DATE` >= '{$start_month}')
            ) ORDER BY CONTRACT_CODE";

    $pdo = new PDO("mysql:dbname={$database};host={$host};charset=utf8",$db_username,$db_password);

    $sth =  $pdo->prepare($sql);
    $sth->execute();

    $rec_nos = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
  
    $count = 1;
    $pay_dtm=$rec_no=$code=$name=$a=$b=$c=$d=$e=$f=$g=$h=$i=$j=$k=$l=$m=$n=$o=$p=$q=0;
    $due_date=$sum_e=$sum_f=$sum_g=$sum_h=$sum_i=$sum_j=$sum_k=$sum_l=$sum_m=$sum_n=0;
    $sub_last_month=$sub_in_month=$sub_over_month=$skip=$last_chunk=$last_record=false;
    $term=$term_first=$term_last=$term_total=$r='';

    $rec_no_chucks = array_chunk($rec_nos,300);

    foreach( $rec_no_chucks as $key => $rec_no_chuck ){

        if( $key == array_key_last($rec_no_chucks) ){
            $last_chunk = true;
        }

        $rec_nos = implode(',', $rec_no_chuck);

        $sql = "SELECT p.CONTRACT_REC_NO,c.CONTRACT_CODE,NAME_TITLE_DESCR,FIRST_NAME,LAST_NAME,INSTALLMENT_PER_MONTH,
                p.INSTALLMENT_VAL_PER_MONTH,p.TERM_NO,p.FINE_VAL,c.CONTRACT_STATUS_DATE,t.INSTALLMENT_VAL as T_INSTALLMENT_VAL,
                p.TERM_SUB_NO,p.DUE_DATE,p.PAY_DTM,TERM,p.INSTALLMENT_VAL,p.PAY_INSTALLMENT_VAL,p.PAY_PRINCIPAL_VAL,
                p.PAY_INTEREST_VAL,p.PAY_LOAN_FEE_VAL,c.CONTRACT_STATUS_NO,p.STATUS_IS_PAY,p.PAY_CONTRACT_STATUS_NO,
                p.LATE_DAY_VAL,p.OVERDUE_SAME_MONTH_INTEREST_DAY_VAL,ct.SALE_CONT_TYPE_DESCR,c.CONTRACT_CUST_STATUS_NO,
                ct.SALE_CONT_TYPE_NO
                -- ,s.CT_STATUS_DESCR
                FROM sale_loan_payment p
                LEFT JOIN sale_loan_contract c ON c.REC_NO = p.CONTRACT_REC_NO
                LEFT JOIN sale_loan_payment_template t
                    ON p.CONTRACT_REC_NO = t.CONTRACT_REC_NO AND p.TERM_NO = t.TERM_NO AND p.TERM_SUB_NO = t.TERM_SUB_NO
                LEFT JOIN sys_name_title n ON c.NAME_TITLE_NO = n.NAME_TITLE_NO
                LEFT JOIN sale_condition_type ct ON c.SALE_CONT_TYPE_NO = ct.SALE_CONT_TYPE_NO
                -- LEFT JOIN sys_contract_status s ON c.CONTRACT_CUST_STATUS_NO = s.CT_STATUS_NO
                WHERE p.CONTRACT_REC_NO IN ({$rec_nos}) AND
                (
                    ( c.CONTRACT_STATUS_NO <> 3 AND p.DUE_DATE >= '{$start_month}' AND (p.PAY_DTM >= '{$start_month}' OR p.STATUS_IS_PAY = 0) )
                    OR ( c.CONTRACT_STATUS_NO = 3 AND (
                        ( p.DUE_DATE <= '{$end_month}' AND (p.PAY_DTM >= '{$start_month}' OR p.STATUS_IS_PAY = 0) )
                        OR (p.DUE_DATE > '{$end_month}' AND p.PAY_DTM is not null) ) )
                    OR ( p.DUE_DATE < '{$start_month}' AND (p.PAY_DTM >= '{$start_month}' OR p.STATUS_IS_PAY = 0) )
                )
                ORDER BY c.CONTRACT_CODE,p.TERM_NO,p.TERM_SUB_NO";

        $sth =  $pdo->prepare($sql);
        $sth->execute();

        $records = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach( $records as $index => $row ) {

            if( $last_chunk && $index == array_key_last($records) ){
                $last_record = true;
            }

            $due_before  = false;
            $due_later   = false;
            $due_month   = false;
            $just_pay    = false;
            $late_pay    = false;
            $early_pay   = false;
            $sub_over_month = false;
            $sub_in_month = false;
            $sub_last_month = false;

            $is_paid     = $row['STATUS_IS_PAY'];
            $status_no   = $row['CONTRACT_STATUS_NO'];
            $pay_status_no = $row['PAY_CONTRACT_STATUS_NO'];

            if($rec_no == $row['CONTRACT_REC_NO']){

                $previous_month = date("m", $due_date);
                $due_date    = strtotime($row['DUE_DATE']);
                $current_month  = date("m", $due_date);

                if( $row['TERM_NO'] == $row_term && $row['TERM_SUB_NO'] > 0 && ($previous_month == $current_month) ){
                    $sub_in_month = true;
                }else {
                    $sub_over_month = true;
                }

            }else{
                $due_date    = strtotime($row['DUE_DATE']);
            }

            if( $due_date >= $month_1 && $due_date <= $month_2){
                $due_month = true;
            }else if( $due_date > $month_2 ){
                $due_later = true;
            } else {
                $due_before = true;
            }

            if($rec_no == $row['CONTRACT_REC_NO']){

                if( $row['TERM_NO'] == $row_term && $row['TERM_SUB_NO'] > 0 && ( $pay_dtm < $month_1 ) && $due_month ){
                    $sub_last_month = true;
                } 
            }

            $pay_dtm = strtotime($row['PAY_DTM']);


            if(  $pay_dtm != null ){
                if( $pay_dtm > $month_2 ){
                    $late_pay = true;
                } else if( $pay_dtm < $month_1 ){
                    $early_pay  = true;
                } else {
                    $just_pay  = true;
                }
            }

            $installment_val  = ($pay_status_no == 3 || $pay_status_no == 2) ? (float)$row['T_INSTALLMENT_VAL'] : (float)$row['INSTALLMENT_VAL'];
            $pay_installment_val = (float)$row['PAY_INSTALLMENT_VAL'];
            $row_term = $row['TERM_NO'];
                // $row['T_INSTALLMENT_VAL'] != null ? (float)$row['T_INSTALLMENT_VAL'] : (float)$row['INSTALLMENT_VAL'];
                // $installment_val   = $row['T_INSTALLMENT_VAL'] != null ? (float)$row['T_INSTALLMENT_VAL'] : (float)$row['INSTALLMENT_VAL'];
                // $t_installment_val = (float)$row['T_INSTALLMENT_VAL'];

            if($rec_no == '15629169102160275'){
                // echo $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'] . '.' . $month_1 . '.' . $pay_dtm . '.' . $month_2 . '.' . $just_pay ;
                echo $term_first . $term_last . $term_total;
            }
            
            if($rec_no != $row['CONTRACT_REC_NO']){
                $skip = false;
                if( $rec_no != 0 ){
                    //sum previous
                    if( $term_last == '' ){
                        $b = $term_first . $term_total;
                    }else{
                        $b = $term_first . $term_last . $term_total;
                    }

                    //เป้าหมาย
                    $e = $c+$d;

                    if( $g !== null ){
                        $g = round( $e-$f ,2) > 0 ? round($e-$f ,2) : 0 ;
                    }

                    $sum_g += $g;
                    $sum_h += $h;
                    $sum_e += $e;
                    $sum_f += $f;
                    $sum_i += $i;
                    $sum_j += $j;
                    $sum_k += $k;
                    $sum_l += $l;
                    $sum_m += $m;
                    $sum_n += $n;

                    $a = $a == 0 ? null : number_format($a, 2, '.', ',');
                    $c = $c == 0 ? null : number_format($c, 2, '.', ',');
                    $d = $d == 0 ? null : number_format($d, 2, '.', ',');
                    $e = $e == 0 ? null : number_format($e, 2, '.', ',');
                    $f = $f == 0 ? null : number_format($f, 2, '.', ',');
                    $g = $g == 0 ? null : number_format($g, 2, '.', ',');
                    $h = $h == 0 ? null : number_format($h, 2, '.', ',');
                    $i = $i == 0 ? null : number_format($i, 2, '.', ',');
                    $j = $j == 0 ? null : number_format($j, 2, '.', ',');
                    $k = $k == 0 ? null : number_format($k, 2, '.', ',');
                    $l = $l == 0 ? null : number_format($l, 2, '.', ',');
                    $m = $m == 0 ? null : number_format($m, 2, '.', ',');
                    $n = $n == 0 ? null : number_format($n, 2, '.', ',');

                    $result = array('no' => $no,'code' => $code ,'name'=>$name,'a'=>$a,'b'=>$b ,'c'=>$c,'d'=>$d,
                    'e'=>$e ,'f'=> $f,'g'=>$g,'h'=>$h,'i'=>$i,'j'=>$j,'k'=>$k,'l'=>$l,'m'=>$m,'n'=>$n ,'o'=> $o, 'p'=> $p,'q'=>$q,'r'=>$r );

                    array_push($results,$result);

                    $c=$d=$e=$f=$g=$h=$i=$j=$k=$l=$m=$n=0;
                    $term_first=$term_last=$term_total=$b=$o=$p=$q=$r='';
                }

                //new contract
                $rec_no = $row['CONTRACT_REC_NO'];
                $no     = $count;
                // $code   = $rec_no;
                $code   = $row['CONTRACT_CODE'];
                $name   = $row['NAME_TITLE_DESCR'] . ' ' . $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                $a      = (float)$row['INSTALLMENT_VAL_PER_MONTH'];

                $term = $row['TERM'] == 4 ? 1 : $row['TERM'];

                $o      = $row['SALE_CONT_TYPE_DESCR'];
                $p      = $row['CONTRACT_CUST_STATUS_NO'] == 2 ? 'NPL' : 'ปกติ';
                // $p = $row['CT_STATUS_DESCR'];

                switch ($status_no) {
                    case '2':
                        $q = 'ปิดบัญชี';
                      break;
                    case '3':
                        $q = 'ปิดสด';
                      break;
                    case '5':
                        $q = 'รถยึด';
                      break;
                    case '6':
                        $q = 'ขายรถยึด';
                      break;
                    case '7':
                        $q = 'ปิดบัญชี-ลูกค้าประนอมหนี้';
                      break;
                    case '8':
                        $q = 'ปิดบัญชี-ลูกค้ารีไฟแนนช์';
                      break;
                    case '9':
                        $q = 'ยกเลิกสัญญา';
                      break;
                    case '10':
                        $q = 'จำหน่ายรถยึดเป็นรถบริษัท';
                      break;
                    case '11':
                        $q = 'จำหน่ายรถยึดเป็นสูญหาย';
                      break;
                    case '12':
                        $q = 'รถยึดรอการไถ่ถอน';
                      break;
                    default:
                        $q = "ปกติ";
                }
    
                $cont_types = array(
                                'M' => [5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 19, 20, 21, 22, 23, 24, 25, 26, 27, 29, 30, 36, 37, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 78, 90, 92, 94, 96, 98, 100, 102, 104, 106, 108, 110, 112, 114, 116, 125, 127, 129, 130, 132, 134, 136, 137, 139, 141, 143, 145, 147, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 197, 198, 205, 206, 213, 214, 215, 216, 229, 230],
                                'S' => [76,79,117,118,119,121,123,159,161,176,178,194,196,207,208,217,218,219,220,231,232],
                                'I' => [77, 160, 177, 195, 209, 210, 221, 222, 223, 224, 233, 234],
                                'P' => [63, 149, 164, 180, 211, 212, 225, 226, 227, 228, 235, 236],
                                'N' => [57, 58, 59, 60, 61, 62, 151, 153, 155, 157, 162, 163, 179, 199, 200, 201, 202, 203, 204]
                             );

                foreach( $cont_types as $key => $type){
                    if ( in_array( (int)$row['SALE_CONT_TYPE_NO'] , $type) ){
                        $r = $key;
                    } 
                }

                // if( $r == 0 ){
                //     if( $term == 1){
                //         $r = 'S';
                //     }else{
                //         $r = 'M';
                //     }
                // }
          
                if( $due_later && ( $late_pay || $is_paid == 0 ) ){
                    $term_first = '1.0';
                    $term_last  = '';
                    $term_total = '/'. $term;
                    $skip = true;
                }else{

                    // $term_first = $row['TERM_NO'] . '.' .  $row['TERM_SUB_NO'];
                    // $term_last  = '';

                    // if( $pay_status_no == 2 && $row['TERM_NO'] == 1 && $row['TERM_SUB_NO'] == 0 ){
                    //     $term_total = '/1';
                    // }else {
                    //     $term_total = '/'. $term;
                    // }
                    
                    if( $early_pay ){
                        // if($rec_no == '15629169102160275'){
                        //     // echo $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'] . '.' . $month_1 . '.' . $pay_dtm . '.' . $month_2 . '.' . $just_pay ;
                        //     echo $pay_dtm . '<' . $month_1 ;
                        // }
                        //
                    } else {

                        if( $pay_status_no == 2 && $row['TERM_NO'] == 1 && $row['TERM_SUB_NO'] == 0 ){
                            $term_total = '/1';
                        }else {
                            $term_total = '/'. $term;
                        }

                        $term_first = $row['TERM_NO'] . '.' .  $row['TERM_SUB_NO'];
                        //จำนวนเงิน
                        if( $due_month ){
                            $c = $installment_val;

                        } else if( $due_before ){

                            //ยอดค้าง
                            $d = $installment_val;

                        }

                        //ปิดสด
                        if( $pay_status_no == 3 ){

                            //ปิดสดเดือนนี้
                            if( $just_pay ){
                                //ปิดสด
                                $j = $pay_installment_val;
                                // $f = null;
                                $g = null;
                                $h = null;
                                $skip = true;
                            }

                        } else{

                            //ยอดเก็บ
                            if( $just_pay ){

                                if( $due_later ){
                                    $h = $pay_installment_val;
                                } else {
                                    if(  $due_month && ( $pay_installment_val > $installment_val ) && $pay_status_no != 2 ){
                                        $f = $installment_val;
                                        $h = ($pay_installment_val - $installment_val);
                                    } else {
                                        $f = $pay_installment_val;
                                    }
                                }

                                if( $pay_status_no == 2 ){
                                    $h = null;
                                    $g = null;
                                }
                            }


                        }

                        if( $status_no == 5 || $status_no == 6 ){
                            //รถยึด
                            $k = $c+$d;
                        }

                        if( $just_pay ){

                            $i = (float)$row['FINE_VAL'];
                            $l = (float)$row['PAY_PRINCIPAL_VAL'];
                            $m = (float)$row['PAY_INTEREST_VAL'];
                            $n = (float)$row['PAY_LOAN_FEE_VAL'];

                              if($rec_no == '15629169102160275'){
                                    // echo $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'] . '.' . $month_1 . '.' . $pay_dtm . '.' . $month_2 . '.' . $just_pay ;
                                    echo $f . '-' . $h ;
                              }
                        }

                    }

                    // if(  $row['TERM_SUB_NO'] > 0 && ( $is_paid == 0 || $late_pay ) ){
                    //     $h = null;
                    //     $skip = true;
                    // }
                }

                if( $last_record ){

                    if( $term_last == '' ){
                        $b = $term_first . $term_total;
                    }else{
                        $b = $term_first . $term_last . $term_total;
                    }

                    //เป้าหมาย
                    $e = $c+$d;

                    if( $g !== null ){
                        $g = round( $e-$f ,2) > 0 ? round($e-$f ,2) : 0 ;
                    }

                    $sum_e += $e;
                    $sum_f += $f;
                    $sum_g += $g;
                    $sum_h += $h;
                    $sum_i += $i;
                    $sum_j += $j;
                    $sum_k += $k;
                    $sum_l += $l;
                    $sum_m += $m;
                    $sum_n += $n;

                    $a = $a == 0 ? null : number_format($a, 2, '.', ',');
                    $c = $c == 0 ? null : number_format($c, 2, '.', ',');
                    $d = $d == 0 ? null : number_format($d, 2, '.', ',');
                    $e = $e == 0 ? null : number_format($e, 2, '.', ',');
                    $f = $f == 0 ? null : number_format($f, 2, '.', ',');
                    $g = $g == 0 ? null : number_format($g, 2, '.', ',');
                    $h = $h == 0 ? null : number_format($h, 2, '.', ',');
                    $i = $i == 0 ? null : number_format($i, 2, '.', ',');
                    $j = $j == 0 ? null : number_format($j, 2, '.', ',');
                    $k = $k == 0 ? null : number_format($k, 2, '.', ',');
                    $l = $l == 0 ? null : number_format($l, 2, '.', ',');
                    $m = $m == 0 ? null : number_format($m, 2, '.', ',');
                    $n = $n == 0 ? null : number_format($n, 2, '.', ',');

                    $result = array('no' => $no,'code' => $code ,'name'=>$name,'a'=>$a,'b'=>$b ,'c'=>$c,'d'=>$d,
                    'e'=>$e ,'f'=> $f,'g'=>$g,'h'=>$h,'i'=>$i,'j'=>$j,'k'=>$k,'l'=>$l,'m'=>$m,'n'=>$n ,'o'=> $o,'p'=> $p,'q'=>$q,'r'=>$r );

                    array_push($results,$result);

                }else{
                    $count++;
                }

            }else{
                
                // if( $due_before ){
                //     $term_last = '-'. $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'];
                // } else {
                //     if ($due_month ) {
                //         if( $sub_in_month && ( $is_paid == 0 || $late_pay ) ){
                //             $h = null;
                //             $skip = true;
                //         } else{
                //             if( $row['TERM_SUB_NO']==0 || $sub_last_month ){
                //                 $term_last = '-'. $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'];
                //             }
                //         }
                //     }
                // }

                // if( ( $due_later && ( $late_pay || $is_paid == 0 ) ) || ( $due_month && $early_pay ) ){
                if(  $due_later && ( $late_pay || $is_paid == 0 ) ){
                    $skip = true;
                } else {

                    if($early_pay){

                        // if($rec_no == '15629169102160275'){
                        //     // echo $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'] . '.' . $month_1 . '.' . $pay_dtm . '.' . $month_2 . '.' . $just_pay ;
                        //     echo $pay_dtm . '<' . $month_1 ;
                        // }

                    }else{

                        if( $due_before ){
                      
                            $term_last = '-'. $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'];
                       
                        } else {
                            if ($due_month ) {
                                if( $sub_in_month && ( $is_paid == 0 || $late_pay ) ){
                                    $h = null;
                                    $skip = true;
                                } else{
                                    if( $row['TERM_SUB_NO']==0 || $sub_last_month ){
                                        $term_last = '-'. $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'];
                                    }
                                }
                            }
                        }
        
                        if( $row['TERM_SUB_NO']==0 ){
                            //จำนวนเงิน
                           if( $due_month ){
                               $c += $installment_val;
                           } else if ( $due_before ){
                            //ยอดค้าง
                               $d += $installment_val;
                           }

                        }else {

                            //จำนวนเงิน
                           if( $due_month ){

                                if( $late_pay || $is_paid == 0 || $sub_in_month ){
                                    //
                                } else {

                                    if( $c == 0){
                                        $c = $installment_val;
                                    }else{
                                        $c += $installment_val-(float)$row['INSTALLMENT_VAL_PER_MONTH'];
                                    }
                                }

                           } else {

                                 if( $due_before && !$sub_in_month  ){
                                    if( $d == 0  ){
                                        $d = $installment_val;
                                    } else {
                                        //ยอดค้าง
                                        $d += $installment_val-(float)$row['INSTALLMENT_VAL_PER_MONTH'];
                                    }
                                 }
                           }

                        }
                        // if($rec_no == '15629169102160275'){
                        //     // echo $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'] . '.' . $month_1 . '.' . $pay_dtm . '.' . $month_2 . '.' . $just_pay ;
                        //     echo $just_pay;
                        // }
                        if( !$skip ){
                            if( $pay_status_no == 3 ){
                                if( $just_pay ){

                                    //ปิดสด
                                    $j = $f + $h + $pay_installment_val;
                                    $f = null;
                                    $g = null;
                                    $h = null;
                                    $skip = true;
                                }

                            } else {

                                if( $just_pay ){

                                    if( $due_later ){
                                        $h += $pay_installment_val;
                                    } else {

                                        if( $due_month && ( $pay_installment_val > $installment_val ) && $pay_status_no != 2 ){
                                            $f += $installment_val;
                                            $h += ($pay_installment_val - $installment_val);
                                        } else {
                                            $f += $pay_installment_val;
                                        }
                                    }

                                    if( $pay_status_no == 2 ){
                                        $h = null;
                                        $g = null;
                                    }

                                }

                            }

                            if( $status_no == 5 || $status_no == 6 ){
                                $k = $c+$d;
                            }

                            // if($rec_no == '15629169102160275'){
                            //     // echo $row['TERM_NO'] . '.' . $row['TERM_SUB_NO'] . '.' . $month_1 . '.' . $pay_dtm . '.' . $month_2 . '.' . $just_pay ;
                            //     echo $just_pay;
                            // }

                            if( $just_pay ){
                             
                                $i += (float)$row['FINE_VAL'];
                                $l += (float)$row['PAY_PRINCIPAL_VAL'];
                                $m += (float)$row['PAY_INTEREST_VAL'];
                                $n += (float)$row['PAY_LOAN_FEE_VAL'];
                            }
                        }
                    }

                }

                if( $last_record ){

                    if( $term_last == '' ){
                        $b = $term_first . $term_total;
                    }else{
                        $b = $term_first . $term_last . $term_total;
                    }

                    //เป้าหมาย
                    $e = $c+$d;

                    if( $g !== null ){
                        $g = round( $e-$f ,2) > 0 ? round($e-$f ,2) : 0 ;
                    }

                    $sum_e += $e;
                    $sum_f += $f;
                    $sum_g += $g;
                    $sum_h += $h;
                    $sum_i += $i;
                    $sum_j += $j;
                    $sum_k += $k;
                    $sum_l += $l;
                    $sum_m += $m;
                    $sum_n += $n;

                    $a = $a == 0 ? null : number_format($a, 2, '.', ',');
                    $c = $c == 0 ? null : number_format($c, 2, '.', ',');
                    $d = $d == 0 ? null : number_format($d, 2, '.', ',');
                    $e = $e == 0 ? null : number_format($e, 2, '.', ',');
                    $f = $f == 0 ? null : number_format($f, 2, '.', ',');
                    $g = $g == 0 ? null : number_format($g, 2, '.', ',');
                    $h = $h == 0 ? null : number_format($h, 2, '.', ',');
                    $i = $i == 0 ? null : number_format($i, 2, '.', ',');
                    $j = $j == 0 ? null : number_format($j, 2, '.', ',');
                    $k = $k == 0 ? null : number_format($k, 2, '.', ',');
                    $l = $l == 0 ? null : number_format($l, 2, '.', ',');
                    $m = $m == 0 ? null : number_format($m, 2, '.', ',');
                    $n = $n == 0 ? null : number_format($n, 2, '.', ',');

                    $result = array('no' => $no,'code' => $code ,'name'=>$name,'a'=>$a,'b'=>$b ,'c'=>$c,'d'=>$d,
                    'e'=>$e ,'f'=> $f,'g'=>$g,'h'=>$h,'i'=>$i,'j'=>$j,'k'=>$k,'l'=>$l,'m'=>$m,'n'=>$n ,'o'=> $o,'p'=>$p,'q'=>$q,'r'=>$r);

                    array_push($results,$result);

                }

            }

        }

    }

    $result = array('no'=>9999,'code' => '' ,'name'=>'','a'=>'','b'=>'' ,'c'=>'','d'=>'',
        'e'=>number_format($sum_e, 2, '.', ',') ,'f'=>number_format($sum_f,2, '.', ','),
        'g'=>number_format($sum_g,2, '.', ','),'h'=>number_format($sum_h,2, '.', ','),
        'i'=>number_format($sum_i,2, '.', ','),'j'=>number_format($sum_j,2, '.', ','),
        'k'=>number_format($sum_k,2, '.', ','),'l'=>number_format($sum_l,2, '.', ','),
        'm'=>number_format($sum_m,2, '.', ','),'n'=>number_format($sum_n,2, '.', ','),
        'o'=>'','p'=>'','q'=>'','r'=>'');

    array_push($results,$result);

    $json = json_encode(
        array("data"=>$results),JSON_UNESCAPED_UNICODE
    );

    if( $month_2 < strtotime(date('Y-m-01 0:0:0')) ){

        $filename = '../reports/rtp-040/'. $org_no . '_' . $month . '.json';

        if(!file_exists( $filename)){
            $file = fopen( $filename ,'w');
            fwrite($file, $json);
            fclose($file);
        }
    }

    if ($json)
        echo $json;
    else
        echo json_last_error_msg();

?>