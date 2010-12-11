<?php
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	if($op == 'add'){
		$majorname = $_POST['majorname'];
		echo 'INSERT INTO '.tname('major').' VALUES(NULL,'.$majorname.')';
		//$db->query('INSERT INTO '.tname('major').' VALUES(NULL,'.$majorname.')');
	}
	$major_arr = $db->fetch_all('SELECT * FROM '.tname('major'));
?>