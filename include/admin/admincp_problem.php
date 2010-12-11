<?php
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	include PLIB_ROOT.'./include/function_problem.php';
	if($op == 'default' || $op == 'display'){
		$count_sql = 'SELECT COUNT(*) FROM '.tname('prolib');
		$sql = 'SELECT * FROM '.tname('prolib').' ORDER BY `pid` DESC {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$pro_arr = page_division($count_sql, $sql, $page, $page_arr);
		//获得题型缓存
		get_cache('pro_type');
		//获得科目缓存
		get_cache('major');
	}
	if($op == 'show_add'){
		if($_GET['do'] == 'cmd_recover'){
			if(checkcookie('cmd_temp')){
				$tmparr = explode(',', getcookie('cmd_temp'));
			}else{
				exit('Cookie error.');	
			}
			$typeid = $tmparr[0];
			$mid = $tmparr[1];
			$is_exer = $tmparr[2];
			$parent = 'Normal';	
		}else{
			if(!empty($_POST)){
				$mid = $_POST['major'];
				$typeid = $_POST['pro_type'];	
				$is_exer = $_POST['is_exer'];
				$parent = isset($_POST['parent'])?$_POST['parent']:'Normal';
			}
		}
	}
	if($op == 'add_pro'){
		$typeid = $_GET['typeid'];
		echo 'p='.$parent = $_POST['parent'];
		get_cache('pro_type');
		switch($CACHE['pro_type'][$typeid]) {
			case '选择题':
				echo $_POST['opt_num'];
				$description = pro2str_sel($_POST['description'],$_POST['unique'],$_POST['opt_num'],$_POST['item']);
				$ans = strtoupper($_POST['ans']);
				delcookie('item_num');
				//echo 'INSERT INTO '.tname('prolib')." VALUES(NULL,$description,$ans,$_POST[typeid],$_POST[mid],1,$_POST[is_exer])";
				if($db->query('INSERT INTO '.tname('prolib')." VALUES(NULL,'$description','$ans',$_POST[typeid],$_POST[mid],0,$_POST[is_exer])")){
					if(isset($_POST['knos'])){						
						$pid = $db->insert_id();
						$str = '';
						foreach($_POST['knos'] as $kno){
							$str .= ",($pid,$kno)";
						}
						$str[0] = ' ';
						$db->query('INSERT INTO '.tname('prolib_knowledge')." VALUES $str");
					}
					if($parent == 'cmd'){
						if(empty($pid))
							$pid = $db->insert_id();
						if(checkcookie('parent')){
							$pros = explode('@#',getcookie('parent'));	
						}
						$pros[] = $pid;
						ssetcookie('parent',implode('@#',$pros),600);
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: admincp.php?ac=problem&op=show_add&do=cmd_recover");
						exit;
					}
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: admincp.php?ac=problem&op=display");		
				}
				break;
			case '填空题':
				if($db->query('INSERT INTO '.tname('prolib')." VALUES(NULL,'$_POST[description]','$_POST[ans]',$_POST[typeid],$_POST[mid],0,$_POST[is_exer])")){
					if(isset($_POST['knos'])){						
						$pid = $db->insert_id();
						$str = '';
						foreach($_POST['knos'] as $kno){
							$str .= ",($pid,$kno)";
						}
						$str[0] = ' ';
						$db->query('INSERT INTO '.tname('prolib_knowledge')." VALUES $str");
					}
					if($parent == 'cmd'){
						if(empty($pid))
							$pid = $db->insert_id();
						if(checkcookie('parent')){
							$pros = explode('@#',getcookie('parent'));	
						}
						$pros[] = $pid;
						ssetcookie('parent',implode('@#',$pros),600);
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: admincp.php?ac=problem&op=show_add&do=cmd_recover");
						exit;
					}
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: admincp.php?ac=problem&op=display");		
				}
				break;
			case '简答题':
			case '名词解释':
				if($db->query('INSERT INTO '.tname('prolib')." VALUES(NULL,'$_POST[description]','$_POST[ans]',$_POST[typeid],$_POST[mid],0,$_POST[is_exer])")){
					if(isset($_POST['knos'])){						
						$pid = $db->insert_id();
						$str = '';
						foreach($_POST['knos'] as $kno){
							$str .= ",($pid,$kno)";
						}
						$str[0] = ' ';
						$db->query('INSERT INTO '.tname('prolib_knowledge')." VALUES $str");
					}
					if($parent == 'cmd'){
						if(empty($pid))
							$pid = $db->insert_id();
						if(checkcookie('parent')){
							$pros = explode('@#',getcookie('parent'));	
						}
						$pros[] = $pid;
						ssetcookie('parent',implode('@#',$pros),600);
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: admincp.php?ac=problem&op=show_add&do=cmd_recover");
						exit;
					}
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: admincp.php?ac=problem&op=display");		
				}
				break;
			case '组合题':
				$des = pro_transform($_POST['description']);
				$pros = array();
				if(checkcookie('parent')){
					$pros = explode('@#',getcookie('parent'));	
				}
				foreach($pros as $pro){
					$des .= ('#'.$pro);
				}
				if($db->query('INSERT INTO '.tname('prolib')." VALUES(NULL,'$des','',$_POST[typeid],$_POST[mid],0,$_POST[is_exer])")){
					if(isset($_POST['knos'])){						
						$pid = $db->insert_id();
						$str = '';
						foreach($_POST['knos'] as $kno){
							$str .= ",($pid,$kno)";
						}
						$str[0] = ' ';
						$db->query('INSERT INTO '.tname('prolib_knowledge')." VALUES $str");
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: admincp.php?ac=problem&op=display");
					}
				}
				break;
		}	
	}
?>