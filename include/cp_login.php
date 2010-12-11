<?php
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	
	if (count($_POST)){
		get_cache('adminuser');
		$is_admin = false;
		foreach ($CACHE['adminuser'] as $adminuser){
			if($adminuser['username'] == $_POST['username']) {
				$is_admin = true;
				break;	
			}
		}
		if($is_admin){
			if($adminuser['password'] == encrypt($_POST['password'])){
					//admin login success
					ssetcookie('uid',$CACHE['adminuser']['uid']);
					ssetcookie('is_admin',true);
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: admincp.php?ac=index");
					exit;
			}else {
					//wrong pwd	
					$error_message = '密码错误';
			}
		}else {
			$user = $db->fetch_first('SELECT * FROM '.tname('user').' WHERE `username`=\''.$_POST['username'].'\' AND `password`=\''.encrypt($_POST['password']).'\'');
			if(empty($user)){
				//login error	
				$error_message = '用户名或密码错误';
			}else{
				//user login success
				ssetcookie('uid',$user['uid']);
				ssetcookie('is_admin',false);
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: cp.php?ac=home");
				exit;
			}
		}
	}
	include template('login');
?>