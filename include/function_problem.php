<?php
if(!defined('IN_PLIB')) {
	exit('Access Denied');
}
/*///////////////////////////////////////////////////////////
文件名：global.fun.php
注  释：各种题型的解析与生成操作
函数列表：
1.pro2str_sel($description,$unique,$option)	//选择题转为字符串
2.str2pro_sel($str)	//字符串转为选择题
3.pro2str_fil($description)	//填空题转为字符串
4.str2pro_fil($str)	//字符串转为填空题
5.pro2str_saq()	//简答题转为字符串
6.str2pro_saq()	//字符串转为简答题
7.pro2str_cmb($description,$pids)	//组合题转为字符串
8.str2pro_cmb($str)	//字符串转为组合题
9.show_problem($name)  // 打印题目
10.show_add_pro($typeid, $mid, $isexer=0)  //显示对题目的操作(add,edit)
11.show_eidt_pro($pid)
//////////////////////////////////////////////////////////*/
/** 
* 函数名：function pro2str_sel($description,$unique,$options) 
* 功  能：选择题转为字符串
* 参  数：$description		题目描述
			$unique			是否单选
			$opt_num			选项个数
			$option			选项
* 返回值：$string：转换成的字符串
*/ 
function pro2str_sel($description,$unique,$opt_num,$options){
	return pro_transform($description).'#'.$unique.'#'.$opt_num.'#'.implode('#', pro_transform($options));
}

/** 
* 函数名：function str2pro_sel($str) 
* 功  能：字符串转为选择题
* 参  数：$str	待转字符串
* 返回值：$array：转换成的题目数组
*/ 
function str2pro_sel($str){
	return pro_untransform(explode('#', $str));	
}

//填空题转化为题目
function str2pro_fil($str){
	return pro_untransform(str_replace('#','<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>',$str));	
}

//简答题转化为题目
function str2pro_saq($str){
	return $str;
}

//组合题转化为题目
function str2pro_cmb($str){
	return pro_untransform(explode('#', $str));
}
/** 
* 函数名：function show_problem($des, $typeid)
* 功  能：打印题目
* 参  数：$name 能唯一确定该题的名称，一般为pid
* 返回值：$show_str 显示题目的静态代码
*/ 
function show_problem($name){
	global $CACHE,$db;
	get_cache('pro_type');
	$pro_info = $db->fetch_first('SELECT `description`,`typeid` FROM '.tname('prolib').' WHERE `pid`='.$name);
	$des = str_ireplace("\r",'<br>',$pro_info['description']);
	$typeid = $pro_info['typeid'];
	switch($CACHE['pro_type'][$typeid]) {
		case '选择题':
			$problem = str2pro_sel($des);
			$show_str = "$problem[0]<br />";
			$input_type = ($problem[1] == 1)?'radio':'checkbox';
			$arr = ($problem[1] == 1)?'':'[]';
			for($i = 3;$i < 3 + $problem[2];$i++){	
				$show_str .= chr($i+62).'<input type = '.$input_type.' name = '.$name.$arr.' value='.chr($i+62).' />'.$problem[$i].'<br />';
			}
			return $show_str;
		case '填空题':
			$problem = str2pro_fil($des);
			$show_str = "$problem<br />";
			$show_str .= "<textarea cols=\"40\" rows=\"5\" name=\"$name\"></textarea><br />";
			return $show_str;
		case '简答题':
		case '名词解释':
			$problem = str2pro_saq($des);
			$show_str = "$problem<br />";
			$show_str .= "<textarea cols=\"40\" rows=\"5\" name=\"$name\"></textarea><br />";
			return $show_str;
		case '组合题':
			$problem = str2pro_cmb($des);
			$show_str = "$problem[0]<br />";
			for($i = 1;$i < count($problem);$i++){
				$show_str .= '&nbsp;&nbsp;('.$i.')'.show_problem($problem[$i]);
			}
			return $show_str;
		default:
			return false;
	}
}

/** 
* 函数名：function show_add_pro($typeid, $mid, $isexer=0)
* 功  能：打印题目
* 参  数：$typeid 题型号
			$mid 科目
			$isexer 默认为0
* 返回值：$show_str 显示题目的静态代码
*/ 
function show_add_pro($typeid, $mid, $isexer=0){
	global $CACHE,$db;
	get_cache('pro_type');
	$show_str = '';
	switch($CACHE['pro_type'][$typeid]) {
		case '选择题':
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述</h2><textarea rows=4 cols=80 name=description></textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>选项&nbsp;<font color="red">(请选择好合适的选项数后再开始填内容)</font></h2><div id=items></div><br />';
			$show_str .= '<a href="javascript://" onclick="makerequest(\'./include/ajax.php?op=edit_sel_item&do=add\',\'items\')">添加选项</a><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>答案&nbsp;<font color="red">(多选时各项以#隔开)</font></h2><textarea rows=4 cols=80 name=ans></textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>是否单选</h2><input type="radio" name="unique" value="1" checked="checked">单选<input type="radio" name="unique" value="0">多选<br />';
			break;
		case '填空题':
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述&nbsp;<font color="red">(空格请以#代替)</font></h2><textarea rows=4 cols=80 name=description></textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>答案&nbsp;<font color="red">(多个空时各项以#隔开)</font></h2><textarea rows=4 cols=80 name=ans></textarea><br />';
			break;
		case '简答题':
		case '名词解释':
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述</h2><textarea rows=4 cols=80 name=description></textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>答案</h2><textarea rows=4 cols=80 name=ans></textarea><br />';
			break;
		case '组合题':
			ssetcookie('cmd_temp',$typeid.','.$mid.','.$isexer,1800);
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述</h2><textarea id=cmd_des rows=4 cols=80 name=description onblur="SetCookie(\'cmd_con\',this.value);"></textarea><br />';
			$show_str .= '<script type="text/javascript">document.getElementById(\'cmd_des\').value = getCookie(\'cmd_con\');</script>';//js自动填充描述
			$show_str .= '<hr />';
			$show_str .= '<a class="show_info" href="./fancybox/fancybox.php?op=show_add_cmb_pro&mid='.$mid.'&isexer='.$isexer.'">问题添加</a><br />';
			$pros = array();
			if(checkcookie('parent')){
				$pros = explode('@#',getcookie('parent'));	
			}
			foreach($pros as $key => $pro){
				$show_str .= ($key+1).')'.show_problem($pro);
			}
			break;
		default:
			return false;
	}
	$show_str .= '<hr />';
	$knos = $db->fetch_all('SELECT `kid`,`kname` FROM '.tname('knowledge').' WHERE `mid`='.$mid);
	$i = 0;
	$show_str .= '<h2>知识点</h2>';
	foreach($knos as $kno){
		$show_str .= "<input type=\"checkbox\" name=\"knos[]\" value=\"$kno[kid]\">$kno[kname]";
		if((++$i) % 8 == 0)
			$show_str .= '<br />';
	}
	$show_str .= '<hr /><input type="submit" value="提交到题库" style="width:400px;" onclick="delCookie(\'cmd_des\')">';
	return $show_str;
}

/** 
* 函数名：function show_edit_pro($typeid, $mid, $isexer=0)
* 功  能：打印题目
* 参  数：$typeid 题型号
			$mid 科目
			$isexer 默认为0
* 返回值：$show_str 显示题目的静态代码
*/ 
function show_edit_pro($pid){
	global $CACHE,$db;
	get_cache('pro_type');
	$proedit = $db->fetch_first('SELECT * FROM '.tname('prolib').' WHERE `pid`='.$pid);
	$show_str = '
		<input type="hidden" name="typeid" value="'.$proedit['typeid'].'">
		<input type="hidden" name="mid" value="'.$proedit['mid'].'">
		<input type="hidden" name="isexer" value="'.$proedit['isexer'].'">';
	switch($CACHE['pro_type'][$proedit['typeid']]) {
		case '选择题':
			$problem = str2pro_sel($proedit['description']);
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述</h2><textarea rows=4 cols=80 name=description>'.$problem[0].'</textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>选项</h2><div id=items>';
			$item_num = $problem[2];
			for($i = 0;$i < $item_num;$i++){
				$show_str .= chr(ord('A')+$i).'.<input name=item[] type=text value='.$problem[3+$i].' /><br />';	
			}
			$show_str .= "<input type=hidden value=$item_num name=opt_num />";
			$show_str .= '</div><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>答案&nbsp;<font color="red">(多选时各项以#隔开)</font></h2><textarea rows=4 cols=80 name=ans>'.$proedit['ans'].'</textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>是否单选</h2><input type="radio" name="unique" value="1" '.($problem[1]?'checked="checked"':'').'>单选<input type="radio" name="unique" value="0"'.($problem[1]?'':'checked="checked"').'>多选<br />';
			break;
		case '填空题':
			$problem = str2pro_fil($proedit['description']);
			$show_str .= '<h2>原题</h2><p>'.$problem.'</p>';
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述&nbsp;<font color="red">(空格请以#代替)</font></h2><textarea rows=4 cols=80 name=description>'.$proedit['description'].'</textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>答案&nbsp;<font color="red">(多个空时各项以#隔开)</font></h2><textarea rows=4 cols=80 name=ans>'.$proedit['ans'].'</textarea><br />';
			break;
		case '简答题':
		case '名词解释':
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述</h2><textarea rows=4 cols=80 name=description>'.$proedit['description'].'</textarea><br />';
			$show_str .= '<hr />';
			$show_str .= '<h2>答案</h2><textarea rows=4 cols=80 name=ans>'.$proedit['ans'].'</textarea><br />';
			break;
		case '组合题':
			ssetcookie('cmd_temp',$proedit['pid'].','.$proedit['typeid'],1800);
			$problem = str2pro_cmb($proedit['description']);
			$show_str .= '<hr />';
			$show_str .= '<h2>题目描述</h2><textarea id=cmd_des rows=4 cols=80 name=description onblur="SetCookie(\'cmd_con\',this.value);">'.$problem[0].'</textarea><br />';
			$show_str .= '<hr />';
			//$show_str .= '<a class="show_info" href="./fancybox/fancybox.php?op=show_add_cmb_pro&mid='.$proedit['mid'].'&isexer='.$proedit['isexer'].'&turn=edit">问题添加</a><br />';
			$pros_str = $problem[1];
			$show_str .= '1)'.show_problem($problem[1]);		
			for($i=2;$i < count($problem);$i++){
				$pros_str .= '@#'.$problem[$i];	
				$show_str .= $i.')'.show_problem($problem[$i]);
			}
			ssetcookie('parent',$pros_str,600);
			break;
		default:
			return false;
	}
	$show_str .= '<hr />';
	$knos = $db->fetch_all('SELECT `kid`,`kname` FROM '.tname('knowledge').' WHERE `mid`='.$proedit['mid']);
	$query = $db->query('SELECT `kid` FROM '.tname('prolib_knowledge').' WHERE `pid`='.$pid);
	$pro_knos = array();
	while($info = $db->fetch_array($query)){
		$pro_knos[] = 	$info['kid'];
	}
	$i = 0;
	$show_str .= '<h2>知识点</h2>';
	foreach($knos as $kno){
		$show_str .= "<input type=\"checkbox\" name=\"knos[]\" value=\"$kno[kid]\"".(in_array($kno['kid'],$pro_knos)?'checked="checked"':'').">$kno[kname]";
		if((++$i) % 8 == 0)
			$show_str .= '<br />';
	}
	$show_str .= '<hr /><input type="submit" value="提交到题库" style="width:400px;">';
	return $show_str;
}
/** 
* 函数名：function get_pro_info($pid)
* 功  能：获取题目信息
* 参  数：
* 返回值：$show_str 显示题目的静态代码
*/ 
function get_pro_info($pid){
	global $db,$CACHE;
	get_cache('pro_type');
	$pro = $db->fetch_first('SELECT `description`,`ans`,`typeid`,`autocheck` FROM '.tname('prolib').' WHERE `pid`='.$pid);
	switch($CACHE['pro_type'][$pro['typeid']]) {
		case '选择题':
			$problem = str2pro_sel($pro['description']);
			$pro['description'] = $problem[0];
			$pro['ans'] = explode('#',$pro['ans']);
			break;
		case '填空题':
			$problem = str2pro_fil($pro['description']);
			$pro['description'] = $problem;
			$pro['ans'] = explode('#',$pro['ans']);
			break;
		case '简答题':
		case '名词解释':
			break;
		case '组合题':
			$problem = str2pro_cmb($pro['description']);
			$pro['description'] = $problem[0];
			$pro['ans'] = array();
			for($i = 1;$i < count($problem);$i++){
				$pro['ans'][] = get_pro_info($problem[$i]);
			}
			break;
		default:
			echo 'Undefined problem type.';
			return false;
	}
	return $pro;
}
?>