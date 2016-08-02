<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<tr bgcolor="#FFCC00">
<td colspan="5">
<ul id="nav" class="dropdown dropdown-horizontal">
<?php		
//**
if(!($_SESSION['login_status']==1000)){

$sql_menugroup = "select  * from system_menugroup order by menugroup_order";
$dbquery_menugroup = mysqli_query($connect,$sql_menugroup);
While ($result_menugroup = mysqli_fetch_array($dbquery_menugroup)) {	
		echo "<li>";
		echo "<a href='./' class='dir'>$result_menugroup[menugroup_desc]</a>";
					$sql_module = "select  * from system_module where workgroup='$result_menugroup[menugroup]' and module_active='1' order by module_order";
					$dbquery_module = mysqli_query($connect,$sql_module);
					echo "<ul>";
				While ($result_module = mysqli_fetch_array($dbquery_module)){
							if($result_module['where_work']==0 and $_SESSION['login_group']==1){
									if($result_module['web_link']==1){
									echo "<li><a href='$result_module[url]' target='_blank'>$result_module[module_desc]</a></li>";
									}
									else {
									echo "<li><a href='?option=$result_module[module]'>$result_module[module_desc]</a></li>";
									}
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
							else if($result_module['where_work']==1 and $_SESSION['login_group']<=2){
									if($result_module['web_link']==1){
									echo "<li><a href='$result_module[url]' target='_blank'>$result_module[module_desc]</a></li>";
									}
									else {
									echo "<li><a href='?option=$result_module[module]'>$result_module[module_desc]</a></li>";
									}
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
							else if($result_module['where_work']==2 and $_SESSION['login_group']<=3){
									if($result_module['web_link']==1){
									echo "<li><a href='$result_module[url]' target='_blank'>$result_module[module_desc]</a></li>";
									}
									else {
									echo "<li><a href='?option=$result_module[module]'>$result_module[module_desc]</a></li>";
									}
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
							else if($result_module['where_work']==3 and $_SESSION['login_group']<=4){
									if($result_module['web_link']==1){
									echo "<li><a href='$result_module[url]' target='_blank'>$result_module[module_desc]</a></li>";
									}
									else {
									echo "<li><a href='?option=$result_module[module]'>$result_module[module_desc]</a></li>";
									}
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
					}							
					echo "</ul>";
		echo "</li>";
 }
 
} //end **
?>	
	<li><a href="./" class="dir">ผู้ใช้ (User)</a>
		<ul>
<?php			
			if(!($_SESSION['login_status']==1000)){	
			echo "<li><a href='?file=user_change_pwd'>เปลี่ยนรหัสผ่าน</a></li>";
			}
			if($_SESSION['login_status']==1000){	
			echo "<li><a href='?file=register'>ลงทะเบียนผู้ใช้</a></li>";
			}
?>			
		</ul>
	</li>

</ul>
</td>
<td align="right" width="150">Version <?php echo $_SESSION['system_version']; ?>&nbsp;&nbsp;&nbsp;</td>
</tr>
