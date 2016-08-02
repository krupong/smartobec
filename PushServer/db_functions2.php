<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
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
            // insert user into database
            $result = mysql_query("INSERT INTO smartpush (gcm_regid,gcm_id,gcm_user, created_at) VALUES('$gcm_regid','$gcm_id','$user', NOW())");
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

    }

    /**
     * เลือกผู้ใช้ทุกคน
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM smartpush");
        return $result;
    }

    public function getUser($gcm_regid) {
        $result = mysql_query("select * FROM smartpush WHERE gcm_regid='$gcm_regid'");
        $no_of_row = mysql_num_rows($result);
        if ($no_of_row > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getidUser($gcm_id) {
        $result = mysql_query("select * FROM smartpush WHERE gcm_id='$gcm_id'");
        return $result;
    }
    
    public function delUser($gcm_id) {
        $result = mysql_query("DELETE FROM smartpush WHERE gcm_regid='$gcm_regid'");
        return $result;
    }
    
    public function storePush($gcm_id,$department,$message,$title) {
        include("database_connect.php");
        $sql = "INSERT INTO smartpush_temp (gcm_id,department,message,title,pushdate) VALUES(?,?,?,?,?)";
        $query = $connect->prepare($sql);
        $query->bind_param("sssss",$gcm_id, $department,$message,$title, date("Y-m-d H:i:s"));
        $query->execute();
        $results = $query->get_result();
        return $results;
    }
    
    public function selectPush($gcm_regid) {
        include("database_connect.php");
        $sql = "SELECT push_module FROM smartpush_module WHERE gcm_regid=?";
        $query = $connect->prepare($sql);
        $query->bind_param("s",$gcm_regid);
        $query->execute();
        $results = $query->get_result();
        return $results;
    }

    public function storePushSet($gcm_regid,$gcm_id,$push_module) {
        include("database_connect.php");
        $sql = "INSERT INTO smartpush_module (gcm_regid,gcm_id,push_module) VALUES(?,?,?)";
        $query = $connect->prepare($sql);
        $query->bind_param("sss",$gcm_regid,$gcm_id,$push_module);
        $query->execute();
        $results = $query->get_result();
        return $results;
    }
}

?>
