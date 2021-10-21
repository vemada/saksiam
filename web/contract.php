<?php
session_start();

if( !isset( $_SESSION['username']) ){
  header("location: LMISlogin.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>แก้ไขสัญญาลูกค้า</title>
      <?php include('ic/head.php'); ?>
    <style>
    /* Style the tab */
    .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
    background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
    background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
    }
    </style>

  </head>
 
  <body>
		
  <div class="wrapper d-flex align-items-stretch">
    <?php
        include('ic/sidebar.php');
    ?>

        <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">

      <?php include('ic/navbar.php');?>

      <?php include('ic/messages.php'); ?>

        <div id="contractForm">
          <!-- <input name="CONTRACT_CODE" type="hidden"/> -->
          <p style="font-size: 25px; color: black;"  >แก้ไขสัญญาลูกค้า</p> 
          <div class="form-group row" style="margin-top: 20px;">
              <label for="num" class="col-12 col-form-label" style="font-size: larger;">ค้นหาเลขที่สัญญา,ชื่อ-นามสกุล,เลขบัตรประชาชน</label>
              <div class="col-12">
                <select id="search_contract" name="search_contract" class="form-control w-100" placeholder="ค้นหาเลขที่สัญญา/ชื่อ-นามสกุล" >
                  <!-- <option value="">ค้นหาเลขที่สัญญา/ชื่อ-นามสกุล</option>  -->
                </select>
              </div>               
          </div>

          <div class="tab">
              <button type="button" class="tablinks active" onclick="openCity(event, 'cust')">ข้อมูลส่วนตัวลูกค้า</button>
              <button type="button" class="tablinks" onclick="openCity(event, 'contract')">ข้อมูลสัญญา</button>
              <button type="button" class="tablinks" onclick="openCity(event, 'car')">ข้อมูลรถ</button>
              <button type="button" class="tablinks" onclick="openCity(event, 'guarantor')">ข้อมูลผู้ค้ำประกัน</button>
          </div>

          <div id="cust" class="tabcontent" style="display: block;">
              <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="NAME_TITLE_NO">คำนำหน้า</label>
                    <select id="NAME_TITLE_NO" name="NAME_TITLE_NO" class="form-control">
                        <option value="">กรุณาระบุ</option>
                    </select>
                </div> 
                <div class="form-group col-md-5">
                    <label for="FIRST_NAME">ชื่อจริง</label>
                    <input id="FIRST_NAME" type="text" class="form-control" name="FIRST_NAME" placeholder="">
                </div>
                <div class="form-group col-md-5">
                    <label for="LAST_NAME">นามสกุล</label>
                    <input id="LAST_NAME" type="text" class="form-control" name="LAST_NAME" placeholder="">
                </div>
              </div>

              <div class="form-group ">
                    <label for="MOBILE_NO">เบอร์โทรศัพท์</label>
                    <input id="MOBILE_NO" type="text" class="form-control" name="MOBILE_NO">
              </div>

              <div class="form-row">
                  <div class="form-group col-md-4">
                      <label for="CUST_OCCUPATION_NO">อาชีพ</label>
                      <select id="CUST_OCCUPATION_NO" name="CUST_OCCUPATION_NO" class="form-control">
                          <option value="">กรุณาระบุ</option>
                          <option value="1">เกษตรกร</option>
                          <option value="2">ข้าราชการ</option>
                          <option value="3">รับจ้าง</option>
                          <option value="4">ค้าขาย</option>
                          <option value="5">ธุรกิจส่วนตัว</option>
                          <option value="6">อื่นๆ</option>
                          <option value="7">ลูกจ้างประจำ</option>
                          <option value="8">ลูกจ้างชั่วคราว</option>
                          <option value="9">ข้าราชการบำนาญ</option>
                      </select>
                  </div>

                <div class="form-group col-md-4">
                    <label for="CUST_OCCUPATION_TEXT">ลักษณะงาน</label>
                    <input id="CUST_OCCUPATION_TEXT" type="text" class="form-control" name="CUST_OCCUPATION_TEXT" placeholder="">
                </div>
                <div class="form-group col-md-4">
                    <label for="INCOME_PER_MONTH">รายได้ต่อเดือน</label>
                    <input id="INCOME_PER_MONTH" type="text" class="form-control" name= "INCOME_PER_MONTH" placeholder="">
                </div>
              </div> 

              <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="ID_CARD_NO">เลขบัตรประชาชน</label>
                    <input id="ID_CARD_NO" type="text" class="form-control" name="ID_CARD_NO" >
                </div>
                
                <div class="form-group col-md-4">
                    <label for="ID_CARD_ISSUED_DATE">วันออกบัตร</label>
                    <input id="ID_CARD_ISSUED_DATE" type="date" class="form-control" name="ID_CARD_ISSUED_DATE" >
                </div>
                <div class="form-group col-md-4">
                    <label for="ID_CARD_EXPIRE_DATE">บัตรหมดอายุ</label>
                    <input id="ID_CARD_EXPIRE_DATE" type="date" class="form-control" name="ID_CARD_EXPIRE_DATE" >
                </div>
              </div>

              <br/>

              <h1 style="font-size: 20px;">บุคคลที่สามรถติดต่อได้</h1>
              <br/>

              <div class="form-row"> 
                <div class="form-group col-md-2">
                        <label for="name_title">คำนำหน้า</label>
                        <input type="text" class="form-control" placeholder="คุณ" disabled>
                    </div> 
                    <div class="form-group col-md-3">
                        <label for="CUST_CONTACT_FIRST_NAME">ชื่อจริง</label>
                        <input id="CUST_CONTACT_FIRST_NAME" type="text" class="form-control" name="CUST_CONTACT_FIRST_NAME" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="CUST_CONTACT_LAST_NAME">นามสกุล</label>
                        <input id="CUST_CONTACT_LAST_NAME" type="text" class="form-control" name="CUST_CONTACT_LAST_NAME" placeholder="">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="CUST_CONTACT_PHONE_NO">เบอร์โทรศัพท์</label>
                      <input id="CUST_CONTACT_PHONE_NO" type="text" class="form-control" name="CUST_CONTACT_PHONE_NO">
                </div>
              </div>

              <br/>
              <h1 style="font-size: 20px;">คู่สมรส</h1>
              <br/>

              <div class="form-row">  
                  <div class="form-group col-md-2">
                      <label for="CUST_SPOUSE_NAME_TITLE_NO">คำนำหน้า</label>
                      <select id="CUST_SPOUSE_NAME_TITLE_NO" type="select" class="form-control" name="CUST_SPOUSE_NAME_TITLE_NO">
                        <option value="">กรุณาระบุ</option>
                      </select>
                  </div> 
                  <div class="form-group col-md-3">
                      <label for="CUST_SPOUSE_LAST_NAME">ชื่อจริง</label>
                      <input id="CUST_SPOUSE_FIRST_NAME" type="text" class="form-control" name="CUST_SPOUSE_FIRST_NAME" placeholder="">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="CUST_SPOUSE_LAST_NAME">นามสกุล</label>
                      <input id="CUST_SPOUSE_LAST_NAME" type="text" class="form-control" name="CUST_SPOUSE_LAST_NAME" placeholder="">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="CUST_SPOUSE_AGE">อายุ</label>
                    <input type="CUST_SPOUSE_AGE" class="form-control" name="CUST_SPOUSE_AGE">
                  </div>
              </div>

              <br/>
              <h1 style="font-size: 20px;">ที่อยู่ปัจจุบัน</h1>
              <br/>
              <div class="form-row">

                  <div class="form-group col-md-6">
                      <label for="ADDR_NO">บ้านเลขที่</label>
                      <input id="ADDR_NO" type="text" class="form-control"  name="ADDR_NO" placeholder=""> 
                  </div>

                  <div class="form-group col-md-6">
                      <label for="ADDR_MOO">หมู่</label>
                      <input id="ADDR_MOO" type="number" class="form-control" name="ADDR_MOO" placeholder="">
                  </div>

                  <div class="form-group col-md-6">
                      <label for="ADDR_BUILDING">อาคาร</label>
                      <input id="ADDR_BUILDING" type="text" class="form-control" name="ADDR_BUILDING" placeholder="">
                  </div>

                  <div class="form-group col-md-6">
                      <label for="ADDR_SOI">ซอย</label>
                      <input id="ADDR_SOI" type="text" class="form-control" name="ADDR_SOI" placeholder="">
                  </div>

                  <div class="form-group col-md-6">
                      <label for="ADDR_ROAD">ถนน</label>
                      <input id="ADDR_ROAD" type="text" class="form-control" name="ADDR_ROAD" placeholder="">
                  </div>

                        <!-- จังหวัด -->
                  <div class="form-group col-md-6">
                    <label for="ADDR4_NO">จังหวัด</label>
                    <!-- <input type="text" class="form-control" id="provine"  placeholder="">  -->
                    <select id="ADDR4_NO" name="ADDR4_NO" class="form-control">
                        <option value="">เลือกจังหวัด</option> 
                    </select>
                  </div>
              </div>

              <!-- อำเภอ ตำบล เลขไปร -->
              <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="ADDR3_NO">อำเภอ</label>
                    <!-- <input type="text" class="form-control" id="aumper" placeholder=""> -->
                    <select id="ADDR3_NO" name="ADDR3_NO" class="form-control" disabled>
                      <option value="">เลือกอำเภอ</option>
                    </select> 
                  </div>

                  <div class="form-group col-md-4">
                    <label for="ADDR2_NO">ตำบล</label>
                    <!-- <input type="text" class="form-control" id="district" placeholder=""> -->
                    <select id ="ADDR2_NO" name="ADDR2_NO" class="form-control" disabled>
                    <option value="">เลือกตำบล</option> 
                    </select>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="ADDR5">รหัสไปรษณีย์</label>
                    <input id="ADDR5" name="ADDR5" class="form-control"  placeholder="">  
                  </div>
              </div>
          </div>
 
          <div id="contract" class="tabcontent">
              </br>
              <div class="form-row">
                  <div class="form-group col-md-3 ">
                      <label for="code">เลขที่สัญญา</label>
                      <input type="text" class="form-control" name="CONTRACT_CODE" placeholder="" disabled>
                  </div>

                  <div class="form-group col-md-4">
                      <label for="CONTRACT_STATUS_NO">สถานะสัญญา</label>
                      <select id ="CONTRACT_STATUS_NO" name="CONTRACT_STATUS_NO" class="form-control">
                        <option value="">กรุณาระบุสถานะสัญญา</option>
                        <option value="1">ปกติ</option>
                        <option value="2">NPL</option>
                        <option value="3">ยึดรถ</option>
                        <option value="4">ขายรถยึด</option>
                        <option value="5">ปิดสด</option>
                        <option value="6">ปิดบัญชี</option>
                        <option value="7">ประนอมหนี้</option>
                      </select>
                  </div>
                  <div class="form-group col-md-5">
                      <label for="LOAN_TYPE">ประเภทการขาย</label>
                      <select id-="LOAN_TYPE" name="LOAN_TYPE_NO" class="form-control">
                        <option value="">ประเภทการขาย</option>
                        <option value="1">สินเชื่อบุคคลเดี่ยว</option>
                        <option value="2">สินเชื่อมีหลักทรัพย์</option>
                        <option value="4">สินเชื่อนาโนไฟแนนซ์</option>
                        <option value="5">สินเชื่อนาโนไฟแนนซ์[มีหลักทรัพย์]</option>
                        <option value="6">สินเชื่อบุคคล[มีหลักทรัพย์]</option>
                        <option value="7">สินเชื่อที่มีทะเบียนรถเป็นหลักประกัน</option>
                      </select>
                  </div>
              </div>

              <div class="form-group ">
                  <label for="contract_date">วันที่ทำสัญญา</label>
                  <input type="date" class="form-control" name="CONTRACT_DATE" placeholder="" disabled>
              </div>
              <div class="form-group">
                  <label for="SALE_CONT_TYPE_NO">เงื่อนไขการขาย</label>
                  <select class="form-control" id="SALE_CONT_TYPE_NO" name="SALE_CONT_TYPE_NO">
                    <option value="">เงื่อนไขการขาย</option>
                  </select>
              </div>
 
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="LOAN_VAL">วงเงินกู้</label>
                      <input type="number" class="form-control" id="LOAN_VAL" name="LOAN_VAL" disabled>
                  </div>
                  <div class="form-group col-md-6">
                      <label for="TERM">จำนวนงวด</label>
                      <input type="number" class="form-control" id="TERM" name="TERM" disabled>
                  </div>
              </div>

              <div class="form-group">
                  <label for="condition">ผู้รับเงิน</label>   
                  </br>   
                  <select id="search_emp" name="LOAN_FEE_RECEIPT_BY_EMP_NO" class="form-control">
                      <option value="">ค้นหาพนักงาน</option> 
                  </select>
              </div>
          </div>

          <div id="car" class="tabcontent">
              </br>
              <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="VEHICLE_TYPE_NO">ประเภทรถ</label>
                    <select id="VEHICLE_TYPE_NO" name="VEHICLE_TYPE_NO" class="form-control">
                        <option value="">กรุณาระบุประเภทรถ</option> 
                        <option value="1">รถกระบะ</option>
                        <option value="3">รถเก๋ง</option>
                        <option value="4">รถจักรยานยนต์  </option>
                        <option value="10">รถใช้เพื่อการเกษตร</option>
                      </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="VEHICLE_BRAND_NO">ยี่ห้อรถ</label>
                    <select id="VEHICLE_BRAND_NO" name="VEHICLE_BRAND_NO" class="form-control">
                        <option value="">กรุณาระบุยี่ห้อรถ</option> 
                        <option value="1">FORD</option>
                        <option value="2">ISUZU</option>
                        <option value="3">MAZDA  </option>
                        <option value="4">MITSUBISHI</option>
                        <option value="5">NISSAN</option>
                        <option value="6">TOYOTA</option>
                        <option value="15">CHEVROLET</option>
                        <option value="16">DAIHATSU</option>
                        <option value="17">DAEWOO</option>
                        <option value="19">HONDA</option>
                        <option value="21">JRD</option>
                        <option value="22">KAWASAKI</option>
                        <option value="13">SUZUKI  </option>
                        <option value="27">TIGER</option>
                        <option value="29">YAMAHA</option>
                        <option value="39">BMW</option>
                        <option value="40">DATSUN</option>
                        <option value="41">FIAT</option>
                        <option value="42">HINO</option>
                        <option value="43">JEEP</option>
                        <option value="44">KUBOTA </option>
                        <option value="45">OPEL</option>
                        <option value="46">PEUGEOT  </option>
                        <option value="47">SUN</option>
                        <option value="48">VOLKSWAGEN</option>
                        <option value="49">VOLVO</option>
                        <option value="50">YANMAR</option>
                        <option value="52">HYUNDAI</option>
                        <option value="53">KIA</option>
                        <option value="54">BENZ</option>
                        <option value="55">CITROEN</option>
                        <option value="56">HOLDEN</option>
                        <option value="57">JOHN DEERE  </option>
                        <option value="58">SUBARU</option>
                        <option value="59">MASSEY FERGUSON</option>
                        <option value="60">TATA</option>
                        <option value="61">RENAULT</option>
                        <option value="62">VESPA</option>
                        <option value="63">THAIRUNG</option>
                        <option value="64">Austin</option>
                        <option value="65">M BIKE</option>
                        <option value="66">HARDE</option>
                        <option value="67">GMC  </option>
                        <option value="68">CAJIVA</option>
                        <option value="69">VIKYNO</option>
                        <option value="70">CHERY</option>
                        <option value="71">VIVACE</option>
                        <option value="73">LIFAN</option>
                        <option value="74">RYUKA</option>
                        <option value="78">SYM</option>
                        <option value="79">NEW HOLLAND</option>
                        <option value="81">KIOTI</option>
                        <option value="82">CHAMP</option>
                        <option value="83">DFSK  </option>
                        <option value="84">DFM</option>
                        <option value="86">LAND ROVER</option>
                        <option value="88">KMT</option>
                        <option value="94">GPX</option>
                        <option value="95">KOMATSU</option>
                        <option value="97">PROTON</option>
                        <option value="102">PLATINUM</option>
                        <option value="104">LUZHONG</option>
                        <option value="105">EUROTRAC</option>
                        <option value="110">TALAYTHONG  </option>
                        <option value="112">KEEWAY</option>
                        <option value="114">NMAX</option>
                        <option value="116">SOKON</option>
                        <option value="117">Mercury</option>
                        <option value="121">CHRYSLER</option>
                        <option value="123">AUDI</option>
                        <option value="125">ISEKI</option>
                        <option value="127">FOTON</option>
                        <option value="129">NAGANO</option>
                        <option value="130">TAISHAN  </option>
                        <option value="133">BENELLI</option>
                        <option value="136">STALLIONS</option>
                        <option value="139">GOLDEN BOW</option>
                        <option value="143">SACHS</option>
                        <option value="146">HITACHI</option>
                        <option value="149">SEAT</option>
                        <option value="152">DEVA</option>
                        <option value="155">JUPITER</option>
                        <option value="158">ROVER MINI</option>
                        <option value="161">MG</option>
                        <option value="164">FARGO</option>
                        <option value="168">KOBELCO</option>
                        <option value="169">SCOMADI</option>
                        <option value="170">CLAAS</option>
                      </select>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="VEHICLE_MACHINE_NUMBER">รุ่นรถ</label>
                    <input type="text" class="form-control" id="VEHICLE_MACHINE_NUMBER" name="VEHICLE_MACHINE_NUMBER" placeholder="">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-2">
                  <label for="CAR_REGISTRATION_01">อักษรทะเบียนรถ</label>
                  <input type="text" class="form-control" id="CAR_REGISTRATION_01" name="CAR_REGISTRATION_01" placeholder="">
                  </div>
              
                  <div class="form-group col-md-1">
                  <label" style="margin-left: 30px;"> </label>
                  <input type="text" class="form-control" style="margin-top: 7px;"  placeholder="   - " disabled>
                  </div>

                  <div class="form-group col-md-2">
                  <label>เลขที่ทะเบียนรถ</label>
                  <input type="text" class="form-control" id="car_color" name="CAR_REGISTRATION_02" placeholder="">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="CAR_REGISTRATION_PROVINCE_NO">ทะเบียนจังหวัด</label>     
                    <select id="CAR_REGISTRATION_PROVINCE_NO" name="CAR_REGISTRATION_PROVINCE_NO" class="form-control">
                    <option value="">เลือกจังหวัด</option> 
                    </select>
                  </div>
            
                  <div class="form-group col-md-3">
                  <label for="VEHICLE_COLOR_COMMENT">สีรถ</label>
                  <input type="text" class="form-control" id="car_color" name="VEHICLE_COLOR_COMMENT" placeholder="">
                  </div>
              </div>
              
              <div class="form-row">
                  <div class="form-group col-md-6">
                  <label for="CAR_REGISTRATION_DATE">วันที่จดทะเบียน</label>
                  <input type="date" class="form-control" id="CAR_REGISTRATION_DATE" name="CAR_REGISTRATION_DATE" placeholder="">
                  </div>

                  <div class="form-group col-md-6">
                  <label for="CAR_POSSESS_DATE">วันที่ยึดรถ</label>
                  <input type="date" class="form-control" id="CAR_POSSESS_DATE" name="CAR_POSSESS_DATE" placeholder="">
                  </div>
              </div>
          </div>

          <div id="guarantor" class="tabcontent">
              <div class="form-row" style="margin-top: 20px;">
                  <!-- คำนำหน้า -->    
                  <div class="form-group col-md-2">
                      <label for="g_NAME_TITLE_NO">คำนำหน้า</label>
                      <select id="g_NAME_TITLE_NO" name="g_NAME_TITLE_NO" class="form-control">
                      <option value="">กรุณาระบุ</option>
                      <!-- <option value="1">นาย</option>
                      <option value="2">นาง</option>
                      <option value="3">นางสาว</option> -->
                      </select>
                  </div> 
                  <div class="form-group col-md-5">
                      <label for="g_FIRST_NAME">ชื่อจริง</label>
                      <input id="g_FIRST_NAME" type="text" class="form-control" name="g_FIRST_NAME" placeholder="">
                  </div>
                  <div class="form-group col-md-5">
                      <label for="g_LAST_NAME">นามสกุล</label>
                      <input id="g_LAST_NAME" type="text" class="form-control" name="g_LAST_NAME" placeholder="">
                  </div>
              </div>

              <div class="form-group">
                  <label for="g_GRT_AGE">อายุ</label>
                  <input type="text" class="form-control" name="g_GRT_AGE" placeholder="">
              </div>

              <div class="form-group">
                    <label for="g_MOBILE_NO">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" name="g_MOBILE_NO" placeholder="">
              </div>

              <div class="form-group">
                    <label for="g_GRT_RELATIONSHIP">เกี่ยวข้องเป็น</label>
                    <input type="text" class="form-control" name="g_GRT_RELATIONSHIP" placeholder="">
              </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="g_ID_CARD_NO">เลขบัตรประชาชน</label>
                    <input type="text" class="form-control" name="g_ID_CARD_NO" >
                </div>
                
                <div class="form-group col-md-4">
                    <label for="g_ID_CARD_ISSUED_DATE">วันออกบัตร</label>
                    <input type="date" class="form-control" name="g_ID_CARD_ISSUED_DATE" >
                </div>
                <div class="form-group col-md-4">
                    <label for="g_ID_CARD_EXPIRE_DATE">บัตรหมดอายุ</label>
                    <input type="date" class="form-control" name="g_ID_CARD_EXPIRE_DATE" >
                </div>
              </div>
              
              <div class="form-row">
                  <div class="form-group col-md-4">
                  <label for="g_OCCUPATION_NO">อาชีพ</label>
                        <select id="g_OCCUPATION_NO" name="g_OCCUPATION_NO" class="form-control" placeholder="กรุณาระบุ">
                        <option value="">กรุณาระบุ</option>
                        <option value="1">เกษตรกร</option>
                        <option value="2">ข้าราชการ</option>
                        <option value="3">รับจ้าง</option>
                        <option value="4">ค้าขาย</option>
                        <option value="5">ธุรกิจส่วนตัว</option>
                        <option value="6">อื่นๆ</option>
                        <option value="7">ลูกจ้างประจำ</option>
                        <option value="8">ลูกจ้างชั่วคราว</option>
                        <option value="9">ข้าราชการบำนาญ</option>
                        </select>
                  </div>

                  <div class="form-group col-md-4">
                      <label for="g_OCCUPATION_TEXT">ลักษณะงาน</label>
                      <input type="text" class="form-control" id="g_OCCUPATION_TEXT" name="g_OCCUPATION_TEXT" placeholder="">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="g_INCOME_PER_MONTH">รายได้ต่อเดือน</label>
                      <input type="text" class="form-control" id="g_INCOME_PER_MONTH" name="g_INCOME_PER_MONTH" placeholder="">
                  </div>
              </div>
              </br>
              <h1 style="font-size: 16px;">ที่อยู่ผู้ค้ำประกัน</h1>
              </br>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="g_ADDR_NO">บ้านเลขที่</label>
                    <input id="g_ADDR_NO" type="text" class="form-control" name="g_ADDR_NO" placeholder=""> 
                </div>
                <div class="form-group col-md-6">
                  <label for="g_ADDR_MOO">หมู่</label>
                  <input id="g_ADDR_MOO"  type="number" class="form-control" name="g_ADDR_MOO" placeholder="">
                </div>

              </div>

              <div class="form-group ">
                  <label for="g_ADDR_BUILDING">อาคาร</label>
                  <input type="text" class="form-control" id="g_ADDR_BUILDING" name="g_ADDR_BUILDING" placeholder="">
              </div>

              <div class="form-row">
                  <div class="form-group col-md-6">
                  <label for="g_ADDR_SOI">ซอย</label>
                  <input id="g_ADDR_SOI" type="text" class="form-control" name="g_ADDR_SOI" placeholder="">
                  </div>

                  <div class="form-group col-md-6">
                  <label for="g_ADDR_ROAD">ถนน</label>
                  <input id="g_ADDR_ROAD" type="text" class="form-control" name="g_ADDR_ROAD" placeholder="">
                  </div>
              </div>

              <!-- จังหวัด -->
              <div class="form-group ">
                <label for="g_ADDR4_NO">จังหวัด</label>
                <!-- <input type="text" class="form-control" id="provine"  placeholder="">  -->
                <select id="g_ADDR4_NO" name="g_ADDR4_NO" class="form-control">
                  <option value="">เลือกจังหวัด</option> 
                </select>
              </div>

              <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="g_ADDR3_NO">อำเภอ</label>
                    <!-- <input type="text" class="form-control" id="aumper" placeholder=""> -->
                    <select id="g_ADDR3_NO" name="g_ADDR3_NO" class="form-control" disabled>
                      <option value="">เลือกอำเภอ</option>
                    </select> 
                  </div>

                  <div class="form-group col-md-4">
                    <label for="g_ADDR2_NO">ตำบล</label>
                    <!-- <input type="text" class="form-control" id="district" placeholder=""> -->
                    <select id ="g_ADDR2_NO" name="g_ADDR2_NO" class="form-control" disabled>
                    <option value="">เลือกตำบล</option> 
                    </select>
                  </div>

                  <div class="form-group col-md-5">
                    <label for="zipcodes">รหัสไปรษณีย์</label>
                    <input type="text" id="g_ADDR5" name="g_ADDR5" class="form-control"  placeholder="">  
                  </div>
              </div>
          </div>

          </br>
          <button type="button" id="submitBtn" class="btn btn-success" >บันทึก</button>  
          <button type="button" id="cancelBtn" class="btn btn-dark" >ยกเลิก</button>   
      </div>
    </div>

  </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body alert alert-success mb-0">
                บันทึกข้อมูลสำเร็จ
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body alert alert-danger mb-0">
                <span class='error'>ไม่สามารถบันทึกข้อมูล</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body alert alert-warning mb-0">
                <span class='error'>กรุณาแก้ไขข้อมูลที่ต้องการ</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
      </div>
    </div>
  
    <?php
      include('ic/footer.php');
    ?>

<script>
  
  $(document).ready(function () {
      $("#search_contract").select2({
            ajax: {
              url: "../controllers/search_contract.php",
              dataType: 'json',
              delay: 2000,
              data: function (params) {

                return {
                  q: params.term, // search term
                };
              },
              // cache: false,
              transport: function (params, success, failure) {

                if ( params.data.q.trim().length < 3) {
                  return false;
                }

                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
              }
            },
          placeholder: 'ค้นหาเลขที่สัญญา,เลขบัตรประชาชน,ชื่อ-นามสกุล',
          allowClear: true,
          minimumInputLength: 3,
          templateResult: formatRepo,
          templateSelection: formatRepoSelection,
          language: {
               searching: function(e) {
                  return "กำลังค้นหา...";
                }
          },
          escapeMarkup: function (markup) { return markup; },
          theme: 'bootstrap4',
      });

      function formatRepo (repo) {
        
        if (repo.loading) {
          return repo.text;
        }
        
        if ( repo.CONTRACT_CODE !== undefined ) {
          return 'เลขที่: ' + repo.CONTRACT_CODE + ' (เลขบัตร: ' + repo.ID_CARD_NO + ' ,' + repo.FIRST_NAME + ' ' + repo.LAST_NAME + ' ,วันที่: ' + repo.CONTRACT_DATE + ' ,' + repo.ORG_NAME + ' ,' + repo.LOAN_VAL + ')';
        }

        return repo.CONTRACT_CODE;
      }

      function formatRepoSelection (repo) {

        if (repo.loading) {
          return repo.text;
        }
        
        if ( repo.CONTRACT_CODE !== undefined ) {
          return 'เลขที่: ' + repo.CONTRACT_CODE + ' (เลขบัตร: ' + repo.ID_CARD_NO + ' ,' + repo.FIRST_NAME + ' ' + repo.LAST_NAME + ' ,วันที่: ' + repo.CONTRACT_DATE + ' ,' + repo.ORG_NAME + ' ,' + repo.LOAN_VAL + ')';
        }
        return repo.CONTRACT_CODE;
      }

      var url,provinces,amphurs,districts,zipcodes;

      $.getJSON('json/provinces.json', function (data) {
          provinces = data;

          provinces.forEach( function (entry,key ) {
          // $.each(provinces, function (key, entry) {
            $('#ADDR4_NO,#g_ADDR4_NO,#CAR_REGISTRATION_PROVINCE_NO').append($('<option></option>').attr('value', entry.ADDR_PROVINCE_NO).text(entry.ADDR_PROVINCE_NAME));
          });

      });

      $.getJSON('json/amphurs.json', function (data) {
            amphurs = data;
      });

      $.getJSON('json/districts.json', function (data) {
            districts = data;
      });

      $.getJSON('json/zipcodes.json', function (data) {
            zipcodes = data;
      });



      $('#search_contract').on('select2:select', function (e) {
          var data = e.params.data;

          $(this).attr('data-code',data.CONTRACT_CODE);
          
          $("#ADDR2_NO,#ADDR3_NO,#g_ADDR2_NO,#g_ADDR3_NO").prop('disabled',true);

          $('#submitBtn,#cancelBtn').prop('disabled',false);
      
          $.each( data , function( key, value ) {

            if( $('[name="'+ key +'"]').length ){

                var $this = $('[name="'+ key +'"]');
                $this.attr('data-value',value);
              
                if( $this.prop('id') == 'search_emp' ){

                    $this.val(value).change();
            
                }else if(  $this.prop('id') == 'ADDR4_NO' ){
                  
                    $("#ADDR4_NO").val(value).trigger('change',[e.params.data.ADDR3_NO,e.params.data.ADDR2_NO,e.params.data.ADDR5]);
                    // $("#ADDR3_NO").trigger('change',[e.params.data.ADDR2_NO]);

                }else if(  $this.prop('id') == 'g_ADDR4_NO' ){
                
                    $('#g_ADDR4_NO').val(value).trigger('change',[e.params.data.g_ADDR3_NO,e.params.data.g_ADDR2_NO,e.params.data.g_ADDR5]); 
                    // $("#g_ADDR3_NO").trigger('change',[e.params.data.g_ADDR2_NO]);

                }else if( $this.prop('id') == 'ADDR3_NO' || $this.prop('id') == 'ADDR2_NO' || $this.prop('id') == 'g_ADDR3_NO' || $this.prop('id') == 'g_ADDR2_NO' || $this.prop('id') == 'ADDR5' || $this.prop('id') == 'g_ADDR5'  ){
                //
                }else{
                    $this.val(value).change();
                }
            }
          });

      }); 


      $.getJSON('../controllers/get_emp.php', function (data) {

        $('#search_emp').select2({
            data : data.results,
            theme: 'bootstrap4'
        });

      });

      $.getJSON('../controllers/ajax_list.php', 
        { table_name: "sale_condition_type", field_id: "SALE_CONT_TYPE_NO", field_text: "SALE_CONT_TYPE_DESCR" , field_desc: "SALE_CONT_TYPE_CODE" , condition: "STATUS_IS_ACTIVE = 1" } , function (data) {
            $('#SALE_CONT_TYPE_NO').select2({
                data : data.results,
                theme: 'bootstrap4'
            });
        });

      $.getJSON('../controllers/ajax_list.php', 
        { table_name: "sys_name_title", field_id: "NAME_TITLE_NO", field_text: "NAME_TITLE_DESCR" } , function (data) {
      
            $('#NAME_TITLE_NO,#CUST_SPOUSE_NAME_TITLE_NO,#g_NAME_TITLE_NO').select2({
                data : data.results,
                theme: 'bootstrap4'
            });
        });

        $("#ADDR4_NO,#g_ADDR4_NO").on('change', function(e,amphur,district,zipcode){
      
            var $ADDR_2,$ADDR_3;
            var province = $(this).val();

            if( e.target.id == 'ADDR4_NO'){
              
                $ADDR_2 = $('#ADDR2_NO');
                $ADDR_3 = $('#ADDR3_NO');
                
            } else {
            
              console.log(e);
                $ADDR_2 = $('#g_ADDR2_NO');
                $ADDR_3 = $('#g_ADDR3_NO');
            }

            $ADDR_2.empty();
            $ADDR_3.empty();

            $ADDR_2.append($('<option></option>').attr('value','').text('เลือกตำบล'));
            $ADDR_3.append($('<option></option>').attr('value','').text('เลือกอำเภอ'));

            $.each(amphurs[province], function (key, entry) {
              if( amphur !== undefined && entry.ADDR_AMPHUR_NO == amphur ){
                  $ADDR_3.append('<option value="'+entry.ADDR_AMPHUR_NO+'" selected="selected">'+ entry.ADDR_AMPHUR_NAME +'</option>');
              }else{
                $ADDR_3.append($('<option></option>').attr('value', entry.ADDR_AMPHUR_NO).text(entry.ADDR_AMPHUR_NAME));
              } 
            });
            
            if( amphur !== undefined && district !== undefined ){

              if( zipcode !== undefined) {
                $ADDR_3.val(amphur).trigger('change',[district,zipcode])
              }else{
                $ADDR_3.val(amphur).trigger('change',[district])
              }
         
                $ADDR_2.prop('disabled',false);
                $ADDR_3.prop('disabled',false);
            }else{
                $ADDR_2.prop('disabled',true);
                $ADDR_3.prop('disabled',false);
            }
     
        });

        $("#ADDR3_NO,#g_ADDR3_NO").on('change' , function(e,district,zipcode){
        
            var $ADDR_2,district_code;
            var amphur = $(this).val();

            if( e.target.id == 'ADDR3_NO'){

                $ADDR_2 = $('#ADDR2_NO');
                $ADDR5 = $('#ADDR5');

            } else {

                $ADDR_2 = $('#g_ADDR2_NO');
                $ADDR5 = $('#g_ADDR5');
            }

            $ADDR_2.empty();
            $ADDR_2.append($('<option></option>').attr('value','').text('เลือกตำบล'));
          
            $.each(districts[amphur], function (key, entry) {
                district_code = entry.ADDR_DISTRICT_CODE;
              if( district !== undefined && entry.ADDR_DISTRICT_NO == district ){
                  $ADDR_2.append('<option data-code="'+district_code+'" value="'+entry.ADDR_DISTRICT_NO+'" selected="selected">'+ entry.ADDR_DISTRICT_NAME +'</option>');
              }else{
                  $ADDR_2.append($('<option></option>').attr('data-code',district_code).attr('value', entry.ADDR_DISTRICT_NO).text(entry.ADDR_DISTRICT_NAME));
              } 
              
            });

            if( zipcode !== undefined) {
                $ADDR5.val(zipcode);
            } else {
                $ADDR5.val(zipcodes[0][district_code]);
            }

            $ADDR_2.prop('disabled',false);
            $("#ADDR2_NO").prop('disabled',false);
        
        }); 

        $("#ADDR2_NO,#g_ADDR2_NO").on('change' , function(e){

            var district_code,$ADDR5;

            if( e.target.id == 'ADDR2_NO'){

                district_code = $('#ADDR2_NO > option:selected').attr('data-code'); 
                $('#ADDR5').val(zipcodes[0][district_code]);

            } else {
                district_code = $('#g_ADDR2_NO > option:selected').attr('data-code');
                $('#g_ADDR5').val(zipcodes[0][district_code]);
            }
     
        });

        $('#submitBtn').on('click',function(e){
            e.preventDefault();
           
            var data = {};
            var new_data = {};
            var old_data = {};
            
            $('select:not(#search_contract),input').each( function(k,v){

                if( $(this).attr('data-value') === undefined ){
                    if ( $(this).val() !== "" && $(this).val() !== null ){
                      new_data[$(this).attr('name')] = $(this).val();
                      old_data[$(this).attr('name')] = $(this).attr('data-value');
                    }
                }else{
                    if( $(this).val() !== null && $(this).attr('data-value') !== $(this).val() ){
                      new_data[$(this).attr('name')] = $(this).val();
                      old_data[$(this).attr('name')] = $(this).attr('data-value');
                    }
                }
            });

            var rec_no = $('#search_contract').val();
            var contract_code = $('#search_contract').attr('data-code');

              console.log(new_data);
              console.log(old_data);

            if( new_data && Object.keys(new_data).length === 0 && new_data.constructor === Object ){

                $('#warningModal').modal('show'); 

            }else{

              data.new_data = new_data;
              data.old_data = old_data;
              data.rec_no = rec_no;
              data.contract_code = contract_code;
          
              $('#submitBtn').prop('disabled',true);
              $('#cancelBtn').prop('disabled',true);

                $.ajax({
                  url: '../controllers/contract_db.php',
                  type: 'POST',
                  dataType: 'json',
                  // contentType : "application/json",
                  data:{data:JSON.stringify(data)},
                  success: function (data) {

                    $('#submitBtn').prop('disabled',false);
                    $('#cancelBtn').prop('disabled',false);

                    if( data.status == "success"){
                      $('#successModal').modal('show');

                        $.each(data.data, function(k,v){
                          var $this = $('[name="'+ k +'"]');
                          $this.attr('data-value',v);
                        });

                    } else {

                      $.each(data.errors,function(k,v){
                          $('#errorModal').find('.error').append("<p>"+v+"</p>");
                      });
              
                      $('#errorModal').modal('show');
                    }
                  
                  },
              });

            }
           
        });

        $('#cancelBtn').on('click' , function(e){
          
            $('select,input').each( function(k,v){
                if( $(this).id !== 'search_contract' )
                {
                   $(this).val( $(this).attr('data-value')).change();
                }
            });
        });


  }); 

</script>

  <script>
  function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
  </script>
   
</body>
</html>