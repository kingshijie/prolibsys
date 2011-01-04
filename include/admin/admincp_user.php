<?php
if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}	
		//添加用户
	if($op=='add_user'){
		$username=$_POST['username'];
		if(!empty($_POST['password']) && !empty($_POST['confim_password'])){
			if($_POST['password'] == $_POST['confim_password'])			
				$new_password = encrypt($_POST['password']);
			else {
				$show_message = '两次密码不匹配';
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: admincp.php?ac=user&op=display");
				$op = 'display';
			}
		}
		$uname=$_POST['uname'];

		//在user表中添加记录
		$db->query('INSERT INTO '.tname('user')." VALUES (NULL,'$username','$password','$uname')");
		//在user_group表中添加记录
		$uid=$db->insert_id();
		$db->query('INSERT INTO '.tname('user_group')." VALUES ($uid,$_POST[group])");

		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=user&op=display");
	}
	//编辑用户
	if($op=='edit_user'){
		$uid=$_GET['uid'];
		$user_info = $db->fetch_first('SELECT * FROM '.tname('user').' WHERE `uid`='.$uid);
		$new_username = empty($_POST['new_username'])?$user_info['username']:$_POST['new_username'];
		if(!empty($_POST['new_password']) && !empty($_POST['new_confim_password'])){
			if($_POST['new_password'] == $_POST['new_confim_password'])			
				$new_password = encrypt($_POST['new_password']);
			else {
				$show_message = '两次密码不匹配';
				$op = 'display';
			}
		}else{
			$new_password = $user_info['password'];
		}
		$new_uname = empty($_POST['new_uname'])?$user_info['uname']:$_POST['new_uname'];
		//echo 'UPDATE '.tname('user')." SET username='$new_username', password='$new_password', uname='$new_uname' WHERE uid='$uid'";
		$db->query('UPDATE '.tname('user')." SET username='$new_username', password='$new_password', uname='$new_uname' WHERE uid='$uid'");
		//print_r($_POST);
		if(!empty($_POST['group'])){	
			$db->query('DELETE FROM '.tname('user_group').' WHERE `uid`='.$uid);
			$db->query('INSERT INTO '.tname('user_group').' VALUES('.$uid.','.$_POST['group'].')');
		}
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=user&op=display");	
	}
	//删除用户
	if($op=='delete_user'){
		$uid=$_GET['uid'];
		$db->query('DELETE FROM '.tname('user')." WHERE uid='$uid'");
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: admincp.php?ac=user&op=display");
	}

	if($op=='default'|| $op=='display') {
		$count_sql = 'SELECT COUNT(*) FROM '.tname('user');
		$sql = 'SELECT * FROM '.tname('user').' {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$user_arr = page_division($count_sql, $sql, $page, $page_arr);
		$group = tname('group');
		$user_group = tname('user_group');
		function get_group_name($uid){
			global $group,$user_group,$db;
			$sql = 'SELECT `groupname`,'.$group.'.`groupid` FROM '.$group.','.$user_group.' WHERE `uid`='.$uid.' AND '.$user_group.'.`groupid`='.$group.'.`groupid`';
			return $db->fetch_all($sql);
		}
	}
?>