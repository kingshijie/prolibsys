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
				ssetcookie('uname',$user['uname']);
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
				$now = date("Y-m-d H:i:s");
				$tests = $db->fetch_all('SELECT `tid`,`groupids` FROM '.tname('test').' WHERE `stime`<=\''.$now.'\' AND `etime`>=\''.$now.'\'');
				//print_r($tests);
				$group = $db->fetch_first('SELECT `groupid` FROM '.tname('user_group').' WHERE `uid`='.$user['uid']);//此处为简化，默认一个用户一个用户组，以后再改
				if(!empty($group)){
					foreach($tests as $test){
						if(in_array($group['groupid'],explode('#',$test['groupids']))){
							$tid = $test['tid'];
							break;	
						}
					}
				}
				if(empty($tid)){
					//No test found now
					$error_message = '当前没有您的考试';
				}else{
					//user login success
					ssetcookie('uid',$user['uid']);
					ssetcookie('is_admin',false);
					ssetcookie('uname',$user['uname']);
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: cp.php?ac=home&tid=$tid");
					exit;
				}
			}
		}
	}
	include template('login');
?>