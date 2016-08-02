<?php 
// Define Variable
if(isset($_POST["searchtext"])){ }else{ $_POST["searchtext"]=""; }
if(isset($_SESSION["searchtext"])){ }else{ $_SESSION["searchtext"]=""; }
if(isset($_POST["searchbookstatusid"])){ }else{ $_POST["searchbookstatusid"]=""; }
if(isset($_SESSION["searchbookstatusid"])){ }else{ $_SESSION["searchbookstatusid"]=""; }
?>

<?php
if(isset($_REQUEST['index'])){
$index=$_REQUEST['index'];
}
else{
$index="";
}

//ผนวกไฟล์
if($task!=""){
	//echo "task is ".$task."<br>";
	include("$task");
}
else {
	include("default.php");
}
?>

<!-- Bootstrap Tab -->
<script>
	$('#myTab a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})
</script>

<!-- Show and Hide File Upload -->
<script type="text/javascript">
function insRow()
  {	
  	var CntRow=document.getElementById('cntrow');
		var idTR=(parseInt(CntRow.value)+1);
		  var x=document.getElementById('myTable').insertRow(idTR);
		  var Col0=x.insertCell(0);
		  var Col1=x.insertCell(1);
		  var OldObj1=document.getElementById("UploadedFile").outerHTML;
		  var NewObj1=OldObj1.replace("id=UploadedFile","id=UploadedFile"+idTR);		  
		  Col0.innerHTML=NewObj1;
		  Col1.innerHTML='&nbsp;<a href="javascript:delRow('+idTR+');" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
 CntRow.value=idTR;//ค่าต่อไป
  }

function delRow(obj)
  {
    	var CntRow=document.getElementById('cntrow');
		if(obj==CntRow.value){ // ลบด้านล่างก่อน
				CntRow.value=(parseInt(CntRow.value)-1);
				document.getElementById('myTable').deleteRow(obj);
		}else{
			alert('ลบช่องเอกสารแนบจากด้านล่างก่อน');
		}
  }

$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	
			  url: "modules/ioffice/return_ajax_sub_department.php", 
			  data:"department="+$(this).val(),
			  async: false
		}).responseText;		
		$("select#sub_department").html(datalist2); 
	});
});

$(function(){
	$("select#sub_department").change(function(){
		var datalist2 = $.ajax({	
			  url: "modules/ioffice/return_ajax_person_subdepartment.php", 
			  data:"sub_department="+$(this).val(),
			  async: false
		}).responseText;		
		$("select#person").html(datalist2); 
	});
});

function toggleDiv(divId) {
   $("#"+divId).toggle();
}

function showDiv(divId) {
   $("#"+divId).show();
}

function hideDiv(divId) {
   $("#"+divId).hide();
}

</script>

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