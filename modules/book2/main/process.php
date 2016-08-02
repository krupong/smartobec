<?php
include '../../../database_connect.php';
include 'function.php'; 

//create object
$process = new Database2();

	//Add_user
	if(isset($_POST['send_name'])){
		//รับข้อมูลจาก FORM ส่งไปที่ Method add_user
		$process->add_user($_POST);
	}
	
	//show edit data form
	if(isset($_POST['show_user_id'])){
		
		$edit_user = $process->get_user($_POST['show_user_id']);

		echo'<form id="edit_user_form">
			  <div class="form-group">
				<label >ชื่อ - สกุล</label>
				<input type="text" class="form-control" name="edit_name" value="'.$edit_user['name'].'">
			  </div>
			  <div class="form-group">
				<label >เบอร์โทรศัพท์</label>
				<input type="text" class="form-control" name="edit_tel" value="'.$edit_user['tel'].'">
			  </div>
			  <input type="hidden" name="edit_user_id" value="'.$edit_user['id'].'" >
			</form>';
	}
	
	//edit user 
	if(isset($_POST['edit_user_id'])){
		
		$process->edit_user($_POST);
		
	}
	
	//delete ไฟล์แนบ
	if(isset($_POST['delete_fileupload_id'])){
		
		$process->delete_fileupload($_POST['delete_fileupload_id']);
	}
	
	//ส่งหนังสือราชการ
	if(isset($_POST['sendtrue_addbook_ref']) && isset($_POST['senderrole']) && isset($_POST['sender_officer']) ){
		
		$process->sendtrue_addbook($_POST['sendtrue_addbook_ref'],$_POST['senderrole'],$_POST['sender_officer']);
	}

 	//ส่งหนังสือราชการ
	if(isset($_POST['book_refid'])){
		
		$process->detailbook($_POST['book_refid']);
	}
        
 	//เพิ่มหน่วยงาน
	if(isset($_POST['name'])){
		//รับข้อมูลจาก FORM ส่งไปที่ Method add_department
		$process->add_department($_POST);
	}

 	//เพิ่ม Session
	if(isset($_POST['session_roleid_person'])){
		//รับข้อมูลจาก FORM ส่งไปที่ Method Session
		$process->session_roleid_person($_POST['session_roleid_person']);
	}
        
?>