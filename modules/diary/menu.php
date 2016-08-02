<?php	
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<?php
$sqladmincheck="select * from system_module_admin where module='diary' and person_id='".$_SESSION["login_user_id"]."'";
$resultadmincheck=mysqli_query($connect,$sqladmincheck);
$resultadminchecknum=mysqli_num_rows($resultadmincheck);
$sqlpermissioncheck="select * from diary_permission dp where person_id='".$_SESSION["login_user_id"]."'";
$resultpermissioncheck=mysqli_query($connect,$sqlpermissioncheck);
$resultpermissionchecknum=mysqli_num_rows($resultpermissioncheck);
if(($resultadminchecknum==1) or ($resultpermissionchecknum==1)){

if($resultadminchecknum==1){
?>
	<li><a href="?option=diary&task=diary_permission"><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>&nbsp;กำหนดเจ้าหน้าที่</a></li>
	
<?php } ?>
<?php

if($resultpermissionchecknum==1){
?>
	<li><a href="?option=diary&task=diary_config"><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>&nbsp;จัดการเล่มไดอารี่</a></li>
<?php 
} 
}
$sqldiarycheck="select * from diary where diary_status=1";
$resultdiarycheck=mysqli_query($connect,$sqldiarycheck);
$resultdiarychecknum=mysqli_num_rows($resultdiarycheck);
if($resultdiarychecknum==1){
?>
<li><a href="?option=diary&task=diary"><span class='glyphicon glyphicon-file' aria-hidden='true'></span>&nbsp;บันทึกไดอารี่</a></li> <!-- เมนูไม่ Dropdown -->
<?php } ?>
<li><a href="?option=diary&task=diary_search"><span class='glyphicon glyphicon-search' aria-hidden='true'></span>&nbsp;ค้นหาไดอารี่</a></li> <!-- เมนูไม่ Dropdown -->
<li><a href='modules/diary/manual/manual.pdf' target='_blank'><span class='glyphicon glyphicon-book' aria-hidden='true'></span>&nbsp;คู่มือ</a></li> <!-- เมนูไม่ Dropdown -->