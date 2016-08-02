<?php
include '../../../database_connect.php'; 
include 'function.php'; 

//echo " 555 ".$_POST['fileref_id'];
?>


<?php
//เช็คขนาดไฟล์
$max_size = filesize2bytes(ini_get('upload_max_filesize'));
                        
if($_POST['image_form_submit'] == 1)
{
    $fileref_id=$_POST['fileref_id'];
    
    $filesendtoorg=$_POST['filesendtoorg'];
    
	$images_arr = array();
            if(!empty($_FILES['fileup'])){
	foreach($_FILES['fileup']['name'] as $key=>$val){
		$fileup_name = $_FILES['fileup']['name'][$key];
		$tmp_name 	= $_FILES['fileup']['tmp_name'][$key];
		$size 		= $_FILES['fileup']['size'][$key];
		$type 		= $_FILES['fileup']['type'][$key];
		$error 		= $_FILES['fileup']['error'][$key];
                
                    //เช็คนามสกุลไฟล์  ไม่ตรงก็ให้ผ่านไป
                    if(($type=="image/bmp")||($type=="image/gif")||($type=="image/jpeg")||($type=="image/png")||($type=="image/tiff")
                            ||($type=="application/zip")||($type=="application/x-rar-compressed")||($type=="application/pdf")||($type=="application/msword")
                            ||($type=="application/vnd.ms-excel")||($type=="application/vnd.ms-powerpoint")||($type=="application/rtf")
                            ||($type=="application/octet-stream")||($type=="application/x-zip-compressed")||($type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                            ||($type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")||($type=="application/vnd.openxmlformats-officedocument.presentationml.presentation")||($type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                            ){

                
                        //เช็คขนาดไฟล์ถ้าใหญ่ให้ผ่านไป
                        if($size<$max_size){  
                
                            //เปลี่ยนชื่อ
                           //ฟังก์ชั่นวันที่
                                    date_default_timezone_set('Asia/Bangkok');
                                    $date = date("Ymd");	
                            //ฟังก์ชั่นสุ่มตัวเลข
                                     $numrand = (mt_rand());
 
                            //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
                             $type = strrchr($fileup_name,".");

                            //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
                            $newname = $date.$numrand.$type;

                            
                            
                            
		############ Remove comments if you want to upload and stored images into the "uploads/" folder #############
		
		$target_dir = "../../../uploadsmy/";
		//$target_file = $target_dir.$_FILES['fileup']['name'][$key];
		$target_file = $target_dir.$newname;
		if(move_uploaded_file($_FILES['fileup']['tmp_name'][$key],$target_file)){
			$images_arr[] = $target_file;
                        
		//เพิ่มเข้าฐานข้อมูล
                               // $ii ="INSERT INTO book2_file(book_refid,file_name)VALUES('$fileref_id','$fileup_name')";
		//$strSQL=mysql_query($ii);
                                //echo $ii;
                
                                $sql_insert = "insert into book2_file (id,book_refid,book_table,file_name,file_path,book_to_department,book_to_other,department_id,officer,officer_date,status) values ('',?,'',?,?,?,?,'','','','')";

                                if ($dbquery_insert = $connect->prepare($sql_insert)) {
                                $dbquery_insert->bind_param("sssss",$fileref_id,$fileup_name,$newname,$filesendtoorg,$filesendtoorg);
                                $dbquery_insert->execute();
                                $result_insert=$dbquery_insert->get_result();
                                }
 
                
                
		}
                        }//จบเช็คขนาดไฟล์
                        
                            }//จบเช็คนามสกุลไฟล์
                        	
		//display images without stored
		//$extra_info = getimagesize($_FILES['images']['tmp_name'][$key]);
    	//$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['images']['tmp_name'][$key]));
	}
    $sql_bookfile="SELECT * FROM book2_file where book_refid=? ";
    $query_bookfile = $connect->prepare($sql_bookfile);
    $query_bookfile->bind_param("s", $fileref_id);
    $query_bookfile->execute();
    $result_qbookfile=$query_bookfile->get_result();

	
	//Generate images view
	if(!empty($images_arr)){ $count=0;
	//	foreach($images_arr as $image_src){ $count++?>
		<ul class="reorder_ul reorder-photos-list">
                            แสดงผลไฟล์แนบที่อัพโหลดสำเร็จแล้ว<BR>

<?php
//echo  $count.". ".$image_src[$count]."<br>";

    $j=1;
    $myupload="uploadsmy";
    While ($result_bookfile = mysqli_fetch_array($result_qbookfile))
   {
 ?>
        <div  class="row container table-hover" style='margin-top:10px; '>
       <label><a href="<?php echo $myupload;?>/<?php echo $result_bookfile["file_path"];?>" target="_blank">
                <?php echo $j; ?>. <?php   echo $result_bookfile["file_name"];?>
                </a></label>
        
        </div>                       
        <?php
        $j++;
   }
 
?>
          	</ul>
	<?php
	// }
        }else{
            echo "ไม่มีไฟล์แนบใหม่สำเร็จ กรุณาตรวจสอบไฟล์แนบใหม่<BR>";            
        }
}
}
?>