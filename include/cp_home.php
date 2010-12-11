<?php
	if(!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	if(!checkcookie('uid')){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: cp.php?ac=index");
	}
	include template('home');
?>
