<?php

class DB_Connect {
    function __construct() {}
    function __destruct() {}

    // เชื่อมต่อฐานข้อมูล
    public function connect() {
        require_once './config.php';
        // เริ่มเชื่อมต่อ
        $con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        // เลือกฐานข้อมูล
        mysql_select_db(DB_DATABASE);

        // ส่งค่าการเชื่อมต่อกลับ
        return $con;
    }

    // ยกเลิกการเชื่อมต่อ
    public function close() {
        mysql_close();
    }

}
?>
