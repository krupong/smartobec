    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <?php
          $sqlcount = "SELECT count(*) as c FROM mail_main WHERE DATE_FORMAT(mail_main.send_date,'%Y-%m-%d') = curdate()";
          $resultcount = mysqli_query($connect,$sqlcount);
          $rowcount = $resultcount->fetch_assoc();
          $count = $rowcount['c'];
          ?>
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $count; ?><sup style="font-size: 20px">&nbsp;ฉบับ</sup></h3>

              <p>ไปรษณีย์วันนี้</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-mail"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <?php
          $sqlcount = "SELECT count(*) as c FROM ioffice_book WHERE DATE_FORMAT(ioffice_book.postdate,'%Y-%m-%d') = curdate()";
          $resultcount = mysqli_query($connect,$sqlcount);
          $rowcount = $resultcount->fetch_assoc();
          $count = $rowcount['c'];
          ?>
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $count; ?><sup style="font-size: 20px">&nbsp;เรื่อง</sup></h3>

              <p>บันทึกข้อความวันนี้</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-document"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <?php
          $sqlcount = "SELECT count(*) as c FROM book_main WHERE DATE_FORMAT(book_main.send_date,'%Y-%m-%d') = curdate()";
          $resultcount = mysqli_query($connect,$sqlcount);
          $rowcount = $resultcount->fetch_assoc();
          $count = $rowcount['c'];
          ?>
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $count; ?><sup style="font-size: 20px">&nbsp;เรื่อง</sup></h3>

              <p>หนังสือราชการวันนี้</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-folder"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <?php 
          $sqlcount = "SELECT count(DISTINCT login_logs.personid) as c FROM login_logs WHERE DATE_FORMAT(login_logs.logindate,'%Y-%m-%d') = curdate()";
          $resultcount = mysqli_query($connect,$sqlcount);
          $rowcount = $resultcount->fetch_assoc();
          $count = $rowcount['c'];
          ?>
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $count; ?><sup style="font-size: 20px">&nbsp;ผู้ใช้งาน</sup></h3>

              <p>สถิติการใช้งานวันนี้</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-contacts"></i>
            </div>
            <!--<a href="#" class="small-box-footer">รายละเอียดเพิ่มเติม <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">ประชาสัมพันธ์ | แจ้งแนวปฏิบัติ</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                <div class="btn-group" data-toggle="btn-toggle">
                  <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                </div>
              </div>
            </div>
            <div class="box-body chat" id="chat-box">
              <!-- chat item -->
              <?php
              $sqlchats = " SELECT
                            chats.chatid,
                            chats.personid,
                            chats.message,
                            chats.chatstatus,
                            chats.chatdate,
                            person_main.prename,
                            person_main.`name`,
                            person_main.surname,
                            person_main.department,
                            system_department.department_precis,
                            system_department.department_name,
                            person_khet_main.prename AS prename_khet,
                            person_khet_main.`name` AS name_khet,
                            person_khet_main.surname AS surname_khet,
                            system_khet.khet_precis
                            FROM
                            chats
                            LEFT JOIN person_main ON chats.personid = person_main.person_id
                            LEFT JOIN system_department ON person_main.department = system_department.department
                            LEFT JOIN person_khet_main ON chats.personid = person_khet_main.person_id
                            LEFT JOIN system_khet ON person_khet_main.khet_code = system_khet.khet_code
                            WHERE chats.chatstatus=1
                            ORDER BY
                            chats.chatid DESC";
              if($resultchats = mysqli_query($connect, $sqlchats)) {
              while ($rowchats = $resultchats->fetch_assoc()) {
                if(file_exists("modules/person/picture/".$rowchats["personid"].".jpg")){
                  $image = "modules/person/picture/".$rowchats["personid"].".jpg";
                }else{
                  $image = "modules/person/picture/nopic.png";
                }
                if($rowchats["name"]!=""){
                  if($rowchats["department_precis"]) {
                  $showname = $rowchats["name"]." ".$rowchats["surname"]." | ".$rowchats["department_precis"];
                  }else{
                    $showname = $rowchats["name"]." ".$rowchats["surname"];
                  }
                }else{
                  $showname = $rowchats["name_khet"]." ".$rowchats["surname_khet"]." | ".$rowchats["khet_precis"];
                }
                
                if($rowchats["personid"]==$_SESSION["login_user_id"]){
                  $showdelete = "<a href='index.php?token=".$rowchats["chatid"]."'><i class='fa fa-trash-o'></i></a> ";
                }else{
                  $showdelete ="";
                }
              ?>
              <div class="item">
                <img src="<?php echo $image; ?>" alt="user image" class="online">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo MailTime(strtotime($rowchats["chatdate"]),"","2"); ?></small>
                    <?php echo $showname; ?>
                  </a>
                  <?php echo $showdelete.$rowchats["message"]; ?>
                </p>
              </div>
              <?php } ?>
              <?php } ?>
              <!-- /.item -->
            </div>
            <!-- /.chat -->
            <div class="box-footer">
              <form action="index.php" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="พิมพ์ข้อความ ..." class="form-control" required>
                      <span class="input-group-btn">
                        <button id="chat_submit" name="chat_submit" type="submit" class="btn btn-success btn-flat">ส่งข้อความ</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box (chat box) -->
        </section>
        <!-- /.Left col -->

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
          <!-- Calendar -->
          <!--<div class="box box-solid bg-green-gradient">-->
          <!-- USERS LIST -->
          <div class="box box-danger">
                <div class="box-header with-border">
                  <i class="fa fa-user"></i>
                  <h3 class="box-title">ผู้ใช้งานล่าสุด</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">20 Access logging...</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php 
                    $sqluser = "SELECT 
                                ll1.personid,
                                pm.prename,
                                pm.`name`,
                                pm.surname,
                                person_khet_main.prename AS prename_khet,
                                person_khet_main.`name` AS name_khet,
                                person_khet_main.surname AS surname_khet,
                                pm.position_code,
                                ll1.logindate
                                FROM
                                login_logs AS ll1
                                LEFT JOIN person_main AS pm ON (ll1.personid = pm.person_id)
                                LEFT JOIN person_khet_main ON ll1.personid = person_khet_main.person_id                               
                                ORDER BY
                                ll1.loginid DESC
                                LIMIT 20";
                    if($resultuser = mysqli_query($connect, $sqluser)) {
                    while ($rowuser = $resultuser->fetch_assoc()) {
                        if(file_exists("modules/person/picture/".$rowuser["personid"].".jpg")){
                          $image = "modules/person/picture/".$rowuser["personid"].".jpg";
                        }else{
                          $image = "modules/person/nopic.png";
                        }
                        if($rowuser["name"]!=""){
                          $name = $rowuser["name"];
                        }else{
                          $name = $rowuser["name_khet"];
                        }
                    ?>
                    <li>
                      <img src="<?php echo $image; ?>" alt="User Image">
                      <a class="users-list-name" href="#"><?php echo $name; ?></a>
                      <span class="users-list-date"><?php echo MailTime(strtotime($rowuser["logindate"]),"","3"); ?></span>
                    </li>
                    <?php } ?>
                    <?php } ?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <!--<div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">View All Users</a>
                </div>-->
                <!-- /.box-footer -->
          </div>
          <!--/.box -->
          <!--</div>-->
          <!-- /.box -->

        </section>
        <!-- right col -->

      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->