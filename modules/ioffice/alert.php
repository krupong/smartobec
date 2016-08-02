<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

// ส่วนในการตรวจสอบงานค้าง
if(!isset($_SESSION['login_user_id'])) { $_SESSION['login_user_id']=''; }

// Select Book
$sql_alert = "  SELECT 
                        count(*) as count  
                      FROM
                        ioffice_book
                      WHERE ioffice_book.bookstatusid = 2 and 
                            bookid IN(select bookid from ioffice_bookcomment where comment_personid=".$_SESSION['login_user_id']." and bookstatusid=2) 
                      ORDER BY booktypeid DESC, bookid ASC";
//echo $sql_alert;
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();

// ข้อความที่ต้องการแจ้งเตือน
$message = "";
$count = "";
$alertmessage = "";
if($row_alert["count"]>0){
	$message = "ตรวจแฟ้มใหม่(บันทึกข้อความ)";
	$count = $row_alert["count"];
	$alertmessage = "<li><a href='?option=ioffice&task=book_pass'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span>&nbsp;:&nbsp;".$message." <span class='badge progress-bar-danger'>".$row_alert["count"]."</span></a></li>";
}

?>