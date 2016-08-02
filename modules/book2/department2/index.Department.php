<?php
include_once('class.department.php');
$gen = new department();
$gen->selectAll();
?>
<!--- แก้ไข path ของ assets ให้ถูกต้อง -->
<link rel="stylesheet" href="assets/css/styles.css" />
<div id="wrapper">
<div class="col-md-6">
            <h1>รายการข้อมูล
                    <a href="?option=book2&task=department/create.Department" class="btn btn-primary btn-xs" title="เพิ่มข้อมูล">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"/>
                    </a>
            </h1>
        <div class="table">
        <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr><th>id</th><th>name</th><th>ดำเนินการ</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        while ($data = mysql_fetch_row($gen->getResult())) {?>
                <tr>
                    <td><?=$data[0]?></td>
                    <td><?=$data[1]?></td>
                    <td>
                        <a href="?option=book2&task=department/show.Department?id=<?=$data[0]?> " class="btn btn-success btn-xs" title="แสดงข้อมูล"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="?option=book2&task=department/edit.Department?id=<?=$data[0]?>" class="btn btn-primary btn-xs" title="แก้ไขข้อมูล"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        <form method="POST" action="?option=book2&task=department/delete.Department" accept-charset="UTF-8" style="display:inline"><input name="id" type="hidden" value="<?=$data[0]?>">
                            <button type="submit" class="btn btn-danger btn-xs" title="ลบข้อมูล" onclick="return confirm('ต้องการลบจริงหรือไม่?')"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="ลบข้อมูล" /></button>
                        </form>
                    </td>
                </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        <div class="pagination-wrapper">  </div>
        </div>

</div>
</div>
