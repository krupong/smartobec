<?php

class DB_Functions {

    private $db;
    // constructor
    function __construct() {
        include_once 'PushServer/db_connect2.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {}

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($gcm_regid,$gcm_id,$user) {
    /* ToNg Edit  */    
    // insert user into database
        $res = "DELETE FROM smartpush where gcm_regid = ?";
        $dbquery = $connect->prepare($res)
        $dbquery->bind_param("s", $gcm_regid );
        $dbquery->execute();
        $results=$dbquery->get_result();
        
        $sql = "INSERT INTO smartpush (id, gcm_regid,gcm_id,gcm_user, created_at) VALUES(NULL, ?,?,?, NOW())";
   // check for successful store
    if ($dbquery = $connect->prepare($sql)) {
    $dbquery->bind_param("sss", $gcm_regid , $gcm_id , $user);
    $dbquery->execute();
    $results=$dbquery->get_result();
    // get user details
        $id = mysqli_insert_id(); // last inserted id
        $sql = "SELECT * FROM smartpush WHERE gcm_id = ?";
        $dbquery = $connect->prepare($sql)
        $dbquery->bind_param("s", $gcm_regid );
        $dbquery->execute();
        $results=$dbquery->get_result();
                // return user details
                if (mysqli_num_rows($results) > 0) {
                    return mysqli_fetch_array($results);
                } else {
                    return false;
                }

    }else {
                return false;
            }
        /* End ToNg Edit  */      
/*
        // insert user into database
            $res = mysql_query("DELETE FROM smartpush where gcm_regid = $gcm_regid");
            $result = mysql_query("INSERT INTO smartpush (id, gcm_regid,gcm_id,gcm_user, created_at) VALUES(NULL, '$gcm_regid','$gcm_id','$user', NOW())");
            // check for successful store
            if ($result) {
                // get user details
                $id = mysql_insert_id(); // last inserted id
                $result = mysql_query("SELECT * FROM smartpush WHERE gcm_id = $gcm_id") or die(mysql_error());
                // return user details
                if (mysql_num_rows($result) > 0) {
                    return mysql_fetch_array($result);
                } else {
                    return false;
                }
            } else {
                return false;
            }
*/
    }

    /**
     * เลือกผู้ใช้ทุกคน
     */
    public function getAllUsers() {
    /*  ToNg Edit */
    $sql = "select * FROM smartpush";
    $dbquery = $connect->prepare($sql)
    $dbquery->execute();
    $results=$dbquery->get_result();
    return $results;
    /* End ToNg Edit  */ 
/*        $result = mysql_query("select * FROM smartpush");
        return $result;
*/        
    }

    public function getUser($gcm_regid) {
   /*  ToNg Edit */
        $sql = "select * FROM smartpush WHERE gcm_regid=?";
        $dbquery = $connect->prepare($sql)
        $dbquery->bind_param("s", $gcm_regid );
        $dbquery->execute();
        $results=$dbquery->get_result();
        $no_of_row = mysqli_num_rows($results);
        if ($no_of_row > 0) {
            return false;
        } else {
            return true;
        }
     /* End ToNg Edit  */ 
/*        $result = mysql_query("select * FROM smartpush WHERE gcm_regid='$gcm_regid'");
        $no_of_row = mysql_num_rows($result);
        if ($no_of_row > 0) {
            return false;
        } else {
            return true;
        }
*/        
    }

    public function getidUser($gcm_id) {
    /*  ToNg Edit */
        $sql = "select * FROM smartpush WHERE gcm_regid=?";
        $dbquery = $connect->prepare($sql)
        $dbquery->bind_param("i", $gcm_regid );
        $dbquery->execute();
        $results=$dbquery->get_result();
        return $results;
    /* End ToNg Edit  */ 
/*        $result = mysql_query("select * FROM smartpush WHERE gcm_id='$gcm_id'");
        return $result;
*/
}
    
    public function delUser($gcm_id) {
    /*  ToNg Edit */
        $sql = "DELETE FROM smartpush WHERE gcm_regid=?";
        $dbquery = $connect->prepare($sql)
        $dbquery->bind_param("s", $gcm_regid );
        $dbquery->execute();
        $results=$dbquery->get_result();
        return $results;
    /* End ToNg Edit  */ 
/*        $result = mysql_query("DELETE FROM smartpush WHERE gcm_regid='$gcm_regid'");
        return $result;
*/        
    }
    
    public function storePush($gcm_id,$department,$message,$title) {
    /*  ToNg Edit */
        $sql = "INSERT INTO smartpush_temp (gcm_id,department,message,title,pushdate) VALUES(?,?,?,?, NOW())";
        $dbquery = $connect->prepare($sql)
        $dbquery->bind_param("ssss", $gcm_id , $department , $message , $title );
        $dbquery->execute();
        $results=$dbquery->get_result();
    /* End ToNg Edit  */ 
/*        $sql = "INSERT INTO smartpush_temp (gcm_id,department,message,title,pushdate) VALUES('$gcm_id', '$department','$message','$title', NOW())";
        $result = mysql_query($sql);
*/
        //echo $sql;
        
    }

}

?>
