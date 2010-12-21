<?php
	if(!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	/*if(!checkcookie('uid')){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: cp.php?ac=index");
	}*/
	$paid = $_GET['paid'];
	$paper = $db->fetch_first('SELECT `title`,`construction`,`timeNeed` FROM '.tname('paper').' WHERE `paid`='.$paid);
	$title = $paper['title'];
	$des = $paper['construction'];
	$paper_info = explode('###',$des);
	$blocks = explode('##',$paper_info[1]);
	foreach($blocks as $key => $block){
		$blocks[$key] = pro_untransform(explode('#',$block,3));
		$blocks[$key][2] = explode('#',$blocks[$key][2]);
	}
	$timeNeed = $paper['timeNeed'];
	include template('home');
?>
