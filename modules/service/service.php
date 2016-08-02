<?php
class amss {
    private $db;
    // constructor
    
    function connect(){
        include('../../database_connect.php');
        return $connect;
    }
    
    function getLogin($username,$pw) {
        $connect = $this->connect();
        $sql = "SELECT system_user.*,person_main.* FROM system_user LEFT JOIN person_main ON system_user.person_id=person_main.person_id WHERE (username=?) and (userpass=md5(?))";
        $query = $connect->prepare($sql);
        $query->bind_param("ss",$username,$pw);
        $query->execute();
        $results = $query->get_result();
        $arr = array();
        while($result = $results->fetch_array())
             {
            $arr['id']=$result['person_id'];
            $arr['user']=$result['username'];
            $arr['realname']=$result['prename'].$result['name']." ".$result['surname'];
            $arr['result']="OK";
            $arr['utype']="0";
        }
        
        if (!$arr['id']) {
        $connect = $this->connect();
        $sql = "SELECT system_user.*,person_khet_main.* FROM system_user LEFT JOIN person_khet_main ON system_user.person_id=person_khet_main.person_id WHERE (username=?) and (userpass=md5(?))";
        $query = $connect->prepare($sql);
        $query->bind_param("ss",$username,$pw);
        $query->execute();
        $results = $query->get_result();
        $arr = array();
        while($result = $results->fetch_array())
             {
            $arr['id']=$result['person_id'];
            $arr['user']=$result['username'];
            $arr['realname']=$result['prename'].$result['name']." ".$result['surname'];
            $arr['result']="OK";
            $arr['utype']="1";
        }           
        }
        return json_encode($arr);
    }

    function doLogout($gcm_regid) {
        $connect = $this->connect();
        $sql = "DELETE FROM smartpush where (gcm_regid=?)";
        $query = $connect->prepare($sql);
        $query->bind_param("s",$gcm_regid);
        $query->execute();
        $results = $query->get_result();
        $sql = "SELECT * FROM smartpush where (gcm_regid=?)";
        $query = $connect->prepare($sql);
        $query->bind_param("s",$gcm_regid);
        $query->execute();
        $results = $query->get_result();
        $numrows = $results->num_rows;
        return json_encode(array('result'=>'OK'));
    }
    
    function getPush($uid) {
        $connect = $this->connect();
        $sql = "SELECT * FROM smartpush_temp WHERE gcm_id=? ORDER BY id DESC";
        $query = $connect->prepare($sql);
        $query->bind_param("s",$uid);
        $query->execute();
        $results = $query->get_result();
        $numrows = $results->num_rows;
        $i = 0;
        while($e = $results->fetch_array()) {
            $model[$i]['id']         = $e['id'];
            $model[$i]['department']  = $e['department'];
            $model[$i]['message']     = $e['message'];
            $model[$i]['title']       = $e['title'];
            $i++;
        }
           // $model['result']="OK";
        return json_encode(array('pushs'=>$model,'badge'=>$numrows,'res'=>'OK'));
    }

    function delItem($item) {
        $connect = $this->connect();
        $sql = "DELETE FROM smartpush_temp WHERE id=?";
        $query = $connect->prepare($sql);
        $query->bind_param("i",$item);
        $query->execute();
        $results = $query->get_result();
        if ($results) {
        return json_encode(array('res'=>'OK'));
        } else {
            return json_encode(array('res'=>'Fail'));
        }
    }
    
    function pushSet($gcm_regid,$gcm_id,$push_module,$mode) {
        $connect = $this->connect();
        switch ($mode) {
            case 'delete':
                $sql = "DELETE FROM smartpush_module where (gcm_regid=?)";
                $query = $connect->prepare($sql);
                $query->bind_param("s",$gcm_regid);
                break;
            case 'insert':
                $sql = "INSERT INTO smartpush_module (gcm_regid,gcm_id,push_module) VALUES(?,?,?)";
                $query = $connect->prepare($sql);
                $query->bind_param("sss",$gcm_regid,$gcm_id,$push_module);
                break;
            case 'update':
                $sql = "UPDATE smartpush_module SET gcm_regid=?,gcm_id=?,push_module=? WHERE gcm_regid=?";
                $query = $connect->prepare($sql);
                $query->bind_param("ssss",$gcm_regid,$gcm_id,$push_module,$gcm_regid);
                break;
        }
        $query->execute();
        $results = $query->get_result();
        return json_encode(array('result'=>'OK'));
    }
    
    
    public function doAlert($userid,$module) {
    ///////////////////////////////////// alert Meeting ///////////////////////
        $connect = $this->connect();
        switch ($module) {
            case 'bookregister':
                break;  // bookregister
            case 'book':
                $login_user_id=mysqli_real_escape_string($connect,$userid);
                $row = array();
                //หาสิทธิ์
                    $sql_user_permis="select * from book_permission where person_id=? ";
                    $query_user_permis = $connect->prepare($sql_user_permis);
                    $query_user_permis->bind_param("i", $login_user_id);
                    $query_user_permis->execute();
                    $result_quser_permis=$query_user_permis->get_result();
                While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
                   {
                    $user_permission_p1=$result_user_permis['p1'];
                    $user_permission_p2=$result_user_permis['p2'];
                    $user_permission_p3=$result_user_permis['p3'];
                    $user_permission_p4=$result_user_permis['p4'];
                    }
                 if(!isset($user_permission_p1)){
                $user_permission_p1="";
                }
                 if(!isset($user_permission_p2)){
                $user_permission_p2="";
                }
                 if(!isset($user_permission_p3)){
                $user_permission_p3="";
                }
                 if(!isset($user_permission_p4)){
                $user_permission_p4="";
                }
                //echo " 555 ".$user_permission;

                $message = "";
                $count = "";
                $alertmessage = "";

                //เช็คสิทธิ์ก่อน สารบรรณกลาง สพฐ    
                if($user_permission_p1 == 1){    
                    $sql_saraban_index1="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='saraban' and book_sendto_answer.answer IS NULL";   

                    $result_alert1 = mysqli_query($connect, $sql_saraban_index1);
                    $row_alert1 = $result_alert1->fetch_assoc();
                    

                // ข้อความที่ต้องการแจ้งเตือน
                if($row_alert1["count"]>0){
                      $message = "หนังสือราชการไม่ได้ลงรับ(สพฐ.)";
                      $count = $row_alert1["count"]+$count;
                      $alertmessage = "<li><a href='?option=book&task=main/receive&saraban_index=1'>".$message." <span class='badge progress-bar-danger'>".$row_alert1['count']."</span></a></li>";    
                }
                    // mobile alert;
                    $sql_alrt_1="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='saraban' and book_sendto_answer.answer IS NULL";    
                    $result_alert2 = mysqli_query($connect, $sql_alrt_1);
                    while ($rows = $result_alert2->fetch_assoc()) {
                        $row[] = $rows;  
                    }
                }

                //เช็คสิทธิ์ก่อน สารบรรณสำนัก    
                if($user_permission_p2 != 0 || $user_permission_p2 !="" ){    
                    $sql_saraban_index2="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p2' and book_sendto_answer.answer IS NULL  ";   

                    $result_alert2 = mysqli_query($connect, $sql_saraban_index2);
                    $row_alert2 = $result_alert2->fetch_assoc();
                

                // ข้อความที่ต้องการแจ้งเตือน
                if($row_alert2["count"]>0){
                      $message = "หนังสือราชการไม่ได้ลงรับ(สำนัก)";
                      $count = $row_alert2["count"]+$count;
                    //$countshow = $count-$countshow ;
                    //$countget = $count;
                    $alertmessage .= "<li><a href='?option=book&task=main/receive&saraban_index=2'>".$message." <span class='badge progress-bar-danger'>".$row_alert2['count']."</span></a></li>";    
                }    
                    // mobile alert;
                    $sql_alrt_1="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p2' and book_sendto_answer.answer IS NULL";    
                    $result_alert2 = mysqli_query($connect, $sql_alrt_1);
                    while ($rows = $result_alert2->fetch_assoc()) {
                        $row[] = $rows;  
                    }
                }

                //เช็คสิทธิ์ก่อน สารบรรณกลุ่ม    
                if($user_permission_p3 != 0 || $user_permission_p3 !="" ){    
                    $sql_saraban_index3="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p3' and book_sendto_answer.answer IS NULL  ";   

                    $result_alert3 = mysqli_query($connect, $sql_saraban_index3);
                    $row_alert3 = $result_alert3->fetch_assoc();

                // ข้อความที่ต้องการแจ้งเตือน
                if($row_alert3["count"]>0){
                      $message = "หนังสือราชการไม่ได้ลงรับ(กลุ่ม)";
                      $count = $row_alert3["count"]+$count;
                    //$countshow = $count-$countshow ;
                    $alertmessage .= "<li><a href='?option=book&task=main/receive&saraban_index=3'>".$message." <span class='badge progress-bar-danger'>".$row_alert3['count']."</span></a></li>";    
                }
                    // mobile alert;
                    $sql_alrt_1="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p3' and book_sendto_answer.answer IS NULL";    
                    $result_alert2 = mysqli_query($connect, $sql_alrt_1);
                    while ($rows = $result_alert2->fetch_assoc()) {
                        $row[] = $rows;  
                    }
                }

                //เช็คสิทธิ์ก่อน สารบรรณบุคคล    
                if($login_user_id != 0 || $login_user_id  !=""  ){    
                    $sql_saraban_index4="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$login_user_id' and book_sendto_answer.answer IS NULL  ";   

                    $result_alert4 = mysqli_query($connect, $sql_saraban_index4);
                    $row_alert4 = $result_alert4->fetch_assoc();

                    // ข้อความที่ต้องการแจ้งเตือน
                    if($row_alert4["count"]>0){
                          $message = "หนังสือราชการไม่ได้ลงรับ(บุคคล)";
                          $count = $row_alert4["count"]+$count;
                        $alertmessage .= "<li><a href='?option=book&task=main/receive&saraban_index=4'>".$message." <span class='badge progress-bar-danger'>".$row_alert4['count']."</span></a></li>";    
                    }
                    // mobile alert;
                    $sql_alrt_1="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$login_user_id' and book_sendto_answer.answer IS NULL ";    
                    $result_alert2 = mysqli_query($connect, $sql_alrt_1);
                    while ($rows = $result_alert2->fetch_assoc()) {
                        $row[] = $rows;  
                    }
                }
                
                    // กรณีเป็นผู้ใช้งานระดับ เขตพื้นที่
//                if($_SESSION["login_group"]==2){

                //หาสิทธิ์
                    $sql_user_permis="select * from book_permission where person_id=? ";
                    $query_user_permis = $connect->prepare($sql_user_permis);
                    $query_user_permis->bind_param("i", $login_user_id);
                    $query_user_permis->execute();
                    $result_quser_permis=$query_user_permis->get_result();
                While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
                   {
                    $user_permission_p4=$result_user_permis['p4'];
                    }
                 if(!isset($user_permission_p4)){
                $user_permission_p4="";
                }

                $message = "";
                $count = "";
                $alertmessage = "";

                //เช็คสิทธิ์ก่อน สารบรรณกลาง เขตพื้นที่    
                if($$user_permission_p4 != 0 || $user_permission_p4 !="" ){    
                    $sql_saraban_index4="select count(book_main.ms_id) as count from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p4' and book_sendto_answer.answer IS NULL";   

                    $result_alert4 = mysqli_query($connect, $sql_saraban_index4);
                    $row_alert4 = $result_alert4->fetch_assoc();

                // ข้อความที่ต้องการแจ้งเตือน
                if($row_alert4["count"]>0){
                      $message = "หนังสือราชการไม่ได้ลงรับ";
                      $count = $row_alert4["count"];
                      $alertmessage = "<li><a href='?option=book&task=main/receive_in'>".$message." <span class='badge progress-bar-danger'>".$row_alert4['count']."</span></a></li>";    
                }
                    // mobile alert;
                    $sql_alrt_1="select * from book_main, book_sendto_answer where book_main.ref_id=book_sendto_answer.ref_id and  book_sendto_answer.send_to='$user_permission_p4' and book_sendto_answer.answer IS NULL ORDER BY book_sendto_answer.id DESC";    
                    $result_alert2 = mysqli_query($connect, $sql_alrt_1);
                    while ($rows = $result_alert2->fetch_assoc()) {
                        $row[] = $rows;  
                    }                    
                }

 //               }//ตรวจสอบเขต
                $ret = array (
                    'message'=> $message.$sql_alrt_1,
                    'count'=> $count,
                    'alertmessage'=>$alertmessage,
                    'book'=>$row
                );
                return json_encode($ret);
                break;  // book
            case 'ioffice':
                // ส่วนในการตรวจสอบงานค้ง
                $row = array();
                $sqluser = "SELECT * FROM person_main WHERE person_id = '$userid'";
                if($resultuser = mysqli_query($connect, $sqluser)) {
                  $rowuser = $resultuser->fetch_assoc();
                  $user_positionid = $rowuser["position_code"];
                  $user_position_other_code = $rowuser["position_other_code"];
                  $user_subdepartment = $rowuser["sub_department"];
                  $user_department = $rowuser["department"];
                }else{
                  $user_positionid = "";
                  $user_position_other_code = "";
                  $user_subdepartment = "";
                  $user_department = "";
                }
                // เจ้าหน้าที่
                $sqlpass = "consult_personid = '".$userid."' ";
                $receive_booklevelid = 1;
                // หัวหน้ากลุ่มงาน
                if($user_position_other_code>0){
                  $sqlpass = "((ioffice_book.booklevelid = 1) or (ioffice_book.booktypeid = 2)) and post_subdepartmentid = ".$user_subdepartment." and receive_booklevelid >= 2 ";
                  $receive_booklevelid = 2;
                }
                // ผอ.สำนัก
                if($user_positionid==9){
                  $sqlpass = "((ioffice_book.booklevelid = 2) or (ioffice_book.booktypeid = 2)) and post_departmentid = ".$user_department." and  receive_booklevelid >= 3 ";
                  $receive_booklevelid = 3;
                }
                // รองเลขา
                if($user_positionid==2){ 
                  $receive_booklevelid = 4;
                  if(!isset($_SESSION["system_delegate"])){ $_SESSION["system_delegate"]=""; }
                  if($_SESSION["system_delegate"]==1) { 
                    // กรณีรักษาราชการแทน
                    $sqlpass = "((ioffice_book.booklevelid = 3) or (ioffice_book.booklevelid = 4) or (ioffice_book.booktypeid = 2)) and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$userid."') and  receive_booklevelid >= 4 ";
                  }else{
                    // กรณีปกติ
                    $sqlpass = "((ioffice_book.booklevelid = 3) or (ioffice_book.booktypeid = 2)) and post_departmentid IN(SELECT departmentid FROM ioffice_bookpass WHERE personid = '".$userid."') and  receive_booklevelid >= 4 ";
                  }
                }
                // เลขา
                if($user_positionid==1){
                  $receive_booklevelid = 5;
                  $sqlpass = "((ioffice_book.booklevelid = 4) or (ioffice_book.booktypeid = 2)) and  receive_booklevelid >= 5 ";
                }
                // Select Book
                $sql_alert = "  SELECT 
                                        count(*) as count  
                                  FROM
                                        ioffice_book
                                        LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                                        LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                                        LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id 
                                        LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid 
                                        LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid 
                                        LEFT JOIN ioffice_booklevel ibl ON ioffice_book.receive_booklevelid = ibl.booklevelid 
                                  WHERE 
                                        ((ioffice_book.bookstatusid = 2) or (ioffice_book.bookstatusid = 4)) and
                                  $sqlpass";
                //echo $sql_alert;
                $result_alert = mysqli_query($connect, $sql_alert);
                $row_alert = $result_alert->fetch_assoc();
                
                // Select Book
                $sql_alert = "  SELECT 
                                        *  
                                  FROM
                                        ioffice_book
                                        LEFT JOIN ioffice_bookstatus ON ioffice_book.bookstatusid = ioffice_bookstatus.bookstatusid
                                        LEFT JOIN ioffice_booktype ON ioffice_book.booktypeid = ioffice_booktype.booktypeid
                                        LEFT JOIN person_main pm1 ON ioffice_book.post_personid = pm1.person_id 
                                        LEFT JOIN system_department sd1 ON sd1.department = ioffice_book.post_departmentid 
                                        LEFT JOIN system_subdepartment ON system_subdepartment.sub_department = ioffice_book.post_subdepartmentid 
                                        LEFT JOIN ioffice_booklevel ibl ON ioffice_book.receive_booklevelid = ibl.booklevelid 
                                  WHERE 
                                        ((ioffice_book.bookstatusid = 2) or (ioffice_book.bookstatusid = 4)) and
                                  $sqlpass";
                $result_alert2 = mysqli_query($connect, $sql_alert);
                while ($rows = $result_alert2->fetch_assoc()) {
                    $row[] = $rows;  
                }    

                // ข้อความที่ต้องการแจ้งเตือน
                $message = "";
                $count = "";
                $alertmessage = "";
                if($row_alert["count"]>0){
                      $message = "บันทึกเสนอรอลงความเห็น/สั่งการ ";
                      $count = $row_alert["count"];
                      $alertmessage = "<li><a href='?option=ioffice&task=book_pass'>".$message." <span class='badge progress-bar-danger'>".$row_alert["count"]."</span></a></li>";
                }
                
                $ret = array (
                    'message'=> $message,
                    'count'=> $count,
                    'alertmessage'=>$alertmessage,
                    'ioffice'=>$row
                );
                return json_encode($ret);
                
                break;  // ioffice
            case 'mail':
                $alertmessage = "";
                $count = "";
                $message = "";
                $row = array();

                // ส่วนในการตรวจสอบงานค้าง 1
                $sql_alert = "  select count(*) as count from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$userid' and mail_sendto_answer.answer<'1' ";
                //echo $sql_alert;
                $result_alert = mysqli_query($connect, $sql_alert);
                $row_alert = $result_alert->fetch_assoc();
                // ข้อความที่ต้องการแจ้งเตือน 1
                if($row_alert["count"]>0){
                      $message = "มีจดหมายที่ยังไม่ได้อ่าน";
                      $link = "option=mail&task=main/receive";
                      $count = $row_alert["count"];
                      $alertmessage = "<li><a href='?".$link."'>".$message." <span class='badge progress-bar-danger'>".$row_alert["count"]."</span></a></li>";
                } else {
                    $count = 0;
                }
                $sql_alert = "select * from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$userid' and mail_sendto_answer.answer<'1' ";
                $result_alert2 = mysqli_query($connect, $sql_alert);
                while ($rows = $result_alert2->fetch_assoc()) {
                    $row[] = $rows;  
                }    
                $ret = array (
                    'message'=> $message,
                    'count'=> $count,
                    'alertmessage'=>$alertmessage,
                    'mail'=>$row
                );
                return json_encode($ret);

                break;  // mail
            case 'meeting':
                $login_user_id=mysqli_real_escape_string($connect,$userid);

                //หาสิทธิ์
                    $sql_user_permis="select * from meeting_permission where person_id=? ";
                    $query_user_permis = $connect->prepare($sql_user_permis);
                    $query_user_permis->bind_param("i", $login_user_id);
                    $query_user_permis->execute();
                    $result_quser_permis=$query_user_permis->get_result();
                While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
                   {
                    $user_permission=$result_user_permis['p1'];
                    }
                 if(!isset($user_permission)){
                $user_permission="";
                }
                //echo " 555 ".$user_permission;
                if($user_permission==1){

                //หาหน่วยงาน
                    $sql_user_depart="select * from person_main where person_id=? ";
                    $query_user_depart = $connect->prepare($sql_user_depart);
                    $query_user_depart->bind_param("i", $login_user_id);
                    $query_user_depart->execute();
                    $result_quser_depart=$query_user_depart->get_result();
                While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
                   {
                    $user_departid=$result_user_depart['department'];
                    }

                // ส่วนในการตรวจสอบงานค้าง
                $sql_alert = "  SELECT
                                        count(*) as count
                                  from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=$user_departid and meeting_main.approve=0
                                    ";
                //echo $sql_alert;
                $result_alert = mysqli_query($connect, $sql_alert);
                $row_alert = $result_alert->fetch_assoc();

                // ส่วนในการตรวจสอบงานค้าง
                $sql_alert = "  SELECT * 
                                  from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=$user_departid and meeting_main.approve=0
                                    ";
                //echo $sql_alert;
                $result_alert2 = mysqli_query($connect, $sql_alert);
                $row = array();
                while ($rows = $result_alert2->fetch_assoc()) {
                    $row[] = $rows;  
                }    
                // ข้อความที่ต้องการแจ้งเตือน
                $message = "";
                $count = "";
                $alertmessage = "";
                if($row_alert["count"]>0){
                      $message = "รายการจองห้องประชุม";
                      $count = $row_alert["count"];
                      $alertmessage = "<li><a href='?option=meeting&task=main/officer'>".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
                }//แสดงผลการนับ

                }else{ //ตรวจสอบมีสิทธิ์
                    $message="";
                    $count="";
                    $alertmessage="";
                     }

                $ret = array (
                    'message'=> $message,
                    'count'=> $count,
                    'alertmessage'=>$alertmessage,
                    'meeting'=>$row
                );
                return json_encode($ret);
                
                break;  // meeting
                
            case 'work':
                $login_user_id=mysqli_real_escape_string($connect,$userid);
                $row = array();

                //หาสิทธิ์
                    $sql_user_permis="select * from meeting_permission where person_id=? ";
                    $query_user_permis = $connect->prepare($sql_user_permis);
                    $query_user_permis->bind_param("i", $login_user_id);
                    $query_user_permis->execute();
                    $result_quser_permis=$query_user_permis->get_result();
                While ($result_user_permis = mysqli_fetch_array($result_quser_permis))
                   {
                    $user_permission=$result_user_permis['p1'];
                    }
                 

                //หาหน่วยงาน
                    $sql_user_depart="select * from person_main where person_id=? ";
                    $query_user_depart = $connect->prepare($sql_user_depart);
                    $query_user_depart->bind_param("i", $login_user_id);
                    $query_user_depart->execute();
                    $result_quser_depart=$query_user_depart->get_result();
                While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
                   {
                    $user_departid=$result_user_depart['department'];
                    }


                //แสดงวันนี้
                $today_date = date("Y-m-d");

                // ส่วนในการตรวจสอบงานค้ง
                $sql_alert = "  SELECT
                                        count(work_main.id) as countid
                                  from person_main left join work_main on person_main.person_id = work_main.person_id where work_main.work_date='$today_date' and person_main.department=$user_departid ";
                //echo $sql_alert;
                $result_alert = mysqli_query($connect, $sql_alert);
                $row_alert = $result_alert->fetch_assoc();

                // ข้อความที่ต้องการแจ้งเตือน
                $message = "";
                $count = "";
                $alertmessage = "";
                if($row_alert["countid"]==0){
                      $message = "บันทึกการมาปฏิบัติราชการวันนี้";
                      $count = 1;
                      $row = array(
                        'data'=> $today_date,
                          'detail'=>'ยังไม่ได้รับการบันทึกข้อมูลการปฏิบัติราชการ'
                      );
                    
                      $alertmessage = "<li><a href='?option=work&task=check'>".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
                } else {
                    $count = 0;
                }//แสดงผลการนับ

                $ret = array (
                    'message'=> $message,
                    'count'=> $count,
                    'alertmessage'=>$alertmessage,
                    'work'=>$row
                );
                return json_encode($ret);
                break;  // work
            case 'car':
                $login_user_id=mysqli_real_escape_string($connect,$userid);
                //หาสิทธิ์
                    $sql_user_permis="select * from car_permission where person_id=? ";
                    $query_user_permis = $connect->prepare($sql_user_permis);
                    $query_user_permis->bind_param("i", $login_user_id);
                    $query_user_permis->execute();
                    $result_quser_permis=$query_user_permis->get_result();
                    While ($result_user_permis = mysqli_fetch_array($result_quser_permis)){
                        $user_permission=$result_user_permis['p1'];
                    }
                 if(!isset($user_permission))   $user_permission="";

                //echo " 555 ".$user_permission;
                if($user_permission==1 or $user_permission==3){
                // ส่วนในการตรวจสอบงานค้าง
                $sql_alert = "  SELECT
                                        count(id) as count
                                  from car_main";
                    if($user_permission==1){
                        $sql_alert=$sql_alert." where commander_grant=0";
                        $subm="";
                    }else if($user_permission==3){
                        $sql_alert=$sql_alert." where commander_grant=1";
                        $subm="&subm=car_commander";
                    }
                $result_alert = mysqli_query($connect, $sql_alert);
                $row_alert = $result_alert->fetch_assoc();

                // ข้อความที่ต้องการแจ้งเตือน
                $message = "";
                $count = "";
                $alertmessage = "";
                if($row_alert["count"]>0){
                      $message = "รายการขอใช้ยานพาหนะรอการอนุมัติ ";
                      $count = $row_alert["count"];
                      $alertmessage = "<li><a href='?option=car&task=car_officer$subm'>".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
                } else {
                    $count = 0;
                }//แสดงผลการนับ
                    
                // ส่วนในการตรวจสอบงานค้าง
                $sql_alert = "  SELECT
                                        *
                                  from car_main";
                    if($user_permission==1){
                        $sql_alert=$sql_alert." where commander_grant=0";
                        $subm="";
                    }else if($user_permission==3){
                        $sql_alert=$sql_alert." where commander_grant=1";
                        $subm="&subm=car_commander";
                    }
                //echo $sql_alert;
                $result_alert2 = mysqli_query($connect, $sql_alert);
                $row = array();
                while ($rows = $result_alert2->fetch_assoc()) {
                    $row[] = $rows;  
                }    

                }
                else{ //ตรวจสอบมีสิทธิ์
                    $message="";
                    $count="";
                    $alertmessage="";
                     }
                    $ret = array (
                    'message'=> $message,
                    'count'=> $count,
                    'alertmessage'=>$alertmessage,
                    'car'=>$row
                );
                return json_encode($ret);
                break;  // car
                
            default:
                return false;
        }
    }  /////////// End alert
}
?>
