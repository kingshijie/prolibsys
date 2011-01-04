<?php
	if(!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	
	if($op == 'edit_group'){
			$b = $_POST['groupname'];
			$query = "UPDATE ".tname('group')." SET groupname='$b' WHERE groupid=$_GET[groupid]";
			$result = $db->query($query);
			if($result){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: admincp.php?ac=group&op=display");
			}
	}
	if($op =='delete_group'){
		  echo $query = "DELETE FROM ".tname('group')." WHERE groupid=$_GET[groupid]";
		  $result = $db->query($query);
		  if($result){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: admincp.php?ac=group&op=display");
			}
	}
	if($op == 'add_group'){
		  $n = $_POST["groupname"];
		  echo $query = "INSERT INTO ".tname('group')." VALUES(NULL,'$n')";
		  $result = $db->query($query);
		  if($result){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: admincp.php?ac=group&op=display");
			}
	}
	if ($op == 'default' || $op == 'display'){
		$count_sql = 'SELECT COUNT(*) FROM '.tname('group');
		$sql = 'SELECT * FROM '.tname('group').' {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$group_arr = page_division($count_sql, $sql, $page, $page_arr);
		$op = 'display';
	}
?>