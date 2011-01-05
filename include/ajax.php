<?php
	require '../include/common.inc.php';
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	$op = $_GET['op'];
	//选择题增加选项
	if($op == 'edit_sel_item'){
		$item_num = checkcookie('item_num')?getcookie('item_num'):0;
		$_GET['do'] == 'add'?$item_num++:$item_num--;
		$str = '';
		for($i = 0;$i < $item_num;$i++){
			$str .= chr(ord('A')+$i).'.<input name=item[] type=text /><a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=edit_sel_item&do=del\',\'items\')">x</a><br />';	
		}
		ssetcookie('item_num',$item_num,600);
		$str .= "<input type=hidden value=$item_num name=opt_num />";
		echo $str;
	}
	//组合题选择添加题目方式
	if($op == 'chs_cmd_pro'){
		get_cache('pro_type');
		$pro_type_sel = build_selection($CACHE['pro_type'],'pro_type');
		$type = $_GET['type'];
		if($type == 'new'){
			echo '<form action="admincp.php?ac=problem&op=show_add" method="post">
			<input type="hidden" name="major" value="'.$_GET['mid'].'" />
			<input type="hidden" name="parent" value="cmd" />
			<input type="hidden" name="isexer" value="'.$_GET['isexer'].'" />选择题型：'.$pro_type_sel.
			'<input type="submit" value="确定"" /></form>';
		}elseif($type == 'chs_from_plib') {
			echo 'Sorry, unavailable now.';
		}
	}
	//搜索题目
	if($op == 'search_pro'){
		$i = $_POST['i'];
		$typeid = $_POST['pro_type'];
		$kno = $_POST['kno'];
		$search_des = $_POST['search_des'];
		$search_des = str_replace(" ","",$search_des);
		$search_des = str_replace("\t","",$search_des);
		$mid = $_POST['mid'];
		$need_kno = empty($kno);
		$tprolib = tname('prolib');
		$tp_k = tname('prolib_knowledge');
		$sql = 'SELECT '.$tprolib.'.`pid`,`description` FROM '.$tprolib.($need_kno?'':','.$tp_k).' WHERE `parent`=0 AND `typeid`='.$typeid.($need_kno?'':' AND '.$tp_k.'.`kid`='.$kno).(empty($search_des)?'':' AND `description` LIKE \'%'.$search_des.'%\'').($need_kno?'':' AND '.$tp_k.'.`pid`='.$tprolib.'.`pid`');
		$result = $db->fetch_all($sql);
		echo '<h2>搜索结果：</h2>';
		foreach($result as $pro){
			$pro['description'] = substr($pro['description'],0,50);
			echo "&nbsp;&nbsp;<input type=checkbox name=pid[] value=$pro[pid] /><a  class=\"pro_des\" href=\"./fancybox/fancybox.php?op=show_pro&pid=$pro[pid]\">$pro[description]...</a><br />";	
		}
		echo '<input type="hidden" name="i" value='.$i.' />';
		echo '<input type="button" value="确定添加" onclick="submitform(document.getElementById(\'result'.$i.'\'),\'./include/ajax.php?op=add_pro2block\',\'show_pro'.$i.'\');set_empty(\'show_op'.$i.'\');return false;">';
	}
	//取题目
	if($op == 'fetch_pro'){
		$i = $_GET['i'];
		get_cache('pro_type');
		$pro_type_sel = build_selection($CACHE['pro_type'],'pro_type');
		$kno_arr = array(0 => '不指定');
		$result = $db->query('SELECT `kid`,`kname` FROM '.tname('knowledge').' WHERE `mid`='.$_GET['mid']);
		while($info = $db->fetch_array($result)){
			$kno_arr[$info['kid']] = $info['kname'];
		}
		$kno_sel = build_selection($kno_arr,'kno');
		$show_str = '<form action="" method="post" id=""><div class="blank"></div></form>';//Firefox第一个form无效，bug?
		$show_str .= '<form action="./include/ajax.php?op=search_pro" method="post" id="search_form'.$i.'">';
		$show_str .= "题型：$pro_type_sel &nbsp;&nbsp; 知识点：$kno_sel &nbsp;&nbsp; ";
		$show_str .= '&nbsp;&nbsp;题目描述关键字：<input type="text" name="search_des" /><input type="hidden" name="mid" value="'.$_GET['mid'].'" /><input type="hidden" name="i" value="'.$i.'" />';
		$show_str .= '&nbsp;&nbsp;<input value="搜索" type="button" onclick="submitform(document.getElementById(\'search_form'.$i.'\'),\'./include/ajax.php?op=search_pro\',\'search_result'.$i.'\');return false;">';
		$show_str .= '</form>';
		$show_str .= '<form action="./include/ajax.php?op=add_pro2block" method="post" id="result'.$i.'">';
		$show_str .= '<div id="search_result'.$i.'"></div>';
		$show_str .= '</form>';
		echo $show_str;
	}
	//将题目加入试卷模块
	if($op == 'add_pro2block'){
		session_start(); 
		$pros = $_POST['pid'];
		$i = $_POST['i'];
		$session_pro = 'block'.$i;
		if(!isset($_SESSION[$session_pro]))
			$_SESSION[$session_pro] = array();
		$pros = array_merge($_SESSION[$session_pro],$pros);
		$_SESSION[$session_pro] = array_unique($pros);
		foreach($_SESSION[$session_pro] as $key => $pid){
			echo '&nbsp;<a title="删除该题" href="javascript://" onclick="makerequest(\'./include/ajax.php?op=del_fetch_pro&pid='.$pid.'&i='.$i.'\',\'show_pro'.$i.'\');return false;">x</a>&nbsp;&nbsp;';
			echo '<input title="输入分值" type="text" name="score[]" style="width:15px"/>';			
			echo ($key+1).')'.show_problem($pid);	
		}
	}
	if($op == 'del_fetch_pro'){
		session_start();
		$pid = $_GET['pid'];
		$i = $_GET['i'];
		$session_pro = 'block'.$i;
		foreach($_SESSION[$session_pro] as $key => $value){
			if($value == $pid){
				unset($_SESSION[$session_pro][$key]);
				break;	
			}	
		}
		if(!empty($_SESSION[$session_pro])){
			$_SESSION[$session_pro] = array_merge($_SESSION[$session_pro],array());
			foreach($_SESSION[$session_pro] as $key => $pid){
				echo '&nbsp;<a title="删除该题" href="javascript://" onclick="makerequest(\'./include/ajax.php?op=del_fetch_pro&pid='.$pid.'&i='.$i.'\',\'show_pro'.$i.'\');return false;">x</a>&nbsp;&nbsp;';
				echo '<input title="输入分值" type="text" name="score[]" style="width:15px"/>';			
				echo ($key+1).')'.show_problem($pid);	
			}
		}else{
			echo '';	
		}
	}
	if($op == 'switch_perusal'){
		$ans_arr = explode('###',$results[$index]['ans']);
		$user_ans = array();
		for($i = 1;$i <= $ans_arr[0];$i++){
			$tmp_user_ans = array();
			$tmp = explode('##',$ans_arr[$i]);
			$tmp_user_ans[$tmp[0]] = explode('#',$tmp[1]);
			$user_ans[] = $tmp_user_ans;
		}	
	}
?>