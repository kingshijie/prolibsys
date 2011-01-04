<?php
require_once './include/common.inc.php';
//允许的方法
$acs = array('index','home','login','submit');
$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'home':$_GET['ac'];
$op = empty($_GET['op'])?'':$_GET['op'];
if($ac == 'home'){
	$paid = $_GET['paid'];
	$file = 'paper'.$paid;
	if(file_exists($paperdir.$file.'.html') && $html_active){
		require $paperdir.$file.'.html';
	}else{
		ob_start();
		include_once('./include/cp_'.$ac.'.php');
		$html = ob_get_contents();//取得php页面输出的全部内容
		create_html($html,$file);
	}
}else{
	include_once('./include/cp_'.$ac.'.php');	
}
	
?>
