<?php
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}	
	if($op=='default'|| $op=='display') {
		$count_sql = 'SELECT COUNT(*) FROM '.tname('major');
		$sql = 'SELECT * FROM '.tname('major').' ORDER BY `mid` DESC {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$major_arr = page_division($count_sql, $sql, $page, $page_arr);

		//获得科目缓存
	//	get_cache('major');
			
	}
	//添加科目
	if($op=='add_major'){
		$major_name=$_POST['major_name'];
		$db->query('INSERT INTO '.tname('major')." VALUES (NULL,'$major_name')");
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=major&op=display");
	}
	//编辑科目
	if($op=='edit_major'){
		$mid=$_GET['mid'];
		$new_mname=$_POST['new_mname'];
		$db->query('UPDATE '.tname('major')." SET mname='$new_mname' WHERE mid='$mid'");
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=major&op=display");
	}
	//删除科目
	if($op=='delete_major'){
		$delete_major_id=$_GET['delete_major_id'];
		$db->query('DELETE FROM '.tname('major')." WHERE mid='$delete_major_id'");
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=major&op=display");
	}

?>