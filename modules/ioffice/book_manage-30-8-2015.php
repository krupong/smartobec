<?php
	// Define Variable
	if(isset($_POST["searchtext"])){ }else{ $_POST["searchtext"]=""; }
	if(isset($_SESSION["searchtext"])){ }else{ $_SESSION["searchtext"]=""; }
	if(isset($_POST["searchbookstatusid"])){ }else{ $_POST["searchbookstatusid"]=""; }
	if(isset($_SESSION["searchbookstatusid"])){ }else{ $_SESSION["searchbookstatusid"]=""; }
	if(isset($_POST["searchdepartmentid"])){ }else{ $_POST["searchdepartmentid"]=""; }
	if(isset($_SESSION["searchdepartmentid"])){ }else{ $_SESSION["searchdepartmentid"]=""; }
	
	switch ($_GET["action"]) {

		case 'insert':
			$booktypeid = $_POST["booktypeid"];
		    $bookstatusid = $_POST["bookstatusid"];
		    $bookheader = $_POST["bookheader"];
		    $receive_booklevelid = $_POST["receive_booklevelid"];
		    $bookdetail = $_POST["bookdetail"];
		    $post_personid = $_POST["post_personid"];
		    $sql = "INSERT INTO ioffice_book(booktypeid,bookstatusid,bookheader,receive_booklevelid,bookdetail,post_personid)VALUES($booktypeid,$bookstatusid,'$bookheader','$receive_booklevelid','$bookdetail','$post_personid')";
			$result = mysqli_query($connect, $sql);
			$bookid = mysqli_insert_id($connect);
			// Upload File
			$target_dir = "./modules/ioffice/upload/";
			$file_no = 0;
         	for($j=0;$j<count($_FILES['UploadedFile']['tmp_name']);$j++) {
				if(!empty($_FILES['UploadedFile']['tmp_name'][$j])) {
					++$file_no;
					$target_file = $target_dir . basename($_FILES["UploadedFile"]["name"][$j]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$sql = "SELECT COUNT(fileid) AS countfile FROM ioffice_bookfile WHERE bookid=$bookid";
					$result = mysqli_query($connect, $sql);
					$row = mysqli_fetch_assoc($result);
					$fnum = $row["countfile"]+1;
					$rename_file = $target_dir . $bookid . '-' . $fnum . '-' .round(microtime(true)) . '.' . strtolower($imageFileType);
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
					&& $imageFileType != "gif" && $imageFileType != "pdf"  && $imageFileType != "doc" 
					&& $imageFileType != "docs" && $imageFileType != "xls" && $imageFileType != "xlsx" 
					&& $imageFileType != "ppt" && $imageFileType != "pptx" && $imageFileType != "zip" 
					&& $imageFileType != "rar" ) {
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
					        $sql = "INSERT INTO ioffice_bookfile(bookid,filename,filedesc,filetype) VALUE($bookid,'$rename_file','".$_FILES["UploadedFile"]["name"][$j]."','$imageFileType')";
							$result = mysqli_query($connect,$sql);
					    } else {
					        //echo "Sorry, there was an error uploading your file.";
					    }
					}
				}//if
			}//for	   		
			break;

		case 'delete':
			if($_GET["bookid"]) {
				$bookid = $_GET["bookid"];
				$sql = "DELETE FROM ioffice_book WHERE bookid = $bookid";
				$result = mysqli_query($connect, $sql);
			}
			break;

		case 'update_status3':
			if($_GET["bookid"]) {
				$bookid = $_GET["bookid"];
				$sql = "UPDATE ioffice_book SET bookstatusid = 3 WHERE bookid = $bookid";
				$result = mysqli_query($connect, $sql);
			}
			break;

		case 'update':
			if($_POST["bookid"]) {
				$bookid = $_POST["bookid"];
				$booktypeid = $_POST["booktypeid"];
		    	$bookstatusid = $_POST["bookstatusid"];
		    	$bookheader = $_POST["bookheader"];
		    	$receive_booklevelid = $_POST["receive_booklevelid"];
		    	$bookdetail = $_POST["bookdetail"];
				$sql = "UPDATE ioffice_book 
						SET bookstatusid = $bookstatusid, 
							booktypeid = $booktypeid,
							bookheader = '$bookheader',
							receive_booklevelid = '$receive_booklevelid',
							bookdetail = '$bookdetail'
						WHERE bookid = $bookid";
				$result = mysqli_query($connect, $sql);
				// Upload File
				$target_dir = "./modules/ioffice/upload/";
				$file_no = 0;
	         	for($j=0;$j<count($_FILES['UploadedFile']['tmp_name']);$j++) {
					if(!empty($_FILES['UploadedFile']['tmp_name'][$j])) {
						++$file_no;
						$target_file = $target_dir . basename($_FILES["UploadedFile"]["name"][$j]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$sql = "SELECT COUNT(fileid) AS countfile FROM ioffice_bookfile WHERE bookid=$bookid";
						$result = mysqli_query($connect, $sql);
						$row = mysqli_fetch_assoc($result);
						$fnum = $row["countfile"]+1;
						$rename_file = $target_dir . $bookid . '-' . $fnum . '-' .round(microtime(true)) . '.' . strtolower($imageFileType);
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
						&& $imageFileType != "gif" && $imageFileType != "pdf"  && $imageFileType != "doc" 
						&& $imageFileType != "docs" && $imageFileType != "xls" && $imageFileType != "xlsx" 
						&& $imageFileType != "ppt" && $imageFileType != "pptx" && $imageFileType != "zip" 
						&& $imageFileType != "rar" ) {
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
						        $sql = "INSERT INTO ioffice_bookfile(bookid,filename,filedesc,filetype) VALUE($bookid,'$rename_file','".$_FILES["UploadedFile"]["name"][$j]."','$imageFileType')";
								$result = mysqli_query($connect,$sql);
						    } else {
						        //echo "Sorry, there was an error uploading your file.";
						    }
						}
					}//if
				}//for
			}
			break;

		case 'copy':
			if($_GET["bookid"]) {
				$bookid = $_GET["bookid"];
				// Copy book
				$sql = "SELECT * FROM ioffice_book WHERE bookid = $bookid";
				//echo $sql;
				if ($result = mysqli_query($connect, $sql)) {
	                while ($row = $result->fetch_assoc()) {
	                	$booktypeid = $row["booktypeid"];
	                	$bookstatusid = 1;
			    		$bookheader = $row["bookheader"];
			    		$receive_booklevelid = $row["receive_booklevelid"];
			    		$bookdetail = $row["bookdetail"];
			    		$post_personid = $row["post_personid"];
	                }
	                // free result set
	                mysqli_free_result($result);
	                $sql = "INSERT INTO ioffice_book(booktypeid,bookstatusid,bookheader,receive_booklevelid,bookdetail,post_personid) VALUES($booktypeid,$bookstatusid,'$bookheader','$receive_booklevelid','$bookdetail','$post_personid')";
					//echo $sql;
					$result = mysqli_query($connect, $sql);
					$insertid = mysqli_insert_id($connect);
				}		
				// Copy File
				$sqlfile = "SELECT * FROM ioffice_bookfile WHERE bookid = $bookid";
				if ($resultfile = mysqli_query($connect, $sqlfile)) {
					while ($rowfile = $resultfile->fetch_assoc()) {
						$sqlinsert = "INSERT INTO ioffice_bookfile(bookid,filename,filedesc,filetype) 
							VALUE($insertid,'".$rowfile["filename"]."','".$rowfile["filedesc"]."','".$rowfile["filetype"]."')";
						//echo $sqlinsert."<br>";
						$resultinsert = mysqli_query($connect, $sqlinsert);		
					}					
	            }
			}
			break;

		case 'comment':
			if($_POST["bookid"]) {
				$bookid = $_POST["bookid"];
				$bookstatusid = $_POST["bookstatusid"];
				$comment_personid = $_SESSION['login_user_id'];
				$commentdetail = $_POST["commentdetail"];
				$department = $_POST["department"];
				$sub_department = $_POST["sub_department"];
				$person = $_POST["person"];
				$consultdetail = $_POST["consultdetail"];
				switch ($bookstatusid) {
					case '4':
						$sql = "INSERT INTO ioffice_bookcomment(bookid,bookstatusid,comment_personid,commentdetail) VALUES($bookid,$bookstatusid,'$comment_personid','$consultdetail')";
						$result = mysqli_query($connect, $sql);
						if($_POST["department"]){
							$sql = "UPDATE ioffice_book SET consult_departmentid = $department WHERE bookid = $bookid";
							$result = mysqli_query($connect, $sql);	
						}
						if($_POST["sub_department"]){
							$sql = "UPDATE ioffice_book SET consult_subdepartmentid = $sub_department WHERE bookid = $bookid";
							$result = mysqli_query($connect, $sql);	
						}
						if($_POST["person"]){
							$sql = "UPDATE ioffice_book SET consult_personid = '$person' WHERE bookid = $bookid";
							$result = mysqli_query($connect, $sql);	
						}
						break;
					default:
						$sql = "INSERT INTO ioffice_bookcomment(bookid,bookstatusid,comment_personid,commentdetail) VALUES($bookid,$bookstatusid,'$comment_personid','$commentdetail')";
						$result = mysqli_query($connect, $sql);
						$sql = "UPDATE ioffice_book SET consult_personid = null,consult_subdepartmentid = null,consult_departmentid = null WHERE bookid = $bookid";
						$result = mysqli_query($connect, $sql);
						break;
				}
				//echo $sql;
			}
			break;

		case 'trashfile':
			if($_GET["fileid"]) {
				$fileid = $_GET["fileid"];
				$sql = "DELETE FROM ioffice_bookfile WHERE fileid = $fileid";
				$result = mysqli_query($connect, $sql);
			}
			break;

		case 'select_clearsearchtext':
			unset($_SESSION["searchtext"]);
			unset($_SESSION["searchbookstatusid"]);
			break;

		case 'pass_clearsearchtext':
			unset($_SESSION["searchtext"]);
			unset($_SESSION["searchbookstatusid"]);
			break;

		case 'search_clearsearchtext':
			unset($_SESSION["searchtext"]);
			unset($_SESSION["searchbookstatusid"]);
			unset($_SESSION["searchdepartmentid"]);
			break;

		case 'bookpass_clearsearchtext':
			unset($_SESSION["searchtext"]);
			break;

		case 'bookpass':
			if($_POST["personid"]){
				$personid = $_POST["personid"];
				$departmentid = $_POST["departmentid"];
				$sql="DELETE FROM ioffice_bookpass WHERE personid='".$personid."'"; 
				$result = mysqli_query($connect, $sql);
				if(count($departmentid)>0){  // ตรวจสอบ checkbox ว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่  
			    	foreach($departmentid as $key=>$value){  
			        // แสดงชุดข้อมูล ที่สอดคล้องกับ checkbox   
			        	//echo $departmentid[$key]."<br>";  
			        	$sqlinsert = "INSERT INTO ioffice_bookpass(departmentid,personid) VALUES(".$departmentid[$key].",'".$personid."')";
			        	//echo "<br><br><br><br><br>".$sqlinsert;
			        	$resultinsert = mysqli_query($connect, $sqlinsert);
			    	}     
				} 

			}
			break;

		default:
			# code...
			break;
	}

    // Redirect to Book Show;
    // Comment this next line to debug program
    
    switch ($_GET["action"]) {

    	case 'comment':
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_pass'</script>";
    		break;

    	case 'trashfile':
    		echo "<script language='javascript'>history.go(-1);</script>";
    		break;   

    	case 'select_clearsearchtext':
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_select'</script>";
    		break; 

    	case 'pass_clearsearchtext':
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_pass'</script>";
    		break; 

		case 'search_clearsearchtext':
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_search'</script>";
    		break; 

    	case 'bookpass_clearsearchtext':
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_bookpass'</script>";
    		break; 

    	case 'bookpass':
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_bookpass'</script>";
    		break; 

    	default:
    		echo "<script language='javascript'>window.location.href = '?option=ioffice&task=book_select'</script>";
    		break;
    }
?>