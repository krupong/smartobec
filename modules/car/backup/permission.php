<!-- Bootstrap Include -->
<link rel="stylesheet" type="text/css" href="./bootstrap-3.3.5-dist/css/bootstrap.min.css">
<script src="./bootstrap-3.3.5-dist/js/jquery-1.11.3.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap-confirmation.min.js"></script>
<!-- Bootstrap Popover -->
<script>
	$(function () {
 		$('[data-toggle="popover"]').popover()
	})
</script>

<!-- Bootstrap Confirmation -->
<script>
	$('[data-toggle="confirmation"]').confirmation()
</script>
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>

<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_subdep.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;
		$("select#subdep").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
        removeOptions(document.getElementById("person_id")); // clear dropdrowlist person_id when click department
	});
});
$(function(){
	$("select#subdep").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"subdep="+$(this).val(), // ส่งตัวแปร GET ชื่อ subdep ให้มีค่าเท่ากับ ค่าของ subdepartment
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
function removeOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=1;i--){
        selectbox.remove(i);
    }
}
</script>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<br>

<div class="container">
  <div class="panel panel-default">
<?php
//ส่วนหัว
if(!(($index==1) or ($index==2) or ($index==5))){
?><div class="panel-heading"><h3 class="panel-title">เจ้าหน้าที่ ผู้ให้ความเห็นชอบ  และผู้อนุมัติ</h3></div><?
}
//ส่วนฟอร์มรับข้อมูล
if($index==1){
?>
      <div class="panel-heading"><h3 class="panel-title">กำหนดเจ้าหน้าที่ ผู้ให้ความเห็นชอบ  และผู้อนุมัติ</h3></div>
      <div class="panel-body">
        <form id='frm1' name='frm1' class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกสำนัก</label>
          <div class="col-sm-4">
            <label >
                <Select name='department' id='department' class="form-control">
                    <option  value = ''>เลือกสำนัก</option>
                    <?$sql = "select * from  system_department order by department";
                    $dbquery = mysqli_query($connect,$sql);
                    While ($result_department = mysqli_fetch_array($dbquery)){
                    echo "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
                    }?>
                </select>
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกกลุ่ม</label>
          <div class="col-sm-4">
            <label >
                <Select name='subdep' id='subdep' class='form-control'>
                    <option  value = ''>เลือกกลุ่ม</option>
                </select>
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right">เลือกผู้ดูแล(Admin)</label>
          <div class="col-sm-4">
            <label >
                <Select name='person_id' id='person_id' class='form-control'>
                    <option  value = ''>เลือกบุคลากร</option>
                </select>
            </label>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='car_permission1' value='1'>
            </span>
            <input type="text" class="form-control" value="เจ้าหน้าที่" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='car_permission1' value='2'>
            </span>
            <input type="text" class="form-control" value="ผู้ให้ความเห็นชอบ" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
            <div class="col-sm-4">
            <div class="input-group">
            <span class="input-group-addon">
                <input type="radio" aria-label="..." name='car_permission1' value='3'>
            </span>
            <input type="text" class="form-control" value="ผู้อนุมัติ" readonly>
            </div><!-- /input-group -->
            </div>
        </div>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right"></label>
          <div class="col-sm-4">
            <label >
                <button type="button" name="smb" class="btn btn-primary" onclick='goto_url(1)'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ตกลง
                </button>&nbsp;
                <button type="button" name="back" class="btn btn-default" onclick='goto_url(0)'>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>ย้อนกลับ
                </button>
            </label>
          </div>
        </div>
        <hr>
      </div>
</form>
<?
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
?>
      <div class="alert alert-warning" role="alert"><h3 class="text-center">โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</h3></div>
      <div class="panel-body">
        <div class="form-group centerd" style="text-align:center;">
            <button type="button" name="smb" class="btn btn-primary btn-md" data-toggle='confirmation' onclick="location.href='?option=car&task=main/permission&index=3&id=<?=$_GET[id]?>'">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>ยืนยัน
            </button>&nbsp;&nbsp;
            <button type="button" name="back" class="btn btn-default btn-md" onclick='goto_url(0)'>
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>ยกเลิก
            </button>
        </div>
      </div>

<table class='table table-hover table-bordered table-striped table-condensed'>
<tr><td align=center>
</td></tr></table>
<?
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=car&task=main/permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=car&task=main/permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=car&task=main/permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into car_permission (person_id, p1, officer,rec_date) values ('$_POST[person_id]', '$_POST[car_permission1]', '$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=car&task=main/permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";

$sql_user = "select a.department,a.sub_department,a.person_id from person_main a left outer join car_permission b on a.person_id=b.person_id  where b.id='".$_GET['id']."' ";
$dbquery_user = mysqli_query($connect,$sql_user);
$result_user = mysqli_fetch_array($dbquery_user);
$department = $result_user['department'];

echo "<Tr><Td align='right'>เลือกสำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือกสำนัก</option>" ;
$sql = "select * from  system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result_department = mysqli_fetch_array($dbquery)){
		if($result_department['department']==$result_user['department']){
		echo  "<option  value ='$result_department[department]' selected>$result_department[department] $result_department[department_name]</option>" ;
		}
		else{
		echo  "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
		}
}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>เลือกกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='subdep' id='subdep' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_subdepartment where department='$result_user[department]' order by sub_department_name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$sub_department = $result['sub_department'];
		$sub_department_name = $result['sub_department_name'];
		if($sub_department==$result_user['sub_department']){
		echo  "<option value = $sub_department selected>$sub_department_name</option>" ;
		}
		else{
		echo  "<option value = $sub_department>$sub_department_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>เลือกผู้ดูแล(Admin)&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where department='$result_user[department]' and sub_department = '$result_user[sub_department]'and status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$result_user['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>" ;
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";


$sql = "select * from car_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

$p1_check1="";  $p1_check2="";  $p1_check3="";

			if($ref_result['p1']==1){
			$p1_check1="checked";
			}
			else if($ref_result['p1']==2){
			$p1_check2="checked";
			}
			else if($ref_result['p1']==3){
			$p1_check3="checked";
			}
echo   "<tr><td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='1' $p1_check1></td></tr>";
echo   "<tr><td align='right'>ผู้ให้ความเห็นชอบ&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='2' $p1_check2></td></tr>";
echo   "<tr><td align='right'>ผู้อนุมัติ&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='3' $p1_check3></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update car_permission set  person_id='$_POST[person_id]', p1='$_POST[car_permission1]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=car&task=main/permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select car_permission.id, car_permission.p1, person_main.prename, person_main.name, person_main.surname from car_permission left join person_main on car_permission.person_id=person_main.person_id  order by car_permission.p1";
$dbquery = mysqli_query($connect,$sql);
echo  "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td colspan='7' align='left'>";
?>
<button type="button" class="btn btn-primary" onclick='location.href="?option=car&task=main/permission&index=1"'>
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เพิ่มข้อมูล
</button>
<?
echo "</Td></Tr>";
echo "<Tr><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อเจ้าหน้าที่</Td><td  align='center' colspan='3'>สิทธื์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr><Td  align='center' width='80'>เจ้าหน้าที่</Td><Td  align='center' width='80'>ผู้เห็นชอบ</Td><Td  align='center' width='80'>ผู้อนุมัติ</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];

			$p1_pic="";
			$p2_pic="";
			$p3_pic="";
            $txt_pic="<span class='glyphicon glyphicon-ok'></span>";
			if($result['p1']==1){
			$p1_pic=$txt_pic;
			}
			else if($result['p1']==2){
			$p2_pic=$txt_pic;
			}
			else if($result['p1']==3){
			$p3_pic=$txt_pic;
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$prename$name $surname</Td><Td align='center'>$p1_pic</Td><Td align='center'>$p2_pic</Td><Td align='center'>$p3_pic</Td>
		<Td align='center' width='50' ><a href=?option=car&task=main/permission&index=2&id=$id><span class='glyphicon glyphicon-remove'></span></a></Td>
		<Td align='center' width='50'><a href=?option=car&task=main/permission&index=5&id=$id><span class='glyphicon glyphicon-pencil'></span></a></Td>
	</Tr>";
$M++;
	}
    ?>
      <a href='?option=ioffice&task=book_manage&action=delete&bookid=".$row['bookid']."' class='btn btn-danger btn-xs' data-toggle='confirmation'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>&nbsp;ลบ</a>
    <?
echo "</Table>";
}

?>

<script>

    function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
		alert("กรุณาเลือกบุคลากร");
		}
		else if(frm1.car_permission1[0].checked ==false && frm1.car_permission1[1].checked ==false && frm1.car_permission1[2].checked ==false ){
			alert("กรุณาเลือกเจ้าหน้าที่ หรือผู้เห็นชอบ หรือผู้อนุมัติ ");
		}else{
			callfrm("?option=car&task=main/permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=car&task=main/permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
      </div>
</div>
</body>
