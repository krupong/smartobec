<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight = document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth = document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height = (newheight) + "px";
    document.getElementById(id).width = (newwidth) + "px";
}
//-->
</script>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<br>
<div class="container">
	<iframe src="modules/ci/index.php/examples/person_main" width="100%" height="200px" id="iframe1" marginheight="0" frameborder="0" onLoad="autoResize('iframe1');"></iframe>
</div> 

</body>
</html>