<?php
	/*考试管理：
	1）添加考试、添加考试组
	2）编辑、删除试卷
	3）关联考试用户组，考试时间判断有无已过期
	流程：选择考试成员（运用用户组）->选择考试试卷->设置考试开始时间、结束时间*/
	
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	//考试列表
	if($op == 'default' || $op == 'display'){
		$count_sql = 'SELECT COUNT(*) FROM '.tname('test');
		$sql = 'SELECT * FROM '.tname('test').' ORDER BY `tid` DESC {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$test_arr = page_division($count_sql, $sql, $page, $page_arr);
		get_cache('major');
	}
	//添加考试
	if($op == 'sel_maj'){
		$sql_maj = 'SELECT * FROM '.tname('major');
		$maj_arr = $db->fetch_all($sql_maj);	
	}
	if($op == 'show_add'){
		$sql_par = 'SELECT `paid`,`title`,`timeNeed`,`mid` FROM '.tname('paper').' WHERE `mid`='.$_POST['major'];
		$par_arr = $db->fetch_all($sql_par);
		$sql_gro = 'SELECT * FROM '.tname('group');
		$gro_arr = $db->fetch_all($sql_gro);
		$mid = $_POST['major'];
	}
	if($op == 'add_test'){
		$paid = $_POST['paper'];
		$mid = $_GET['mid'];
		$stime = $_POST['stime'];
		$etime = $_POST['etime'];
		$group = implode('#', $_POST['groupids']);
		$sql = "INSERT INTO ".tname('test')." (`paid`,`mid`,`stime`,`etime`,`groupids`) VALUES ('$paid','$mid','$stime','$etime','$group')";
		$db->query($sql);
	}
	//修改一个考试
	if($op == 'show_edit'){
		$sql_test = 'SELECT * FROM '.tname('test').' WHERE `tid`='.$_GET['tid'];
		$test = $db->fetch_first($sql_test);
		$sql_par = 'SELECT `paid`,`title`,`timeNeed` FROM '.tname('paper').' WHERE `mid`='.$test['mid'];
		$par_arr = $db->fetch_all($sql_par);
		$sql_gro = 'SELECT * FROM '.tname('group');
		$gro_arr = $db->fetch_all($sql_gro);
		$test_gro = explode('#',$test['groupids']);
	}
	if($op == 'edit_test'){
		$paid = $_POST['paper'];
		$stime = $_POST['stime'];
		$etime = $_POST['etime'];
		$group = implode('#', $_POST['groupids']);
		$tid = $_GET['tid']; 
		$sql = "UPDATE ".tname('test')." SET paid='$paid',stime='$stime',etime='$etime',groupids='$group' WHERE tid='$tid'";	
		$db->query($sql);
	}
	//删除一个考试
	if($op == 'del'){
		$tid = $_GET['tid'];
		$db->query('DELETE FROM '.tname('test').' WHERE `tid`='.$tid);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=test&op=display");
	}
?>