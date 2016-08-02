<?php

function smartpush($uid,$message,$title) {
    include "PushServer/db_functions2.php";
    include "PushServer/gcm2.php";
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
            $registatoin_ids = array($regId);
            $result = $gcm->send_notification($registatoin_ids, $message,$title);
            echo $result;
        }
    }
}
?>
