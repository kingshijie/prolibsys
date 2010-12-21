<?php
	require '../include/common.inc.php';
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	require PLIB_ROOT.'./include/function_problem.php';
	$op = $_GET['op'];
	//显示单个题目
	if($op == 'show_pro'){
		if(!empty($_GET['pid'])) {
			echo show_problem($_GET['pid']);
		}
	}
	//添加题目时选择题目科目、题型
	if($op == 'add_pro'){
		get_cache('major');
		get_cache('pro_type');
		$major_sel = build_selection($CACHE['major'],'major');
		$pro_type_sel = build_selection($CACHE['pro_type'],'pro_type');
		echo "<form action=\"admincp.php?ac=problem&op=show_add\" method=\"post\">科目：$major_sel<br />题型：$pro_type_sel<br /><input type=\"radio\" name=\"isexer\" value=0 checked=\"checked\">考试题&nbsp;&nbsp;<input type=\"radio\" name=\"isexer\" value=1>练习题<br /><input type=\"submit\" value=\"确定\"></form>";
	}
	//组合题中添加题目时显示添加方式
	if($op == 'show_add_cmb_pro'){
		echo '<div>
			<h1>选择添加方式</h1>
			<a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=chs_cmd_pro&type=new&mid='.$_GET['mid'].'&isexer='.$_GET['isexer'].'\',\'hw\');return false;">新建题目</a>|
			<a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=chs_cmd_pro&type=chs_from_plib\',\'hw\');return false;">从题库中选择</a>
			<div id="hw"></div>
		</div>';	
	}
	//显示试卷添加题目
	if($op == 'show_paper_add_pro'){
		echo '<div>
			<h1>选择添加方式</h1>
			<a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=chs_cmd_pro&type=new&mid='.$_GET['mid'].'&isexer='.$_GET['isexer'].'\',\'hw\');return false;">新建题目</a>|
			<a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=chs_cmd_pro&type=chs_from_plib\',\'hw\');return false;">从题库中选择</a>
			<div id="hw"></div>
		</div>';	
	}
	//显示考试选择科目
	if($op == 'sel_maj'){
		get_cache('major');
		$sel_ma = build_selection($CACHE['major'],'major');
		echo "<form action=\"admincp.php?ac=test&op=show_add\" method=\"post\">科目：$sel_ma<input type=\"submit\" value=\"确定\"></form>";
	}
?>