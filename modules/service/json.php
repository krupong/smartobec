<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
require "service.php";
$amss = new amss();

$data = json_decode(file_get_contents("php://input"));
$mode = $data->mode;

if(!isset($mode)) {
    $mode='login';
}

switch ($mode) {
    case 'login':
        $username = $data->username;
        $pass = $data->password;
        echo $amss->getLogin($username,$pass);
        break;
    case 'getpush':
        $uid = $data->uid;
        echo $amss->getPUsh($uid);
        break;
    case 'delitem':
        $item = $data->item;
        echo $amss->delItem($item);
        break;
    case 'logout':
        $item = $data->id;
        $amss->pushSet($item,'','','delete');
        echo $amss->doLogout($item);
        break;
    case 'pushSet':
        $gcm_regid = $data->gcm_regid;
        $gcm_id = $data->gcm_id;
        $push_module = $data->push_module;
        $domode = $data->domode;
        echo $amss->pushSet($gcm_regid,$gcm_id,$push_module,$domode);
        break;
    case 'alert':
        $uid = $data->uid;
        $module = $data->module;
        echo $amss->doAlert($uid,$module);
        break;
    default:
        $username = $data->username;
        $pass = $data->password;
        echo $amss->getLogin($username,$pass);
}
?>
