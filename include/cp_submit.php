<?php
	$tid = $_GET['tid'];
	$uid = $_GET['uid'];
	pro_transform($_POST);
	$i = 0;
	$ans = '';
	foreach($_POST as $key => $value){
		$i++;
		if(is_array($value)){
			$result = $key.'##'.implode("#",$value);	
		}else {
			$result = $key.'##'.$value;	
		}
		$ans .= '###'.$result;
	}
	$ans = $i.$ans;
	if($db->query('INSERT INTO '.tname('result')." VALUES(NULL,$tid,$uid,'$ans',0,'')")){
		echo '<script type="text/javascript">alert(\'提交成功\');location.href=\'index.html\'</script>';
	}
?>