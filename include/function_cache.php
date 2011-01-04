<?php

if(!defined('IN_PLIB')) {
	exit('Access Denied');
}

//更新管理员用户缓存
function adminuser_cache(){
	global $db,$CACHE;
	$CACHE['adminuser'] = array();
	$user_tb = tname('user');
	$user_group_tb = tname('user_group');
	$query = $db -> query("SELECT * FROM $user_tb,$user_group_tb WHERE $user_tb . `uid` = $user_group_tb . `uid` AND `groupid` = 1");
	while ($value = $db->fetch_array($query)){
			$CACHE['adminuser'][] = $value;
	}
	cache_write('adminuser','CACHE[\'adminuser\']',$CACHE['adminuser']);
}

//题型缓存
function pro_type_cache(){
	global $db,$CACHE;
	$CACHE['pro_type'] = array();
	$query = $db -> query('SELECT * FROM '.tname('protype'));
	while ($value = $db->fetch_array($query)){
			$CACHE['pro_type'][$value['typeid']] = $value['tname'];
	}
	cache_write('pro_type','CACHE[\'pro_type\']',$CACHE['pro_type']);
}

//科目缓存
function	major_cache(){
	global $db,$CACHE;
	$CACHE['major'] = array();
	$query = $db -> query('SELECT * FROM '.tname('major'));
	while ($value = $db->fetch_array($query)){
			$CACHE['major'][$value['mid']] = $value['mname'];
	}
	cache_write('major','CACHE[\'major\']',$CACHE['major']);
}

//试卷信息缓存
function paper_cache($paid){
	global $db,$CACHE;
	$CACHE['paper'] = array();
	$paper = $db -> fetch_first('SELECT `construction` FROM '.tname('paper').' WHERE `paid`='.$paid);
	$tmp = explode('###',$paper['construction']);
	$blocks = explode('##',$tmp[1]);
	$j = 0;
	$score = explode('#',$tmp[3]);
	foreach($blocks as $block){
		$pros = explode('#',$block);
		print_r($pros);
		for($i = 2;$i < count($pros);$i++){
			$pro_info[$pros[$i]] = get_pro_info($pros[$i]);
			$pro_info[$pros[$i]]['score'] = $score[$j++];
		}
	}
	cache_write('paper'.$paid,'CACHE[\'paper\']',$pro_info);
}

//清空模板文件
function tpl_cache() {
	$dir = PLIB_ROOT.'./cache/data_cache/';
	$files = sreaddir($dir);
	foreach ($files as $file) {
		@unlink($dir.'/'.$file);
	}
}

//递归清空目录
function deltreedir($dir) {
	$files = sreaddir($dir);
	foreach ($files as $file) {
		if(is_dir("$dir/$file")) {
			deltreedir("$dir/$file");
		} else {
			@unlink("$dir/$file");
		}
	}
}

/** 
* 函数名：function arrayeval(array $array,int $level)
* 功  能：将数组转为字符转
* 参  数：$array:待转化字符 $level：行前制表符个数
* 返回值：转化好的字符串
*/ 
function arrayeval($array, $level = 0) {
	$space = '';
	for($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$evaluate = "Array\n$space(\n";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",\n$space";
	}
	$evaluate .= "\n$space)";
	return $evaluate;
}

/** 
* 函数名：function cache_write(string $name, string $var, array $values)
* 功  能：写入缓存
* 参  数：$name:缓存文件名（前缀为data）$var：参数名 $values:需写入的数组
* 返回值：无
*/ 
function cache_write($name, $var, $values) {
	$cachefile = PLIB_ROOT.'./cache/data_cache/data_'.$name.'.php';
	$cachetext = "<?php\r\n".
		"if(!defined('IN_PLIB')) exit('Access Denied');\r\n".
		'$'.$var.'='.arrayeval($values).
		"\r\n?>";
	if(!swritefile($cachefile, $cachetext)) {
		exit("File: $cachefile write error.");
	}
}

/** 
* 函数名：get_cache($name)
* 功  能：取缓存
* 参  数：$name:缓存文件名（前缀为data）$var：参数名 $values:需写入的数组
			$addition = 0 ;额外参数，可选
* 返回值：无
*/ 
function get_cache($name, $addition = 0){
	global $CACHE;
	if($addition){
		if(!file_exists(PLIB_ROOT."./cache/data_cache/data_$name".$addition.".php")){
			$cache_name = $name.'_cache';
			$cache_name($addition);
		}else{
			include_once PLIB_ROOT."./cache/data_cache/data_$name".$addition.".php";
		}
	}else{
		if(!file_exists(PLIB_ROOT."./cache/data_cache/data_$name.php")){
			$cache_name = $name.'_cache';
			$cache_name();
		}else{
			include_once PLIB_ROOT."./cache/data_cache/data_$name.php";
		}
	}
}

/** 
* 函数名：get_cache($name)
* 功  能：取缓存
* 参  数：$name:缓存文件名（前缀为data）$var：参数名 $values:需写入的数组
* 返回值：无
*/ 
function update_cache($name){
	global $CACHE;
	$cache_name = $name.'_cache';
	$cache_name();
}
?>
