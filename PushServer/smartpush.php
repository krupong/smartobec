<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
include "PushServer/db_functions2.php";
include "PushServer/gcm2.php";

function smartpush($uid,$department,$message,$title) {

    if (!isset($title)) {$title = 'แจ้งเตือน : ';}
    $gcm = new GCM();
    $db = new DB_Functions();
    $users = $db->getidUser($uid);
    if ($users)
        $no_of_users = mysql_num_rows($users);
    else
        $no_of_users = 0;

    if ($no_of_users>0) {
        while ($row = mysql_fetch_array($users)) {
            $regId = $row['gcm_regid'];
            $userid = $row['gcm_id'];
            $registatoin_ids = array($regId);
            $res = $db->selectPush($regId);
            while ($deps = mysqli_fetch_array($res)) {
                $dep = $deps['push_module'];
            }
            $dep = json_decode($dep,true);
            //print_r($dep);
            if (($dep[$department]==true) || (!isset($dep[$department]))) {
                $result = $gcm->send_notification($registatoin_ids,$department, $message,$title);
                echo $result;
            }
        }
    $res = $db->storePush($uid,$department,$message,$title);
    }
}
?>
