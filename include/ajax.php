<?php
	require '../include/common.inc.php';
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	require PLIB_ROOT.'./include/function_problem.php';
	$op = $_GET['op'];
	//选择题增加选项
	if($op == 'edit_sel_item'){
		$item_num = checkcookie('item_num')?getcookie('item_num'):0;
		$_GET['do'] == 'add'?$item_num++:$item_num--;
		$str = '';
		for($i = 0;$i < $item_num;$i++){
			$str .= chr(ord('A')+$i).'.<input name=item[] type=text /><a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=edit_sel_item&do=del\',\'items\')">x</a><br />';	
		}
		ssetcookie('item_num',$item_num);
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
			<input type="hidden" name="is_exer" value="'.$_GET['is_exer'].'" />选择题型：'.$pro_type_sel.
			'<input type="submit" value="确定"" /></form>';
		}elseif($type == 'chs_from_plib') {
			
		}
	}
?>