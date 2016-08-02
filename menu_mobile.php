<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

echo "<tr><td colspan='6'>";
//**
if(!($_SESSION['login_status']==5 or $_SESSION['login_status']==15)){
echo "<br>";
echo "<table border='0' width='98%' align='center'>";
$sql_menugroup = "select  * from system_menugroup order by menugroup_order";
$dbquery_menugroup = mysqli_query($connect,$sql_menugroup);
While ($result_menugroup = mysqli_fetch_array($dbquery_menugroup)) {	
		echo "<tr bgcolor='#006666'><td colspan='3' class='tagline' align='left'>$result_menugroup[menugroup_desc]</td></tr>";
					$sql_module = "select  * from system_module where workgroup='$result_menugroup[menugroup]' and module_active='1' and (web_link != '1' or web_link is NULL) order by module_order";
					$dbquery_module = mysqli_query($connect,$sql_module);
					While ($result_module = mysqli_fetch_array($dbquery_module)){
							if(($_SESSION['login_status']<=5) and ($result_module['where_work']<=1 or $result_module['where_work']==3)){
										echo "<tr><td width='5%'></td><td align='left' width='50'><a href='?option=$result_module[module]'><img width='40' src='modules/$result_module[module]/images/$result_module[module]_logo.jpg' /></a></td><td align='left' class='tagline'><a href='?option=$result_module[module]'>$result_module[module_desc]</a></td></tr>";
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
							else if(($_SESSION['login_status']>10 and $_SESSION['login_status']<16) and ($result_module['where_work']<1 or $result_module['where_work']>1)){
										echo "<tr><td width='5%'></td><td align='left' width='50'><a href='?option=$result_module[module]'><img width='40' src='modules/$result_module[module]/images/$result_module[module]_logo.jpg' /></a></td><td align='left' class='tagline'><a href='?option=$result_module[module]'>$result_module[module_desc]</a></td></tr>";
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
							else if(($_SESSION['login_status']==16) and ($result_module['where_work']==3)){
										echo "<tr><td width='5%'></td><td align='left' width='50'><a href='?option=$result_module[module]'><img width='40' src='modules/$result_module[module]/images/$result_module[module]_logo.jpg' /></a></td><td align='left' class='tagline'><a href='?option=$result_module[module]'>$result_module[module_desc]</a></td></tr>";
											if(!isset($_SESSION['module_name_'.$result_module['module']])){
											$_SESSION['module_name_'.$result_module['module']]=$result_module['module_desc'];
											}
							}
					}		
 }
echo "</table>";		 
} //end **
echo "</td></tr>";
?>			
<tr>
<td colspan="6">
		<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr bgcolor="#26354A">
			<td height="30"  class="user" align="center"><a href=change_os.php>AMSS++ for Desktop</a></td>
		</tr></table>
</td></tr>