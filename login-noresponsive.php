<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$user_agent = $_SERVER['HTTP_USER_AGENT'];
function getOS() { 
    global $user_agent;
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
				if(($os_platform=='Android') or ($os_platform=='BlackBerry') or ($os_platform=='iPhone') or ($os_platform=='iPad')){
				$os_platform="mobile";
				}
				else{
				$os_platform="desktop";
				}
        }
    }   
    return $os_platform;
}
$user_os = getOS();
?>

<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name = "viewport" content = "width = device-width">
<link rel="stylesheet" href="admin/css/login.css" type="text/css" />
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.loginForm.username.select();
		document.loginForm.username.focus();
	}
</script>
</head>
<body onLoad="setFocus();">
<!-- Div ของ login -->
<form action="index.php" method="post" name="loginForm" id="loginForm">
<table class="login" align="center">
<tr><td>
<div class="ctr"><img src="images/login/x-obec.jpg" alt="security" /></div>
</td><td width="60%">
			<img src="images/login/login.gif" alt="Login" />
			<div class="form-block">
	        	<div class="inputlabel">Username</div>
		    	<div><input name="username" type="text" class="inputbox" size="15" /></div>
	        	<div class="inputlabel">Password</div>
		    	<div><input name="pass" type="password" class="inputbox" size="15" /></div>
				<input name="user_os" type="hidden" value="<?php echo $user_os ?>">
	        	<div align="left"><input type="submit" name="login_submit" class="button" value="Login" />
				&nbsp;<input type="reset" class="button" value="Reset" /></div>
        	</div>
</td></tr>
<tr><td colspan="2" align="center">
<font color="#FFFFFF">ระบบสนับสนุนการบริหารจัดการสำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน</font><br><br></td></tr>
</table>
</form>
<!-- จบ Login -->
<noscript>
!Warning! Javascript must be enabled for proper operation of the Administrator
</noscript>
</body>
</html>