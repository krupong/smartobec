
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        department
* GENERATION DATE:  22.07.2016
* CLASS FILE:       class.department.php
* FOR MYSQL TABLE:  book2_department
* FOR MYSQL DB:     sm4
*
*/
// แก้ไขพาทของไฟล์ติดต่อฐานข้อมูลให้ถูกต้อง
include_once("resources/class.database.php");

class department
{

// **********************
// กำหนดค่าพื้นฐาน
// **********************

var $id;   // ค่าคีย์หลัก

var $name;   // (ค่าจากฟิลด์ name)
var $nameprecis;   // (ค่าจากฟิลด์ nameprecis)
var $namelongprecis;   // (ค่าจากฟิลด์ namelongprecis)
var $look;   // (ค่าจากฟิลด์ look)
var $sendlook;   // (ค่าจากฟิลด์ sendlook)
var $receivelook;   // (ค่าจากฟิลด์ receivelook)
var $sendmain;   // (ค่าจากฟิลด์ sendmain)
var $receivemain;   // (ค่าจากฟิลด์ receivemain)
var $send;   // (ค่าจากฟิลด์ send)
var $receive;   // (ค่าจากฟิลด์ receive)
var $status;   // (ค่าจากฟิลด์ status)
var $officer;   // (ค่าจากฟิลด์ officer)
var $officer_date;   // (ค่าจากฟิลด์ officer_date)
var $all;
var $database; // Instance ฐานข้อมูล


// **********************
// CONSTRUCTOR METHOD
// **********************

function department()
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

// คืนค่าจากฟิลด์ name
function getName()
{
        return $this->name;
}

// คืนค่าจากฟิลด์ nameprecis
function getNameprecis()
{
        return $this->nameprecis;
}

// คืนค่าจากฟิลด์ namelongprecis
function getNamelongprecis()
{
        return $this->namelongprecis;
}

// คืนค่าจากฟิลด์ look
function getLook()
{
        return $this->look;
}

// คืนค่าจากฟิลด์ sendlook
function getSendlook()
{
        return $this->sendlook;
}

// คืนค่าจากฟิลด์ receivelook
function getReceivelook()
{
        return $this->receivelook;
}

// คืนค่าจากฟิลด์ sendmain
function getSendmain()
{
        return $this->sendmain;
}

// คืนค่าจากฟิลด์ receivemain
function getReceivemain()
{
        return $this->receivemain;
}

// คืนค่าจากฟิลด์ send
function getSend()
{
        return $this->send;
}

// คืนค่าจากฟิลด์ receive
function getReceive()
{
        return $this->receive;
}

// คืนค่าจากฟิลด์ status
function getStatus()
{
        return $this->status;
}

// คืนค่าจากฟิลด์ officer
function getOfficer()
{
        return $this->officer;
}

// คืนค่าจากฟิลด์ officer_date
function getOfficer_date()
{
        return $this->officer_date;
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

// กำหนดค่าให้ฟิลด์ name
function setName($val)
{
        $this->name =  $val;
}

// กำหนดค่าให้ฟิลด์ nameprecis
function setNameprecis($val)
{
        $this->nameprecis =  $val;
}

// กำหนดค่าให้ฟิลด์ namelongprecis
function setNamelongprecis($val)
{
        $this->namelongprecis =  $val;
}

// กำหนดค่าให้ฟิลด์ look
function setLook($val)
{
        $this->look =  $val;
}

// กำหนดค่าให้ฟิลด์ sendlook
function setSendlook($val)
{
        $this->sendlook =  $val;
}

// กำหนดค่าให้ฟิลด์ receivelook
function setReceivelook($val)
{
        $this->receivelook =  $val;
}

// กำหนดค่าให้ฟิลด์ sendmain
function setSendmain($val)
{
        $this->sendmain =  $val;
}

// กำหนดค่าให้ฟิลด์ receivemain
function setReceivemain($val)
{
        $this->receivemain =  $val;
}

// กำหนดค่าให้ฟิลด์ send
function setSend($val)
{
        $this->send =  $val;
}

// กำหนดค่าให้ฟิลด์ receive
function setReceive($val)
{
        $this->receive =  $val;
}

// กำหนดค่าให้ฟิลด์ status
function setStatus($val)
{
        $this->status =  $val;
}

// กำหนดค่าให้ฟิลด์ officer
function setOfficer($val)
{
        $this->officer =  $val;
}

// กำหนดค่าให้ฟิลด์ officer_date
function setOfficer_date($val)
{
        $this->officer_date =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

$sql =  "SELECT * FROM book2_department WHERE id = $id";
$result =  $this->database->query($sql);
$result = $this->database->result;
$row = mysql_fetch_object($result);

        $this->id = $row->id;

        $this->name = $row->name;

        $this->nameprecis = $row->nameprecis;

        $this->namelongprecis = $row->namelongprecis;

        $this->look = $row->look;

        $this->sendlook = $row->sendlook;

        $this->receivelook = $row->receivelook;

        $this->sendmain = $row->sendmain;

        $this->receivemain = $row->receivemain;

        $this->send = $row->send;

        $this->receive = $row->receive;

        $this->status = $row->status;

        $this->officer = $row->officer;

        $this->officer_date = $row->officer_date;

}

// **********************
// SELECT ALL METHOD
// **********************

function selectAll()
{
$sql = "SELECT * FROM book2_department";
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
$sql = "DELETE FROM book2_department WHERE id = $id";
$result = $this->database->query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->id = ""; // clear key for autoincrement

$sql = "INSERT INTO book2_department ( name,nameprecis,namelongprecis,look,sendlook,receivelook,sendmain,receivemain,send,receive,status,officer,officer_date ) VALUES ( '$this->name','$this->nameprecis','$this->namelongprecis','$this->look','$this->sendlook','$this->receivelook','$this->sendmain','$this->receivemain','$this->send','$this->receive','$this->status','$this->officer','$this->officer_date' )";
$result = $this->database->query($sql);
$this->id = mysql_insert_id($this->database->link);

}

// **********************
// UPDATE
// **********************

function update($id)
{
$sql = " UPDATE book2_department SET  name = '$this->name',nameprecis = '$this->nameprecis',namelongprecis = '$this->namelongprecis',look = '$this->look',sendlook = '$this->sendlook',receivelook = '$this->receivelook',sendmain = '$this->sendmain',receivemain = '$this->receivemain',send = '$this->send',receive = '$this->receive',status = '$this->status',officer = '$this->officer',officer_date = '$this->officer_date' WHERE id = $id ";
$result = $this->database->query($sql);

}

function redirect($url) {
        header("refresh: 5; url=$url");
}
} // class : end

?>
