<?php
	// Define Variable
	if(!isset($_POST["searchtext"])){ $_POST["searchtext"]=""; }
	if(!isset($_SESSION["searchtext"])){ $_SESSION["searchtext"]=""; }
	if(!isset($_POST["searchdepartmentid"])){ $_POST["searchdepartmentid"]=""; }
	if(!isset($_SESSION["searchdepartmentid"])){ $_SESSION["searchdepartmentid"]=""; }
	if(!isset($_POST["position_other_code1"])){ $_POST["position_other_code1"]="0"; }
	if(!isset($_POST["position_other_code2"])){ $_POST["position_other_code2"]="0"; }
	if(!isset($_FILES["fileToUpload"])){ $_FILES["fileToUpload"]=""; }
	if(!isset($_GET["page"])){ $_GET["page"]=1; }
	if(!isset($_GET["action"])){ $_GET["action"]=""; }
	if(!isset($_POST["insert"])){ $_POST["insert"]=""; }
	if(!isset($_POST["update"])){ $_POST["update"]=""; }
	if(!isset($_POST["delete"])){ $_POST["delete"]=""; }

	// เพิ่มข้อมูล
	if($_POST["insert"]=="insert"){
			$person_id = $_POST["person_id"];
		    $prename = $_POST["prename"];
		    $name = $_POST["name"];
		    $surname = $_POST["surname"];
		    $position_code = $_POST["position_code"];
		    $person_order = $_POST["person_order"];
		    $department = $_POST["department"];
		    $sub_department = $_POST["sub_department"];
		    $officer = $_POST["post_personid"];
		    if($_POST["position_other_code1"]==1){
		    	$position_other_code = 9999;
		    }elseif($_POST["position_other_code2"]==1){
				$position_other_code = $_POST["sub_department"];
		    }else{
		    	$position_other_code = 0;
		    }
		    
		    $sql = "INSERT INTO person_main(person_id,prename,name,surname,position_code,person_order,department,sub_department,position_other_code,officer) VALUES('$person_id','$prename','$name','$surname','$position_code','$person_order','$department','$sub_department','$position_other_code','$officer')";
			//echo $sql;
			$result = mysqli_query($connect, $sql);
			$bookid = mysqli_insert_id($connect);
			// Upload File
			$target_dir = "./modules/person/picture/";
			$file_no = 0;
         	for($j=0;$j<count($_FILES['UploadedFile']['tmp_name']);$j++) {
				if(!empty($_FILES['UploadedFile']['tmp_name'][$j])) {
					++$file_no;
					$target_file = $target_dir . basename($_FILES["UploadedFile"]["name"][$j]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$rename_file = $target_dir . $person_id . '.' . strtolower($imageFileType);
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
					        $sql = "UPDATE person_main SET pic='$rename_file' WHERE person_id='$person_id'";
							$result = mysqli_query($connect,$sql);
					    } else {
					        //echo "Sorry, there was an error uploading your file.";
					    }
					}
				}//if
			}//for	 
		echo "<script language='javascript'>window.location.href = '?option=person&task=person&page=".$_GET["page"]."'</script>";
	}

	// ลบข้อมูล
	if($_POST["delete"]!=""){
		$person_id = $_POST["delete"];
		$sql = "DELETE FROM person_main WHERE person_id = '$person_id'";
		$result = mysqli_query($connect, $sql);
		echo "<script language='javascript'>window.location.href = '?option=person&task=person&page=".$_GET["page"]."'</script>";

	}

	// แก้ไขข้อมูล
	if($_POST["update"]=="update"){
			$person_id = $_POST["person_id"];
		    $prename = $_POST["prename"];
		    $name = $_POST["name"];
		    $surname = $_POST["surname"];
		    $position_code = $_POST["position_code"];
		    $person_order = $_POST["person_order"];
		    $department = $_POST["department"];
		    $sub_department = $_POST["sub_department"];
		    $officer = $_POST["post_personid"];
		    if($_POST["position_other_code1"]==1){
		    	$position_other_code = 9999;
		    }elseif($_POST["position_other_code2"]==1){
				$position_other_code = $_POST["sub_department"];
		    }else{
		    	$position_other_code = 0;
		    }
		    
		    $sql = "UPDATE person_main SET prename='$prename',name='$name',surname='$surname',position_code='$position_code',person_order='$person_order',department='$department',sub_department='$sub_department',position_other_code='$position_other_code',officer='$officer' WHERE person_id='".$person_id."'";
			//echo $sql;
			$result = mysqli_query($connect, $sql);
			$bookid = mysqli_insert_id($connect);
			// Upload File
			$target_dir = "./modules/person/picture/";
			$file_no = 0;
         	for($j=0;$j<count($_FILES['UploadedFile']['tmp_name']);$j++) {
				if(!empty($_FILES['UploadedFile']['tmp_name'][$j])) {
					++$file_no;
					$target_file = $target_dir . basename($_FILES["UploadedFile"]["name"][$j]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$rename_file = $target_dir . $person_id . '.' . strtolower($imageFileType);
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
							$sql = "UPDATE person_main SET pic='$rename_file' WHERE person_id='$person_id'";							
							$result = mysqli_query($connect,$sql);
					    } else {
					        //echo "Sorry, there was an error uploading your file.";
					    }
					}
				}//if
			}//for	 
		echo "<script language='javascript'>window.location.href = '?option=person&task=person&page=".$_GET["page"]."'</script>";
	}

	switch ($_GET["action"]) {

		case 'select_clearsearchtext':
			unset($_SESSION["searchtext"]);
			unset($_SESSION["searchdepartmentid"]);
			echo "<script language='javascript'>window.location.href = '?option=person&task=person&page=".$_GET["page"]."'</script>";
			break;

		case 'report1_clearsearchtext':
			unset($_SESSION["searchtext"]);
			unset($_SESSION["searchdepartmentid"]);
			echo "<script language='javascript'>window.location.href = '?option=person&task=person_report1&page=".$_GET["page"]."'</script>";
			break;

		default:
			# code...
			break;
	}

?>