<?php
	if($op == 'default' || $op == 'display'){
		get_cache('major');
		$now = date("Y-m-d H:i:s");
		//$tests = $db->fetch_all('SELECT * FROM '.tname('test').' WHERE `etime`<\''.$now.'\'');
		$count_sql = 'SELECT COUNT(*) FROM '.tname('test').' WHERE `etime`<\''.$now.'\'';
		$sql = 'SELECT * FROM '.tname('test').' WHERE `etime`<\''.$now.'\' ORDER BY `etime` DESC {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$tests = page_division($count_sql, $sql, $page, $page_arr);
		//print_r($tests);
	}	
	if($op == 'choose_pro'){
		$paid = $_GET['paid'];
		$tid = $_GET['tid'];
		get_cache('paper',$paid);
	}
	if($op == 'set_cookie'){
		$tid = $_POST['tid'];
		$pros = $_POST['pro'];
		ssetcookie('perusal_pros',implode('@#',$pros),1800);
		ssetcookie('tid',$tid,1800);
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ./admincp.php?ac=perusal&op=perusal');
	}
	if($op == 'perusal'){
		if(checkcookie('tid')){
			$tid = getcookie('tid');	
		}else{
			echo '<script type="text/javascript">alter(\'获取试卷id错误\');location.href="./admincp.php?ac=perusal&op=display"</script>';
		}
		if(checkcookie('perusal_pros')){
			$pros = explode('@#',getcookie('perusal_pros'));
		}else{
			echo '<script type="text/javascript">alter(\'获取试题id错误\');location.href="./admincp.php?ac=perusal&op=display"</script>';
		}
		if(!empty($_POST['']))
		$groups = $db->fetch_first('SELECT `groupids` FROM '.tname('test').' WHERE tid='.$tid);
		$group_arr = explode('#',$groups['groupids']);
		$group_index = empty($_GET['group'])?0:$_GET['group'];
		$groupname = $db->fetch_first('SELECT `groupname` FROM '.tname('group').' WHERE `groupid`='.$group_arr[$group_index]);
		$results = $db->fetch_all('SELECT `rid`,`ans` FROM '.tname('result').' WHERE `tid`= '.$tid.' AND '.tname('result').'.`uid` IN (SELECT '.tname('user_group').'.`uid` FROM '.tname('user_group').' WHERE `groupid`='.$group_arr[$group_index].')');
		$ans_arr = array();
		foreach($results as $result){
			$tmp = explode('###',$result['ans']);
			for($i = 1;$i <= $tmp[0];$i++){
				$tmp2 = explode('##',$tmp[$i]);
				$ans_arr[$result['rid']][$tmp2[0]] = $tmp2[1];
			}	
		}
	}
	if($op == 'set_score'){
		if(!empty($_POST)){
			//unfinished
		}	
	}
?>