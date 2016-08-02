<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$login_status=mysqli_real_escape_string($connect,$_SESSION['login_status']);
//sd page
$sql_permission = "select * from work_permission where person_id=?";
    $dbquery_permiss = $connect->prepare($sql_permission);
    $dbquery_permiss->bind_param("i", $login_user_id);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
     while($result_permission = $result_permiss->fetch_array())
    {
         $permission = $result_permission["p1"];
     }

if(isset($permission)){
    if($permission!=1 or $login_status<105 ){
        echo "<div align='center'><h2> เฉพาะผู้ดูแลการลงเวลาปฏิบัติราชการเท่านั้น </h2></div>";
        exit();
    }
    }else{
        $permission="";
    }

$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);


if(!isset($_SESSION['admin_work'])){
$admin_work="";
}else{
$admin_work=mysqli_real_escape_string($connect,$_SESSION['admin_work']);
}

	if($admin_work=="work"){
		?>
	<li class='dropdown'>
		<a href='?option=work' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>&nbsp;ตั้งค่าระบบ <span class='caret'></span></a>
		<ul class='dropdown-menu' role='menu'>
			<li>
				<a href='?option=work&task=permission'>
					<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; กำหนดเจ้าหน้าที่
				</a>
			</li>
		</ul>
	</li>
	<?php
	}
	if(($admin_work=="work") or ($login_status<=4 and $permission==1)){
		?>
		<li class='dropdown'><a href='?option=work' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-file' aria-hidden='true'></span>&nbsp;บันทึกข้อมูล <span class='caret'></span></a>
			<ul class='dropdown-menu' role='menu'>
				<li>
					<a href='?option=work&task=check'>
						<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; บันทึกข้อมูลการปฏิบัติราชการวันนี้
					</a>
				</li>
				<li>
					<a href='?option=work&task=check_2'>
						<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; บันทึกข้อมูลการปฏิบัติราชการย้อนหลัง
					</a>
				</li>
				<?php
        //บันทึกข้อมูลผู้บริหาร
        if($system_user_department==4){ ?>
					<li>
						<a href='?option=work&task=check_3'>
							<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; บันทึกข้อมูลการปฏิบัติราชการของผู้บริหาร
						</a>
					</li>
					<?php   } ?>

			</ul>
		</li>
		<?php
	}
	if(isset($login_user_id)){ ?>
			<li class='dropdown'>
				<a href='?option=work' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-stats' aria-hidden='true'></span>&nbsp;รายงาน <span class='caret'></span></a>
				<ul class='dropdown-menu' role='menu'>
					<li>
						<a href='?option=work&task=report_1'>
							<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; สรุปการปฏิบัติราชการรายวัน
						</a>
					</li>
					<li>
						<a href='?option=work&task=report_2'>
							<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; สรุปการปฏิบัติราชการรอบเดือน
						</a>
					</li>
					<li>
						<a href='?option=work&task=report_4'>
							<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; สรุปการปฏิบัติราชการรายสำนักรายวัน
						</a>
					</li>
					<li>
						<a href='?option=work&task=report_6'>
							<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; สรุปการปฏิบัติราชการผู้บริหารงานวัน
						</a>
					</li>

				</ul>
			</li>
			<?php	} ?>

				<li class='dropdown'>
					<a href='?option=work' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><span class='glyphicon glyphicon-book' aria-hidden='true'></span>&nbsp;คู่มือ <span class='caret'></span></a>
					<ul class='dropdown-menu' role='menu'>
						<li>
							<a href='modules/work/manual/work.pdf' target='_blank'>
								<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp; คู่มือการปฏิบัติราชการ
							</a>
						</li>
					</ul>
				</li>
