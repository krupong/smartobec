<?php
$my = $_POST["regid"];
$uid = $_POST['uid'];
$user = $_POST['user'];
// รับข้อมูล json
$json = array();
$pushArray = "{'bookregister':true,'book':true,'ioffice':true,'mail':true,'meeting':true,'work':true,'car':true}";
/**
 * ผู้ใช้ลงทะเบียนอุปกรณ์เข้ากับฐานข้อมูล
 * โดยเก็บค่า reg id ลงในตาราง
 */
if (isset($my)) {
    $gcm_regid = $my; // GCM ID ที่ลงทะเบียน
    // เชื่อมต่อฐานข้อมูลและเก็บรายละเอียดผู้ใช้ลงฐานข้อมูล
    include_once './db_functions.php';
    include_once './gcm.php';

    $db = new DB_Functions();
    $gcm = new GCM();

    if ($db->getUser($gcm_regid)) {
        $res = $db->storeUser($gcm_regid,$uid,$user);
        $res2 = $db->storePushSet($gcm_regid,$uid,$pushArray);

        $registatoin_ids = array($gcm_regid);
        $message = "ยินดีต้อนรับสู่ Smart OBEC";

        $result = $gcm->send_notification($registatoin_ids, $message);
        //echo "gcm regid".$gcm_regid;
        echo $result;
    } else {
        echo "ผู้ใช้ลงทะเบียนแล้ว";
    }
} else {
    echo "ไม่มีค่า my ".$my;
}
?>
