<!-- BOOTSTRAP STYLES-->
    <link href="modules/book/assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="modules/book/assets/css/font-awesome.css" rel="stylesheet" />
	<link href="modules/book/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
     <!-- MORRIS CHART STYLES-->
    
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="modules/book/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

<?php
if(isset($_REQUEST['index'])){
$index=$_REQUEST['index'];
}
else{
$index="";
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>
<script src="modules/book/assets/js/jquery-1.10.2.js"></script>
 <!-- DATA TABLE SCRIPTS -->
    <script src="modules/book/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="modules/book/assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
	 <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

<?php
//แปลงเวลาเป็นภาษาไทย
function ThaiTimeConvert($timestamp="",$full="",$showtime=""){
    global $SHORT_MONTH, $FULL_MONTH, $DAY_SHORT_TEXT, $DAY_FULL_TEXT;

    $DAY_FULL_TEXT = array(
    "Sunday" => "อาทิตย์",
    "Monday" => "จันทร์",
    "Tuesday" => "อังคาร",
    "Wednesday" => "พุธ",
    "Thursday" => "พฤหัสบดี",
    "Friday" => "ศุกร์",
    "Saturday" => "เสาร์"
    );

    $DAY_SHORT_TEXT = array(
    "Sunday" => "อา.",
    "Monday" => "จ.",
    "Tuesday" => "อ.",
    "Wednesday" => "พ.",
    "Thursday" => "พฤ.",
    "Friday" => "ศ.",
    "Saturday" => "ส."
    );

    $SHORT_MONTH = array(
    "1" => "ม.ค.",
    "2" => "ก.พ.",
    "3" => "มี.ค.",
    "4" => "เม.ย.",
    "5" => "พ.ค.",
    "6" => "มิ.ย.",
    "7" => "ก.ค.",
    "8" => "ส.ค.",
    "9" => "ก.ย.",
    "10" => "ต.ค.",
    "11" => "พ.ย.",
    "12" => "ธ.ค."
    );

    $FULL_MONTH = array(
    "1" => "มกราคม",
    "2" => "กุมภาพันธ์",
    "3" => "มีนาคม",
    "4" => "เมษายน",
    "5" => "พฤษภาคม",
    "6" => "มิถุนายน",
    "7" => "กรกฏาคม",
    "8" => "สิงหาคม",
    "9" => "กันยายน",
    "10" => "ตุลาคม",
    "11" => "พฤศจิกายน",
    "12" => "ธันวาคม"
    );

    $FULL_MONTH2 = array(
    "01" => "มกราคม",
    "02" => "กุมภาพันธ์",
    "03" => "มีนาคม",
    "04" => "เมษายน",
    "05" => "พฤษภาคม",
    "06" => "มิถุนายน",
    "07" => "กรกฏาคม",
    "08" => "สิงหาคม",
    "09" => "กันยายน",
    "10" => "ตุลาคม",
    "11" => "พฤศจิกายน",
    "12" => "ธันวาคม"
    );

    $day = date("l",$timestamp);
    $month = date("n",$timestamp);
    $year = date("Y",$timestamp);
    $time = date("H:i:s",$timestamp);
    $times = date("H:i",$timestamp);
    if($full){
        $ThaiText = $DAY_FULL_TEXT[$day]." ที่ ".date("j",$timestamp)." เดือน ".$FULL_MONTH[$month]." พ.ศ.".($year+543) ;
    }else{
        $ThaiText = date("j",$timestamp)."  ".$SHORT_MONTH[$month]."  ".($year+543);
    }

    if($showtime == "1"){
        return $ThaiText." เวลา ".$time;
    }else if($showtime == "2"){
        $ThaiText = date("j",$timestamp)." ".$SHORT_MONTH[$month]." ".($year+543);
        return $ThaiText." : ".$times;
    }else{
        return $ThaiText;
    }
}
?>