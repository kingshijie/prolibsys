<?php
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	if($op == 'default' || $op == 'display'){
		$count_sql = 'SELECT COUNT(*) FROM '.tname('paper');
		$sql = 'SELECT `paid`,`title`,`timeNeed`,`mid` FROM '.tname('paper').' ORDER BY `paid` DESC {LMT)';
		$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
		$paper_arr = page_division($count_sql, $sql, $page, $page_arr);
		//获得科目缓存
		get_cache('major');	
	}
	if($op == 'show_add'){
		$block_num = $_POST['block_num'];
		$mid = $_POST['major'];
		$block_arr = array();
		for($i = 1;$i <= $block_num;$i++){
			$block_arr[] = $i;
		}
	}
	if($op == 'add_paper'){
		session_start();
		$mid = $_POST['mid'];
		$timeNeed = $_POST['timeNeed'];
		$block_num = $_POST['block_num'];
		$title = pro_transform($_POST['title']);
		$score = $_POST['score'];
		$paper_des = $block_num;
		for($i = 1;$i <= $block_num;$i++){
			$paper_des .= ($i == 1)?'###':'##';
			$paper_des .= pro_transform($_POST['block_title'.$i]);
			$paper_des .= '#'.pro_transform($_POST['block_des'.$i]);
			$session_pro = 'block'.$i;
			if(is_array($_SESSION[$session_pro]))
				$pro_str = implode('#',$_SESSION[$session_pro]);
			else {
				echo '<script type="text/javascript">alert(\'模块内容为空\');location.href=\'admincp.php?ac=paper&op=display\'</script>';	
			}
			unset($_SESSION[$session_pro]);
			$paper_des .= '#'.$pro_str;
		}
		$paper_des .= '###'.count($score);
		$paper_des .= '###'.implode('#',$score);
		echo $sql = 'INSERT INTO '.tname('paper')." VALUES(NULL,'$title','$paper_des',$timeNeed,$mid)";
		if($db->query($sql)){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: admincp.php?ac=paper&op=display");
		}else{
			echo '- -!插入失败';	
		}
	}
?>