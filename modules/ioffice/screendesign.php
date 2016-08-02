<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Test Bootstrap</title>
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
<script src="bootstrap-3.3.5-dist/js/jquery-1.11.3.min.js"></script>
<script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
	<div class="row">
    	<div class="panel-heading">
        	<div class="h3">รายการบันทึกเสนอ</div>
        </div>
        <div class="panel-body">
       		<p><a href="#" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>เพิ่มบันทึกเสนอ</a></p>
       		<table class="table table-bordered table-hover table-striped table-condensed table-responsive">
            	<thead>
          	  		<tr>
          	    		<th>เลขที่</th>
          	    		<th>เรื่อง</th>
                        <th>เมื่อ</th>
                        <th>โดย</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
       	    		</tr>
            	</thead>
                <tbody>
          	  		<tr>
          	    		<td>5/2558</td>
          	    		<td>การจัดซื้ออุปกรณ์การเรียนการสอนทางไกล DLIT</td>
                        <td>24 ก.ค. 2558</td>
                        <td>นายศาสตรา ดอนโอฬาร</td>
                        <td><a tabindex="0" class="btn btn-xs btn-default" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ลำดับการเสนอ" data-content="And here's some amazing content. It's very engaging. Right?">ร่าง</a></td>
                        <td><a href="#" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
       	    		</tr>
          	  		<tr>
          	    		<td>4/2558</td>
          	    		<td>แต่งตั้งคณะกรรมการพัฒนาระบบ Smart OBEC</td>
                        <td>6 เม.ย. 2558</td>
                        <td>นายศาสตรา ดอนโอฬาร</td>
						<td><a tabindex="0" class="btn btn-xs btn-danger" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ลำดับการเสนอ" data-content="And here's some amazing content. It's very engaging. Right?">ยกเลิก</a></td>               
                        <td><a href="#" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
       	    		</tr>          	  		<tr>
          	    		<td>3/2558</td>
          	   		 	<td>ขอสมัครเข้ารับการคัดเลือกในตำแหน่งนักวิชาการคอมพิวเตอร์ ชำนาญการ</td>
                        <td>12 ก.ค. 2558</td>
                        <td>นายศาสตรา ดอนโอฬาร</td>
						<td><a tabindex="0" class="btn btn-xs btn-warning" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ลำดับการเสนอ" data-content="And here's some amazing content. It's very engaging. Right?">เสนอ</a></td>               
                        <td><a href="#" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
       	   			</tr>
          	  		<tr>
          	    		<td>2/2558</td>
          	    		<td>แต่งตั้งคณะกรรมการพัฒนาระบบ Smart OBEC</td>
                        <td>6 เม.ย. 2558</td>
                        <td>นายศาสตรา ดอนโอฬาร</td>
						<td><a tabindex="0" class="btn btn-xs btn-success" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ลำดับการเสนอ" data-content="And here's some amazing content. It's very engaging. Right?">อนมัติ</a></td>               
                        <td><a href="#" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
       	    		</tr>
          	  		<tr>
          	    		<td>1/2558</td>
          	    		<td>การจัดซื้ออุปกรณ์การเรียนการสอนทางไกล DLIT</td>
                        <td>24 ก.ค. 2558</td>
                        <td>นายศาสตรา ดอนโอฬาร</td>
						<td><a tabindex="0" class="btn btn-xs btn-danger" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="ลำดับการเสนอ" data-content="And here's some amazing content. It's very engaging. Right?">ไม่อนุมัติ</a></td>               
                        <td><a href="#" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
       	    		</tr>    			</tbody>              
			</table>
        </div>
    </div>
</div> 
<script>
	$(function () {
 		 $('[data-toggle="popover"]').popover()
	})
</script>
</body>
</html>