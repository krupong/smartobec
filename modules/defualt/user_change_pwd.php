<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//if (!isset($_POST['newpasswd'])) { $_POST['newpasswd']=""; }
if(isset($_POST['newpasswd'])){
	if($_POST["newpasswd"]!=""){
		$newpasswd = trim($_POST['newpasswd']);
		$newpasswd = md5($newpasswd);
		$sql = "update system_user set userpass = '$newpasswd' where person_id = '$_SESSION[login_user_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$sql=$sql = "select * from system_user where userpass = '$newpasswd' and person_id='$_SESSION[login_user_id]' ";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		if($result){
			echo "<script>alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว'); document.location.href='index.php';</script>";
			exit();
		}
		else {
			echo "<script>alert('เกิดปัญหาบางอย่าง ไม่สามารถเปลี่ยนรหัสผ่านใหม่ได้'); document.location.href='index.php';</script>";
			exit();
		}
	}
}

// Upload File
$target_dir = "./modules/person/picture/";
$file_no = 0;
$person_id = $_SESSION["login_user_id"];
if(empty($_FILES['UploadedFile']['tmp_name'])){ $_FILES['UploadedFile']['tmp_name']=""; }
for($j=0;$j<count($_FILES['UploadedFile']['tmp_name']);$j++) {
	//echo "<br><br><br><br><br><br>".$j;
	if(!empty($_FILES['UploadedFile']['tmp_name'][$j])) {
		++$file_no;
		$target_file = $target_dir . basename($_FILES["UploadedFile"]["name"][$j]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$rename_file = $target_dir . $person_id . '.' . strtolower($imageFileType);
		//echo "<br><br><br><br><br><br>".$rename_file;
		unlink($rename_file);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["UploadedFile"]["tmp_name"][$j]);
		    if($check !== false) {
		        //echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        //echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($rename_file)) {
		    //echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if(!isset($_FILES["fileToUpload"]["size"])){ $_FILES["fileToUpload"]["size"]=""; }
		if ($_FILES["fileToUpload"]["size"][$j] > 500000) {
		    //echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		$imageFileType = strtolower($imageFileType);
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    //echo "Sorry, files type are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    //echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["UploadedFile"]["tmp_name"][$j], $rename_file)) {
		        //echo "The file ". basename( $_FILES["UploadedFile"]["name"][$j]). " has been uploaded.";
		        switch ($_SESSION["login_group"]) {
		        	case '1':
		        		$sql = "UPDATE person_main SET pic='$rename_file' WHERE person_id='$person_id'";
						$result = mysqli_query($connect,$sql);
		        		break;

		        	case '2':
		        		$sql = "UPDATE person_khet_main SET pic='$rename_file' WHERE person_id='$person_id'";
						$result = mysqli_query($connect,$sql);
		        		break;
		        	
		        	default:
		        		# code...
		        		break;
		        }
		        
				echo "<script>alert('เปลี่ยน รูปประจำตัวเรียบร้อยแล้ว'); document.location.href='index.php';</script>";
				exit();
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}//if
}//for


?>
</br>
<div class="panel panel-default">
<div class="panel-heading">
	<h3 class="panel-title">แก้ไขข้อมูลส่วนตัว</h3>
</div>
<div class="panel-body">
<form id="frm1" name="frm1" enctype="multipart/form-data" method="POST">
<table cellpadding='5' cellspacing='5' align='center' class='row2'>
	<tr><td colspan='3' height=10></td></tr>
	<tr><td colspan='3' align=center><font size='4'><b>เปลี่ยน Password</td></tr>
	<tr><td>&nbsp;</td>
		<td align='right'><b>รหัสผ่านใหม่&nbsp;&nbsp;</td><td  align='left'><input type="password" name="newpasswd"/></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
		<td align='right'><b>รหัสผ่านใหม่(อีกครั้ง)&nbsp;&nbsp;</td><td align='left'><input type="password" name="renewpasswd"/></td>
	</tr>
	<tr><td colspan='3' height=10></td></tr>
	<tr><td colspan='3' align=center><font size='4'><b>เปลี่ยน รูปประจำตัว</td></tr>
	<tr><td>&nbsp;</td>
		<td align='right'><b>
			<?php
				$person_id = $_SESSION["login_user_id"];
				switch ($_SESSION["login_group"]) {
					case '1':
						$sqlperson = "SELECT * FROM person_main WHERE person_id = '$person_id'";
						break;

					case '2':
						$sqlperson = "SELECT * FROM person_khet_main WHERE person_id = '$person_id'";
						break;
					
					default:
						# code...
						break;
				}
				
				$resultperson = mysqli_query($connect, $sqlperson);
				$rowperson = $resultperson->fetch_assoc(); 
				if(file_exists($rowperson["pic"])){ ?>
              	<img src="<?php echo $rowperson["pic"]; ?>" alt="..." class="img-thumbnail" width="100" hight="100">            
            <?php } ?>
            &nbsp;&nbsp;
        </td>
        <td align='left'><input class="form-control" name="UploadedFile[]" type="file" class="BrowsFile" id="UploadedFile" size="55" accept="image/jpeg">
        </td>
	</tr>
	<tr align="center"><td colspan="2"  align="right"><br><input class='btn btn-primary' type="submit" value="ตกลง" onclick="goto_url(1)"&nbsp;&nbsp;></td><td align="left"><br>&nbsp;<INPUT class='btn btn-default' TYPE="button" name="back" value="ย้อนกลับ" onclick="goto_url(0)" ></td></tr>
	<tr><td colspan=3 height=10></td></tr>
</table>
</form>	
</div>
</div>

<script>
function goto_url(val){
	if(val==0){
		callfrm("./");   // page ย้อนกลับ 
	}else if(val==1){
		//if(frm1.newpasswd.value==''){
		//	alert('กรุณากรอกรหัสผ่านใหม่ที่ต้องการ');
		//}else if(frm1.renewpasswd.value==''){
		//	alert('กรุณากรอกยืนยันรหัสผ่านใหม่');
		//}else 
		if(frm1.newpasswd.value!=frm1.renewpasswd.value){
			alert("รหัสผ่านสองครั้งไม่ตรงกัน");
		}else{
			callfrm("?file=user_change_pwd");   //page ประมวลผล
		}
	}
}

</script>