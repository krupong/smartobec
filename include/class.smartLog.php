
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        smartLog
* GENERATION DATE:  30.07.2016
* CLASS FILE:       class.smartLog.php
* FOR MYSQL TABLE:  smartLog
* FOR MYSQL DB:     json
*
*/
// แก้ไขพาทของไฟล์ติดต่อฐานข้อมูลให้ถูกต้อง
include_once("resources/class.database.php");

class smartLog
{

// **********************
// กำหนดค่าพื้นฐาน
// **********************

var $id;   // ค่าคีย์หลัก

var $ref_id;   // (ค่าจากฟิลด์ ref_id)
var $logdata;   // (ค่าจากฟิลด์ logdata)
var $all;
var $database; // Instance ฐานข้อมูล


// **********************
// CONSTRUCTOR METHOD
// **********************

function smartLog()
{
        $this->database = new Database();
}


// **********************
// GETTER METHODS
// **********************


// คืนค่าจากฟิลด์ id
function getId()
{
        return $this->id;
}

// คืนค่าจากฟิลด์ ref_id
function getRef_id()
{
        return $this->ref_id;
}

// คืนค่าจากฟิลด์ logdata
function getLogdata()
{
        return $this->logdata;
}

// คืนค่าจากคำสั่ง sql ทั้งหมด
function getResult() {
    return $this->all;
}

// **********************
// SETTER METHODS
// **********************


// กำหนดค่าให้ฟิลด์ id
function setId($val)
{
        $this->id =  $val;
}

// กำหนดค่าให้ฟิลด์ ref_id
function setRef_id($val)
{
        $this->ref_id =  $val;
}

// กำหนดค่าให้ฟิลด์ logdata
function setLogdata($val)
{
        $this->logdata =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

$sql =  "SELECT * FROM smartLog WHERE id = $id;";
$result =  $this->database->query($sql);
$result = $this->database->result;
$row = mysql_fetch_object($result);

        $this->id = $row->id;

        $this->ref_id = $row->ref_id;

        $this->logdata = $row->logdata;

}

// **********************
// SELECT METHOD / LOAD
// **********************

function selectWhere($field,$id)
{

	$sql =  "SELECT * FROM smartLog WHERE `$field` = $id;";
	$result =  $this->database->query($sql);
	$result = $this->database->result;
	$row = mysql_fetch_object($result);

	$this->id = $row->id;

	$this->ref_id = $row->ref_id;

	$this->logdata = $row->logdata;

}
// **********************
// SELECT ALL METHOD
// **********************

function selectAll()
{
$sql = "SELECT * FROM smartLog";
$result = $this->database->query($sql);
$result = $this->database->result;
$this->all = $result;

}

// **********************
// CUSTOM COMMAND METHOD
// **********************

function sql($sql)
{
$result = $this->database->query($sql);
$result = $this->database->result;
$this->all = $result;

}

// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM smartLog WHERE id = $id;";
$result = $this->database->query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->id = ""; // clear key for autoincrement

$sql = "INSERT INTO smartLog ( ref_id,logdata ) VALUES ( '$this->ref_id','$this->logdata' )";
$result = $this->database->query($sql);
$this->id = mysql_insert_id($this->database->link);

}

// **********************
// UPDATE
// **********************

function update($id)
{
$sql = " UPDATE smartLog SET  ref_id = '$this->ref_id',logdata = '$this->logdata' WHERE id = $id ";
$result = $this->database->query($sql);

}

function redirect($url) {
        header("refresh: 5; url=$url");
}
} // class : end

?>
