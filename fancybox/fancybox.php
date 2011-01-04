<?php
	require '../include/common.inc.php';
	if (!defined('IN_PLIB')) {
		exit('Access Denied');
	}
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
	//打印试卷
	if($op == 'show_paper'){
		$paid = $_GET['paid'];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ../cp.php?ac=home&paid='.$paid);
    }
	//显示考试选择科目
	if($op == 'sel_maj'){
		get_cache('major');
		$sel_ma = build_selection($CACHE['major'],'major');
		echo "<form action=\"admincp.php?ac=test&op=show_add\" method=\"post\">科目：$sel_ma<input type=\"submit\" value=\"确定\"></form>";
	}
	
	/**************************************************************************
	**以下是科目管理的部分
	***************************************************************************
	*/
	//添加科目时，输入科目名称
	if($op=='add_major'){
		echo "<form action=\"admincp.php?ac=major&op=add_major\" method=\"post\">
				科目名：<input type=\"text\" name=\"major_name\" >
				<br /><input type=\"submit\" value=\"确定添加\"></form>";
		
	}
	//编辑科目
	if($op=='edit_major'){
		echo "<form action=\"admincp.php?ac=major&op=edit_major&mid={$_GET['mid']}\" method=\"post\">
				new新的科目名：<input type=\"text\" name=\"new_mname\" >
				<br /><input type=\"submit\" value=\"确定编辑\"></form>";
	}

	
	/**************************************************************************
	**以下是用户管理的部分
	***************************************************************************
	*/
	if($op == 'add_user'){
		$result = $db->query('SELECT * FROM '.tname('group'));
		while($info = $db->fetch_array($result)){
			$group[$info['groupid']] = $info['groupname'];	
		}
		$group_sel = build_selection($group,'group');
		echo "<form action=\"admincp.php?ac=user&op=add_user\" method=\"post\">
					用户名：<input type=\"text\" name=\"username\" ><br>
					用户密码:<input type=\"password\" name=\"password\"><br>
					确认密码:<input type=\"password\" name=\"confim_password\"><br>
					真实名：<input type=\"text\" name=\"uname\" ><br>
					所属的用户组：$group_sel
					<br /><input type=\"submit\" value=\"确定添加\"><br>
				</form>";
	}

	if($op == 'edit_user'){
		$result = $db->query('SELECT * FROM '.tname('group'));
		while($info = $db->fetch_array($result)){
			$group[$info['groupid']] = $info['groupname'];	
		}
		$group_sel = build_selection($group,'group');
		echo '<h3>空着表示不修改</h3>';
		echo "<form action=\"admincp.php?ac=user&op=edit_user&uid={$_GET['uid']}\" method=\"post\">
					用户名：<input type=\"text\" name=\"new_username\" ><br>
					用户密码:<input type=\"password\" name=\"new_password\"><br>
					确认密码:<input type=\"password\" name=\"new_confim_password\"><br>
					真实名：<input type=\"text\" name=\"new_uname\" ><br>
					所属的用户组：$group_sel
					<br /><input type=\"submit\" value=\"确定添加\"><br>
				</form>";
	}
	
	
	/**************************************************************************
	**以下是group管理的部分
	***************************************************************************
	*/
	//添加组时，输入组名称
	if($op=='add_group'){
		echo "<form action=\"admincp.php?ac=group&op=add_group\" method=\"post\">
				组名：<input type=\"text\" name=\"groupname\" >
				<br /><input type=\"submit\" value=\"确定添加\"></form>";
		
	}
	//编辑组
	if($op=='edit_group'){
		echo "<form action=\"admincp.php?ac=group&op=edit_group&groupid={$_GET['groupid']}\" method=\"post\">
				新的组名：<input type=\"text\" name=\"groupname\" >
				<br /><input type=\"submit\" value=\"确定编辑\"></form>";
	}
/*****************************************************************/
	if($op == 'add_knowledge'){
		get_cache('major');
		$major_sel = build_selection($CACHE['major'],'mid');
		echo '<form method="post" action="admincp.php?ac=knowledge&op=know_insert">
   			<p>输入知识点名称:</p>
   			<input type="text" name="kname">
   			<p>选择科目:</p>'.$major_sel.'
  				<input type="submit" name="ok" value="确定">
    			</form> ';
	}
	if($op == 'know_edit'){
		get_cache('major');
		$major_sel = build_selection($CACHE['major'],'mid');
		echo '<form method="post"  action="admincp.php?ac=knowledge&op=know_edit&kid='.$_GET['kid'].'" >
	         <p>输入新的知识点名称:</p>
	  			<input type="text" name="kname">
	 			<p>选择修改的科目:</p>'.$major_sel.'
	  			<br /><input type="submit" name="ok" value="确定">
  				</form>';
	}
?>