<?php

//แปลงวันที่บันทึกใน DB
function dateinput2db($datex) {
	$date_array=explode("-",$datex);
	$y=$date_array[2];
	$m=$date_array[1];
	$d=$date_array[0];
	$displaydate="$y-$m-$d";
	return $displaydate;
}

//แปลงวันที่จาก DB มาแสดงผล
function datesql2show($datex) {
	$date_array=explode("-",$datex);
	$y=$date_array[0];
	$m=$date_array[1];
	$d=$date_array[2];
	$displaydate="$d-$m-$y";
	return $displaydate;
}

//แปลงขนาดไฟล์หน่วยเป็น bytes
function filesize2bytes($str) { 
    $bytes = 0; 

    $bytes_array = array( 
        'B' => 1, 
        'K' => 1024, 
        'M' => 1024 * 1024, 
        'G' => 1024 * 1024 * 1024, 
        'T' => 1024 * 1024 * 1024 * 1024, 
        'P' => 1024 * 1024 * 1024 * 1024 * 1024, 
    ); 

    $bytes = floatval($str); 

    if (preg_match('#([KMGTP]?)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) { 
        $bytes *= $bytes_array[$matches[1]]; 
    } 

    $bytes = intval(round($bytes, 2)); 

    return $bytes; 
} 

//แปลงวันที่ พ.ศ.สั้น
function yeareng2thshort($yeareng) {
    $yearthai=$yeareng+543;
    $displayyearthshort=substr($yearthai, 2, 2);
    return $displayyearthshort;
}
//แปลงวันที่ พ.ศ.ยาว
function yeareng2thlong($yeareng) {
    $yearthai=$yeareng+543;
    //$displayyearthshort=substr($yearthai, 2, 2);
    return $yearthai;
}

function datedbeng2thaishort($num){     
    $date_array=explode("-",$num);
    $y=$date_array[0];
    $m=$date_array[1];
    $d=$date_array[2];
    if(strlent($y)>2){
    $date_array=explode("-",$num);
    $y=$date_array[2];
    $m=$date_array[1];
    $d=$date_array[0];   
    }
    
    $mlong=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");     
    $mshort=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");     
    $yearthai=$y+543;
    $yearthaishort=substr($yearthai, 2, 2);

    $ii=0;     
    for($i=$lenNumber2;$i>=0;$i--){     
        $kaNumWord[$i]=substr($num,$ii,1);     
        $ii++;     
    }     
    $ii=0;     
    for($i=$lenNumber2;$i>=0;$i--){     
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){     
            $kaDigit[$kaNumWord[$i]]="ยี่";     
        }else{     
            if($kaNumWord[$i]==2){     
                $kaDigit[$kaNumWord[$i]]="สอง";          
            }     
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){     
                if($kaNumWord[$i+1]==0){     
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";        
                }else{     
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";         
                }     
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){     
                $kaDigit[$kaNumWord[$i]]="";     
            }else{     
                if($kaNumWord[$i]==1){     
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";     
                }     
            }     
        }     
        if($kaNumWord[$i]==0){     
            if($i!=6){  
                $kaGroup[$i]="";     
            }  
        }     
        $kaNumWord[$i]=substr($num,$ii,1);     
        $ii++;     
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];     
    }        
    if(isset($num_decimal[1])){  
        $returnNumWord.="จุด";  
        for($i=0;$i<strlen($num_decimal[1]);$i++){  
                $returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];    
        }  
    }         
    return $returnNumWord;     
}     


?>

<?php


class Database2 {
   
	
	//function เรื่ยกดูข้อมูล all user
	public function get_all_user(){
		
		$db = $this->connect();
		$get_user = $db->query("SELECT * FROM user");
		
		while($user = $get_user->fetch_assoc()){
			$result[] = $user;
		}
		
		if(!empty($result)){
			
			return $result;
		}
	}
	
	public function search_user($post = null){
		
		$db = $this->connect();
		$get_user = $db->query("SELECT * FROM user WHERE name LIKE '%".$post."%' ");
		
		while($user = $get_user->fetch_assoc()){
			$result[] = $user;
		}
		
		if(!empty($result)){
			
			return $result;
		}
		
	}
	
	public function get_user($user_id){
		
		$db = $this->connect();
		$get_user = $db->prepare("SELECT id,name,tel FROM user WHERE id = ?");
		$get_user->bind_param('i',$user_id);
		$get_user->execute();
		$get_user->bind_result($id,$name,$tel);
		$get_user->fetch();
		
		$result = array(
			'id'=>$id,
			'name'=>$name,
			'tel'=>$tel
		);
		
		return $result;
	}
	
	//function เพื่ม user
	public function add_user($data){
		
		$db = $this->connect();
		
		$add_user = $db->prepare("INSERT INTO user (id,name,tel) VALUES(NULL,?,?) ");
		
		$add_user->bind_param("ss",$data['send_name'],$data['send_tel']);
		
		if(!$add_user->execute()){
			
			echo $db->error;
			
		}else{
			
			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}
	
	//function edit user
	public function edit_user($data){
		
		$db = $this->connect();
		
		$add_user = $db->prepare("UPDATE user SET name = ? , tel = ? WHERE id = ?");
		
		$add_user->bind_param("ssi",$data['edit_name'],$data['edit_tel'],$data['edit_user_id']);
		
		if(!$add_user->execute()){
			
			echo $db->error;
			
		}else{
			
			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}
	
	//function ลบไฟล์แนบ
	public function delete_fileupload($id){
		
                                include '../../../database_connect.php';
		//$db = $this->connect();
		    $sql_bookfile="SELECT * FROM book2_file where id=? ";
                                    $query_bookfile = $connect->prepare($sql_bookfile);
                                    $query_bookfile->bind_param("i", $id);
                                    $query_bookfile->execute();
                                    $result_qbookfile=$query_bookfile->get_result();
                                        While ($result_bookfile = mysqli_fetch_array($result_qbookfile))
                                       {
                                           $delfileupload="../../../uploadsmy/".$result_bookfile["file_path"];  
                                       }
                                
		$del_fileupload = $connect->prepare("DELETE  FROM book2_file WHERE id = ?");
		
		$del_fileupload->bind_param("i",$id);
		
		if(!$del_fileupload->execute()){
			
			echo $connect->error;
			
		}else{
                                            //หาไฟล์ว่ามีรึเปล่า
                                            if( file_exists($delfileupload) )
                                                {
                                                //echo "มีไฟล์";
                                                //ลบไฟล์
                                                unlink($delfileupload);
                                                }else{echo "ไม่มีไฟล์ ";}
			echo "ลบข้อมูลเรียบร้อย";
		}
	}
	
	//function ส่งหนังสือราชการ
	public function sendtrue_addbook($refid,$senderrole,$officer){
                                
                        $todaydatetime=date("Y-m-d H:i:s");
                        $todayyear=date("Y");
                        
                        
                                include '../../../database_connect.php';
		//$db = $this->connect();
                        //$refid=$id;
        
                //หาบทบาท
                    $sql_roleperson="select * from book2_roleperson  where person_id=? and id=? and status=1 ";
                    $query_roleperson = $connect->prepare($sql_roleperson);
                    $query_roleperson->bind_param("ss", $officer,$senderrole);
                    $query_roleperson->execute();
                    $result_qroleperson=$query_roleperson->get_result();

                    While ($result_roleperson = mysqli_fetch_array($result_qroleperson))
                   {    
                        $level_dep=$result_roleperson['level_dep'];
                        $look_dep_subdep=$result_roleperson['look_dep_subdep'];
                        $role_id=$result_roleperson['role_id'];
                        $role_orgtb=$result_roleperson['orgtb'];
                   }     

                    if($role_orgtb=='D'){
                        $searchorg="book2_department";
                    }else{
                        $searchorg="book2_subdepartment";            
                    }
                              
                        //แสดงหน่วยงานที่ส่งหนังสือ
                            $sql_booksend="select * from book2_send where book_refid=? ";
                            $query_booksend = $connect->prepare($sql_booksend);
                            $query_booksend->bind_param("s", $refid);
                            $query_booksend->execute();
                            $result_qbooksend=$query_booksend->get_result();
                            
                         While ($result_booksend = mysqli_fetch_array($result_qbooksend))
                           {
                                $booksend_to_department=$result_booksend['book_to_department'];
                           }

                           //แยกหน่วยงานเก็บใน Array
                                $f_booksend_to_department=explode(",", $booksend_to_department);
                                $countbooksend_to_department=  count($f_booksend_to_department);
                        //book2_type  ประเภทหนังสือส่ง
                           $booktype="2";
                        //นับทะเบียนหนังสือส่ง                       
                        $sql_bookno="select * from book2_numbook where typebook_id=? and department_id=? and no_year=? ";
                        $query_bookno = $connect->prepare($sql_bookno);
                        $query_bookno->bind_param("iss",$booktype,$look_dep_subdep,$todayyear);
                        $query_bookno->execute();
                        $result_qbookno=$query_bookno->get_result();

                     While ($result_bookno = mysqli_fetch_array($result_qbookno))
                       {
                         $bookno=$result_bookno['no_present']+1;
                       }

                                //ส่งทีละหน่วยงาน
                               $j=0;
                                for($i=0;$i<$countbooksend_to_department;$i++)
                               {
                                    $sendidorg=$f_booksend_to_department[$i];
                       //แสดงหน่วยงานที่ส่งหนังสือ
                            $sql_booksend="select * from book2_department where id=? ";
                            $query_booksend = $connect->prepare($sql_booksend);
                            $query_booksend->bind_param("s", $sendidorg);
                            $query_booksend->execute();
                            $result_qbooksend=$query_booksend->get_result();
                            
                         While ($result_booksend = mysqli_fetch_array($result_qbooksend))
                           {
                                $booksend_to_departgroupcode=$result_booksend['groupcode'];
                           }
                           
                                //นำเข้าฐานข้อมูล ส่งเข้า book2_system   
                                $sql_insert = "insert into book2_system"
                                        . " (id,book_refid,send_year,sender_department,sender_role,sender_officer,sender_date"
                                        . ",sender_no,receiver_group,receiver_department,receiver_officer,receiver_role,receiver_date"
                                        . ",receiver_no,receiver_year,receiver_status,receiver_comment,receiver_otherdate,book_type)"
                                        . " values ('',?,?,?,?,?,?,?,?,?,'','','','','','0','','',?)";

                               if ($dbquery_insert = $connect->prepare($sql_insert)) {
                               $dbquery_insert->bind_param("ssssssssss",$refid,$todayyear,$look_dep_subdep,$role_id,$officer,$todaydatetime
                                       ,$bookno,$booksend_to_departgroupcode,$sendidorg,$booktype);
                               $dbquery_insert->execute();
                               $result_insert=$dbquery_insert->get_result();
                               }
                                    
                               }

                    // อัพเดต สถานะหนังสือ    
                    $sql_booksendupdate = "update book2_send set book_status='8' where book_refid=?  ";
                   if ($dbquery_booksendupdate = $connect->prepare($sql_booksendupdate)) {
                   $dbquery_booksendupdate->bind_param("s",$refid);
                   $dbquery_booksendupdate->execute();
                   $result_booksendupdate=$dbquery_booksendupdate->get_result();
                   }
                                              
                echo "ส่งหนังสือราชการเรียบร้อยแล้ว";
                                

                }	
	
	//function ลบไฟล์แนบ
	public function detailbook($book_refid){
		
                                include '../../../database_connect.php';
		//$db = $this->connect();
		    $sql_bookfile="SELECT * FROM book2_file where id=? ";
                                    $query_bookfile = $connect->prepare($sql_bookfile);
                                    $query_bookfile->bind_param("i", $id);
                                    $query_bookfile->execute();
                                    $result_qbookfile=$query_bookfile->get_result();
                                        While ($result_bookfile = mysqli_fetch_array($result_qbookfile))
                                       {
                                           $delfileupload="../../../uploadsmy/".$result_bookfile["file_path"];  
                                       }
                                
		$del_fileupload = $connect->prepare("DELETE  FROM book2_file WHERE id = ?");
		
		$del_fileupload->bind_param("i",$id);
		
		if(!$del_fileupload->execute()){
			
			echo $connect->error;
			
		}else{
                                            //หาไฟล์ว่ามีรึเปล่า
                                            if( file_exists($delfileupload) )
                                                {
                                                //echo "มีไฟล์";
                                                //ลบไฟล์
                                                unlink($delfileupload);
                                                }else{echo "ไม่มีไฟล์ ";}
			echo "ลบข้อมูลเรียบร้อย";
		}
	}

	//function เพื่ม หน่วยงาน
	public function add_department($data){
		
                                include '../../../database_connect.php';
                                $todaydatetime=date("Y-m-d H:i:s");
		
		$add_department = $db->prepare("INSERT INTO book2_department (id,name,nameprecis,namelongprecis,look,sendlook,receivelook,sendmain,receivemain,send,receive,status,officer,officer_date) VALUES(NULL,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		
		$add_department->bind_param("ssssiiiiiiiis",$data['name'],$data['nameprecis'],$data['namelongprecis'],$data['look'],$data['sendlook'],$data['receivelook'],$data['sendmain'],$data['receivemain'],$data['send'],$data['receive'],$data['officer'],$todaydatetime);
		
		if(!$add_department->execute()){
			
			echo $db->error;
			
		}else{
			
			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}

	//function เพื่ม Session
	public function session_roleid_person($session_roleid_person){
                                session_start();		
                                unset($_SESSION["roleid_person"]); // ลบSession role_id
                                unset($_SESSION["role_name"]); // ลบSession role_name
                                unset($_SESSION["role_iddepart"]); // ลบSession role_iddepart
                                unset($_SESSION["role_namedepart"]); // ลบSession role_namedepart
                                unset($_SESSION["role_id"]); // ลบSession role_namedepart

                            $_SESSION["roleid_person"] = $session_roleid_person;
                                
                               include '../../../database_connect.php';
                            //แสดงชื่อบทบาท
                            $sql_roleid="select * from book2_roleperson where id=? ";
                            $query_roleid = $connect->prepare($sql_roleid);
                            $query_roleid->bind_param("i", $session_roleid_person);
                            $query_roleid->execute();
                            $result_qroleid=$query_roleid->get_result();
                            
                         While ($result_roleid = mysqli_fetch_array($result_qroleid))
                           {
                                $role_id=$result_roleid['role_id'];
                                $level_dep=$result_roleid['level_dep'];
                                $look_dep_subdep=$result_roleid['look_dep_subdep'];
                           }
                            //แสดงชื่อบทบาท
                            $sql_role="select * from book2_role where id=? ";
                            $query_role = $connect->prepare($sql_role);
                            $query_role->bind_param("i", $role_id);
                            $query_role->execute();
                            $result_qrole=$query_role->get_result();
                            
                         While ($result_role = mysqli_fetch_array($result_qrole))
                           {
                                $namerole=$result_role['name'];
                           }
                           $_SESSION["role_id"] = $role_id;
                           $_SESSION["role_name"] = $namerole;

                           
                        if($level_dep=='2' || $level_dep=='4' || $level_dep>='6' && $level_dep<='12' ){
                            $searchorg="book2_department";
                        }else{
                            $searchorg="book2_subdepartment";            
                        }
                           
                        //หาชื่อหน่วยงาน
                            $sql_dep="select * from $searchorg  where id=?  ";
                            $query_dep = $connect->prepare($sql_dep);
                            $query_dep->bind_param("i", $look_dep_subdep);
                            $query_dep->execute();
                            $result_qdep=$query_dep->get_result();

                            While ($result_dep = mysqli_fetch_array($result_qdep))
                           {
                               $name_predepart=$result_dep['nameprecis'];
                           }
                           $_SESSION["role_iddepart"] = $look_dep_subdep;
                           $_SESSION["role_namedepart"] = $name_predepart;
                            
                        echo "เปลี่ยน Session เรียบร้อย";
	}
        
}
?>