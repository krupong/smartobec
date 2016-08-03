//add new data
function add_user_form(){
	$.ajax({
		type:"POST",
		url:"process.php",
		data:$("#add_user_form").serialize(),
		success:function(data){
			
			//close modal
			$(".close").trigger("click");
			
			//show result
			alert(data);
			
			//reload page
			location.reload();
		}
	});
	return false;
}

//show data for edit
function show_edit_user(id){
	$.ajax({
		type:"POST",
		url:"process.php",
		data:{show_user_id:id},
		success:function(data){
			$("#edit_form").html(data);
		}
	});
	return false;
}

//edit data
function edit_user_form(){
	$.ajax({
		type:"POST",
		url:"process.php",
		data:$("#edit_user_form").serialize(),
		success:function(data){
			
			//close modal
			$(".close").trigger("click");
			
			//show result
			alert(data);
			
			//reload page
			location.reload();
		}
	});
	return false;
}

//delete user
function delete_user(id){
	if(confirm("คุณต้องการลบข้อมูลหรือไม่")){
		$.ajax({
			type:"POST",
			url:"process.php",
			data:{delete_user_id:id},
			success:function(data){
				alert(data);
				location.reload();
			}
		});
	}
	return false;
}

//delete ไฟล์แนบ
function delete_fileupload(id){
	if(confirm("คุณต้องการลบไฟล์แนบหรือไม่")){
		$.ajax({
			type:"POST",
			url:"./modules/book2/main/process.php",
			data:{delete_fileupload_id:id},
			success:function(data){
				alert(data);
				location.reload();
			}
		});
	}
	return false;
        }
        
//ส่งหนังสือราชการออก
function sendtrue_addbook(id,senderrole,senderofficer){
	if(confirm("คุณแนบไฟล์ครบถ้วนแล้วหรือไม่  กดตกลงเพื่อยืนยันการส่ง")){
		$.ajax({
			type:"POST",
			url:"./modules/book2/main/process.php",
			data:{
                                                        sendtrue_addbook_ref:id,
                                                        senderrole:senderrole,
                                                        sender_officer:senderofficer
                                                    },
			success:function(data){
				alert(data);
				location.reload();
			}
		});
	}
	return false;
        }
        
 //ดูรายละเอียดหนังสือราชการ
function detailbook(refid){
                                        //var detailref = $("#detailrefid").val();     
                                        // Get value from input element on the page
                                        var refidbook = refid;
                                        $(".result").empty();
                                        $("#result").removeData('bs.modal');
                                        //var showresult = "result"+refidbook.text();
                                        // Send the input data to the server using get
                                        $.get("./modules/book2/main/showbook_detail.php", {id: refidbook} , function(data){
                                            // Display the returned data in browser
                                            $(".result").empty();
                                            console.log(data);
                                            //alert("#showresult");
                                          $(".result").html(data);
                                        });
                   

	//return false;
        }
        
  //ลงทะเบียนหนังสือรับแบบกลุ่ม
function groupcheckreceive(){
    var idArray = [];
    $("input[name='checkgroupreceive[]']").each( function () {
                    if($(this).prop('checked') == true){
                        idArray.push($(this).val());
                    }
            });
            $.post("./modules/book2/main/receivebook_runnum.php", {id: JSON.stringify(idArray)} , function(data){
                                            // Display the returned data in browser
                                            console.log(data);
                                            //alert("#showresult");
                                            $(".result").html(data);
                                        });
        return false;
        }
        
  //เช็คหนังสือราชการที่เคยรับ
function checknumreceive(){
    var vbookno = $("#bookno").val();
        $(".detail").empty();
    $.post("./modules/book2/main/checknumreceive.php", {id: vbookno} , function(data){
                                            // Display the returned data in browser
                                            console.log(data);
                                            //alert("#showresult");
                                            $(".result").html(data);
                                        });
	return false;
        }
        
   //เปิดรายละเอียดหนังสือแบบค้นเลขรับ
function showdetailreceived(refid){
    //var vbookno = $("#bookno").val();
 
    $.get("./modules/book2/main/showbook_detailpage.php", {id: refid} , function(data){
                                            // Display the returned data in browser
                                            console.log(data);
                                            //alert("#showresult");
                                            $(".detail").html(data);
                                        });
	return false;
        }
 
//เพิ่มหน่วยงาน
function add_department_form(){
	$.ajax({
		type:"POST",
		url:"./modules/book2/main/process.php",
		data:$("#add_department_form").serialize(),
		success:function(data){
			
			//close modal
			//$(".close").trigger("click");
			
			//show result
			alert(data);
			
			//reload page
			location.reload();
		}
	});
	return false;
}

//เพิ่ม session
function session_role(roleid_person){
	$.ajax({
		type:"POST",
		url:"./modules/book2/main/process.php",
		data:{session_roleid_person:roleid_person},
		success:function(data){
			//show result
			//alert(data);
			swal({
				title : 'เปลี่ยนบทบาทเรียบร้อยแล้ว',
				text : data,
				type : 'success'
			});
			//reload page
			//window.location="?option=book2&task=main/receive_newbook"; 
            //window.location.href("?option=book2&task=main/receive_newbook")
		},
		error:function(err){
          swal({  
                  title : 'เกิดข้อผิดพลาด',
                  text : err,
                  type : 'error'
              });
        }
	});
	return false;
}

                 
//ส่งคืนหนังสือราชการออก
function return_sendbook(){
	if(confirm("กดตกลงเพื่อยืนยันการส่งคืน")){
            
                var idArray = [];
                $("input[name='checkgroupreceive[]']").each( function () {
                                if($(this).prop('checked') == true){
                                    idArray.push($(this).val());
                                    }
                            });
                 //var returncomment = $("input[name='returncomment']");      
                 var returncomment = document.getElementById("returncomment").value;
        $.post("./modules/book2/main/receivebook_return.php", {id: JSON.stringify(idArray),commentrt :returncomment} , function(data){
                                            // Display the returned data in browser
                                            //console.log(data);
                                            //alert("#showresult");
                                            //$(".result").html(data);
                                            alert(data);
                                            location.reload();
                                        });                  
            
                /*	$.ajax({                    
			type:"POST",
			url:"./modules/book2/main/process.php",
                                                data:$("#return_sendbookcomment").serialize(),
                                                /*data:{
                                                        returnbook_refid:id,
                                                        senderrole:senderrole,
                                                        sender_officer:senderofficer,
                                                        comment:comment
                                                    },
                                                   
			success:function(data){
				alert(data);
				location.reload();
			}
		});
                */
	}
	return false;
        }

//ส่งคืนหนังสือราชการออก
function finish_sendbook(){
	if(confirm("กดตกลงเพื่อยืนยันการยุติหนังสือราชการ")){
            
                var idArray = [];
                $("input[name='checkgroupreceive[]']").each( function () {
                                if($(this).prop('checked') == true){
                                    idArray.push($(this).val());
                                    }
                            });
                 //var returncomment = $("input[name='returncomment']");      
                 var finishcomment = document.getElementById("finishcomment").value;
        $.post("./modules/book2/main/receivebook_finish.php", {id: JSON.stringify(idArray),commentfn :finishcomment} , function(data){
                                            // Display the returned data in browser
                                            //console.log(data);
                                            //alert("#showresult");
                                            //$(".result").html(data);
                                            alert(data);
                                            location.reload();
                                        });                  
            
                /*	$.ajax({                    
			type:"POST",
			url:"./modules/book2/main/process.php",
                                                data:$("#return_sendbookcomment").serialize(),
                                                /*data:{
                                                        returnbook_refid:id,
                                                        senderrole:senderrole,
                                                        sender_officer:senderofficer,
                                                        comment:comment
                                                    },
                                                   
			success:function(data){
				alert(data);
				location.reload();
			}
		});
                */
	}
	return false;
        }

//ลงทะเบียนหนังสือจากกระดาษ
function receive_paperbook(){
	$.ajax({
		type:"POST",
		url:"./modules/book2/main/receive_paper_process.php",
		data:$("#add_department_form").serialize(),
		success:function(data){
			
			//close modal
			//$(".close").trigger("click");
			
			//show result
			alert(data);
			
			//reload page
			location.reload();
		}
	});
	return false;
}
