<?php
$my = $_POST["regid"];
$uid = $_POST['uid'];
$user = $_POST['user'];
// รับข้อมูล json
$json = array();
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
        $res = $db->delUser($gcm_regid);
        echo $result;
    } 
}
?>
