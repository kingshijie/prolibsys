<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript" src="./js/common.js"></script>
</head>
<body>
<textarea id="txt1" cols="10" rows="10" name=description onblur="SetCookie('ok',this.value);"></textarea>
<script type="text/javascript">
	document.getElementById('txt1').value = getCookie('ok');
</script>
<?php
	include './include/common.inc.php';
	include './include/function_problem.php';
	//if(checkcookie('re')){
		//$re = explode('@#',getcookie('re'));	
	//}
	//$re[] = $_GET['v'];
	//ssetcookie('re',implode('@#',$re),120);
	//print_r($re);
?>
</body>
</html>