<?php
//header("content-type:text/javascript;charset=utf-8");   
//โชว์วันที่วันนี้
$today=date("d-m-Y");
//Session Login
$userlogin=$_SESSION['login_user_id'];

?>

<html>
    <head>
        
    </head>
   <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

                               
<?php
$work="SELECT * FROM test1 where look=0";
$workSQY=mysqli_query($connect,$work);
$i=-1;
//ลำดับที่ 1
while($workRS = mysqli_fetch_array($workSQY)){
	$i++;
	$consoles[$i]['title'] = $workRS['name'];
	$consoles[$i]['children'] = getNode($workRS['id']);
}
//ลำดับที่ 2
function getNode($id)
{
	include('amssplus_connect.php');
	$qlook ="SELECT * FROM test1 WHERE look=".$id."";
	$qlookSQY=mysqli_query($connect,$qlook);
		$p=-1;
		while($s = mysqli_fetch_array($qlookSQY)){
			$p++;
			if(hasChild($id)){
				$cons[$p] = array(
                     'title'      => $s['name'].$s['id'],
                     'children'       => getChild($s['id'])
               );
			}else{
			$cons[$p]['children'][] = array(
                     'title'      => $s['name'].$s['id'],
                     'children'       => getChild($s['id'])
               );
			}
			$mChild = getChild($s['id']);
	}
	return @$cons;
}
//ลำดับที่ 3
/*
function getChild($id)
{
	include('amssplus_connect.php');
	$rlook ="SELECT * FROM sub_test WHERE s_tid='".$id."'";
	$rlookSQY=mysqli_query($connect,$rlook);
		$a=-1;
			while($r = mysqli_fetch_array($rlookSQY)){
			$a++;
			if(hasChild($id)){
			$consoles[$a]=array(
			'title'=>$r['s_name'],
			'children'=>$r['s_name']
			);
			}else{
			$consoles[$a]=array(
			'title'=>$r['s_name']
			);
			}
			}
		print_r($consoles);
	return @$consoles;
}
*/
function getChild($id)
{
	include('amssplus_connect.php');
	$rlook ="SELECT * FROM sub_test WHERE s_tid='".$id."'";
	$rlookSQY=mysqli_query($connect,$rlook);
		$a=-1;
			while($r = mysqli_fetch_array($rlookSQY)){
			$a++;
			if(hasChild($id)){
			$conslook[$a]=array(
			'title'=>$r['s_name'],
			'children'=> getlook($r['s_id'])
			);
			}else{
			$conslook[$a]=array(
			'title'=>$r['s_name'],
			'children'=> getlook($r['s_id'])
			);
			}
			$mlook = getlook($r['s_id']);
			}
		//print_r($conslook);
	return @$conslook;
}
function hasChild($id)
{
	include('amssplus_connect.php');
	$rlook ="SELECT * FROM test1 WHERE look='".$id."'";
	$rlookSQY=mysqli_query($connect,$rlook);
	$num=mysqli_num_rows($rlookSQY);
	if($num>0){
	return true;
	}else{
	return false;
	}
}
//ลำดับที่ 4
function getlook($s_id)
{
	include('amssplus_connect.php');
	$rlookt ="SELECT * FROM sub_look WHERE sl_stid='".$s_id."' AND sl_num=1";
	$rlooktSQY=mysqli_query($connect,$rlookt);
		$g=-1;
			while($tt = mysqli_fetch_array($rlooktSQY)){
			$g++;
			if(haslook(@$sl_stid)){
			$consoles[$g]=array(
			'title'=>$tt['sl_name'],
			'children'=>$tt['sl_name']
			);
			}else{
			$consoles[$g]=array(
			'title'=>$tt['sl_name']
			);
			}
			}
		//print_r($conslok);
	return @$consoles;
}
function haslook($s_id)
{
	include('amssplus_connect.php');
	$rlooktt ="SELECT * FROM sub_test WHERE s_id='".$s_id."'";
	$rlookttSQY=mysqli_query($connect,$rlooktt);
	$num=mysqli_num_rows($rlookttSQY);
	//echo $num;
	if($num>0){
	return true;
	}else{
	return false;
	}
}
?>
<?php // print_r($consoles);?>
                                <div  class="col-sm-6 text-left  fom-control" >
	<p>
		<label>ค้นหาหน่วยงาน:</label>
                <input name="search"  placeholder="ระบุคำค้นหา..." autocomplete="off">
	</p>
                                  <div id="treeorganize"></div>
                                </div>

                        </div>
                </div>

        </section>

    </div>
    <script src="modules/book2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
     <script src="modules/book2/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
    <script src="modules/book2/bootstrap/js/bootstrap.min.js"></script>
    <script src="modules/book2/dist/js/app.min.js"></script>
    <script src="modules/book2/plugins/selection/bootstrap-select.min.js"></script>
    <script src="modules/book2/plugins/iCheck/icheck.min.js"></script>
    <script src="modules/book2/plugins/select2/select2.full.min.js"></script>
    <script src="modules/book2/plugins/validator/validator.min.js"></script>
    <script src="modules/book2/plugins/inputfile/fileinput.min.js"></script>
    <script src="modules/book2/plugins/inputfile/fileinput_locale_th.js"></script>
    <script src="modules/book2/plugins/inputfile/plugins/canvas-to-blob.min.js"></script>
    <script src="modules/book2/plugins/confirmation/bootstrap-confirmation.min.js"></script>
    <script src="modules/book2/plugins/datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="modules/book2/plugins/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    <script src="modules/book2/plugins/treeview/bootstrap-treeview.js"></script>
    <script src="modules/book2/plugins/fancytree/jquery.fancytree.js"></script>
     <script src="modules/book2/plugins/fancytree/jquery.fancytree.filter.js"></script>
<script type="text/javascript">
    
    var consoles = <?php echo json_encode($consoles); ?>;

	$(function(){
		$("#treeorganize").fancytree({
			checkbox: true,
			selectMode: 3,
			source: consoles,
			extensions: ["filter"],
			quicksearch: true,
			filter: {
                                                                autoApply: true,  // Re-apply last filter if lazy data is loaded
				counter: true,  // Show a badge with number of matching child nodes near parent icons
				fuzzy: false,  // Match single characters in order, e.g. 'fb' will match 'FooBar'
				hideExpandedCounter: true,  // Hide counter badge, when parent is expanded
				highlight: true,  // Highlight matches by wrapping inside <mark> tags
				mode: "dimm"  // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
			},
			activate: function(event, data) {
//				alert("activate " + data.node);
			},
                        
			lazyLoad: function(event, ctx) {
				ctx.result = {url: "ajax-sub2.json", debugDelay: 1000};
			},
			loadChildren: function(event, ctx) {
				ctx.node.fixSelection3AfterClick();
			},
			select: function(event, data) {
				var selKeys = $.map(data.tree.getSelectedNodes({ stopOnParents: true }), function(node){
					return node.key;
				});
				$("#echoSelection3").text(selKeys.join(", "));
				$("#inputtoorganize").val(selKeys.join(","));

				// Get a list of all selected TOP nodes
				var selRootNodes = data.tree.getSelectedNodes(true);
				// ... and convert to a key array:
				var selRootKeys = $.map(selRootNodes, function(node){
					return node.key;
				});
				$("#echoSelectionRootKeys3").text(selRootKeys.join(","));
				$("#echoSelectionRoots3").text(selRootNodes.join(","));
			},
			dblclick: function(event, data) {
				data.node.toggleSelected();
			},
			keydown: function(event, data) {
				if( event.which === 32 ) {
					data.node.toggleSelected();
					return false;
				}
			},
			// The following options are only required, if we have more than one tree on one page:
//				initId: "treeData",
			cookieId: "fancytree-Cb3",
			idPrefix: "fancytree-Cb3-",
 		});
		var tree = $("#treeorganize").fancytree("getTree");
		/*
		 * Event handlers for our little demo interface
		 */
		$("input[name=search]").keyup(function(e){
			var n,
				opts = {
					autoExpand: $("#autoExpand").is(":checked"),
					leavesOnly: $("#leavesOnly").is(":checked")
				},
				match = $(this).val();

			if(e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === ""){
                                                                    $("input[name=search]").val("");
                                                                $("span#matches").text("");
                                                                tree.clearFilter();
				$("button#btnResetSearch").click();
				return;
			}
			if($("#regex").is(":checked")) {
				// Pass function to perform match
				n = tree.filterNodes(function(node) {
					return new RegExp(match, "i").test(node.title);
				}, opts);
			} else {
				// Pass a string to perform case insensitive matching
				n = tree.filterNodes(match, opts);
			}
			$("button#btnResetSearch").attr("disabled", false);
			$("span#matches").text("(" + n + " หน่วยงาน)");
		//}).focus();  //ให้ Cursor ไปอยู่ช่องค้นหารอเลย
                                   });

                                $("button#btnResetSearch").click(function(e){
			$("input[name=search]").val("");
			$("span#matches").text("");
			tree.clearFilter();
		}).attr("disabled", true);

		$("fieldset input:checkbox").change(function(e){
			var id = $(this).attr("id"),
				flag = $(this).is(":checked");

			switch( id ) {
			case "autoExpand":
			case "regex":
			case "leavesOnly":
				// Re-apply filter only
				break;
			case "hideMode":
				tree.options.filter.mode = flag ? "hide" : "dimm";
				break;
			case "counter":
			case "fuzzy":
			case "hideExpandedCounter":
			case "highlight":
				tree.options.filter[id] = flag;
				break;
			}
			tree.clearFilter();
			$("input[name=search]").keyup();
		});

		$("#counter,#hideExpandedCounter,#highlight").prop("checked", true); 
    
    });
        
</script>
                            
  </body>
</html>