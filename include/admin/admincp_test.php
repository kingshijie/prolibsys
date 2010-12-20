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
	}
	//添加考试
	if($op == 'add_test'){
		echo '<div>添加</div>';
	}
	//修改一个考试
	if($op == 'edit_test'){
		echo '<div>e</div>';
	}
	//删除一个考试
	if($op == 'del'){
		$tid = $_GET['tid'];
		$db->query('DELETE FROM '.tname('test').' WHERE `tid`='.$tid);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=test&op=display");
	}
?>