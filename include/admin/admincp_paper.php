<?php
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	if($op == 'default' || $op == 'display'){
		$count_sql = 'SELECT COUNT(*) FROM '.tname('paper');
		$sql = 'SELECT `paid`,`title`,`timeNeed` FROM '.tname('paper').' ORDER BY `paid` DESC {LMT)';
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
		$knos = $db->fetch_all('SELECT `kid`,`kname` FROM '.tname('knowledge').' WHERE `mid`='.$mid);
		/*$i = 0;
		$show_str .= '<h2>知识点</h2>';
		foreach($knos as $kno){
			$show_str .= "<input type=\"checkbox\" name=\"knos[]\" value=\"$kno[kid]\">$kno[kname]";
			if((++$i) % 8 == 0)
				$show_str .= '<br />';
		}	*/
	}
?>