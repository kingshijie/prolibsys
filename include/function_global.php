<?php
if(!defined('IN_PLIB')) {
	exit('Access Denied');
}
/////////////////////////////////////////////////////////////
//文件名：global.fun.php
//注  释：
//函数列表：
//1. saddslashes($string)	对sql的一些字符进行转义
//2. isemail($email)		判断邮箱格式
//3. tname($tablename)		获取数据表名（数据表前缀加数据表名）
//4. encrypt($string)		字符串加密
//5. comsubstr($string,$length)	字符串截取函数（截取前$length个字汉字）
//6. comstrag_tags($string)	去除字符串中的html标记
//7. sreadfile($filename)	获取文件内容
//8. swritefile($filename, $writetext, $openmod='w')	写入文件
//9. random($length, $numeric = 0)	产生随机字符串
//10.strexists($haystack, $needle)	判断字符串是否存在
//11.fileext($filename)				获取文件名后缀
//12.dbconnect()					连接数据库
//13.inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0)	添加数据
//14.updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0)		update数据
//15.sreaddir($dir, $extarr=array())	获取某个目录下符合条件的文件名列表
//16.shtmlspecialchars($string)			对$string中的html标签进行替换转义
//17.getrobot()							检查是否为蜘蛛程序
//18.ssetcookie($var,$value,$time)		设置cookie
//19.delcookie($var)					清除cookie
//20.checkcookie($var)					检验cookie
//21.getcookie($var)					获取cookie
//22.getIP()							获取客户端IP
//23.NoRand($begin,$end,$limit=9)		产生不重复的数字
//------------------------------------------------------------------------------------------------------
//24.write_notice($uid,$type,$text)		写新提醒
//25.getusername($uid)					获取指定用户的用户名
//26.isadmin($uid=$cookieuid)			判断一个用户是否为管理员
//27.createEditor()						生成编辑器
/////////////////////////////////////////////////////////////

/** 
* 函数名：function saddslashes($string) 
* 功  能：对sql的一些字符进行转义 
*         对单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符），进行转义
* 参  数：$string：需要转义的字符串 
* 返回值：$string：转义后的结果
*/ 
function saddslashes($string) { 
	if(!MAGIC_QUOTES_GPC){
		if(is_array($string)) { //如果转义的是数组则对数组中的value进行递归转义 
			foreach($string as $key => $val) { 
				$string[$key] = saddslashes($val); 
			} 
		} else { 
			$string = addslashes($string); //对单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符），进行转义 
		} 
		return $string; 
	}else{
		return $string;
	}
} 

/** 
* 函数名：isemail($email) 
* 功  能：判断邮箱格式 
* 参  数：$email：邮箱 
* 返回值：bool：0或1
*/ 
function isemail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

/** 
* 函数名：tname($tablename) 
* 功  能：获取数据表名（数据表前缀加数据表名） 
* 参  数：$tablename：部分数据表名 
* 返回值：$tablename：完整的数据表名
*/ 
function tname($tablename) {
	global $tablepre;
	return $tablepre.$tablename;
}

/** 
*函数名：encrypt($str)
*功  能：字符串加密
*参  数：$str
*返回值：加密后的字符串
*/ 
function encrypt($string){
	$short = substr($string,0,4);
	$string = md5(md5($string).$short);
	return $string;
}

/** 
* 函数名：comsubstr($string,$length)
* 功  能：在一个字符串中截取前$length个字符
* 参  数：$string：待截取的字符串 
*		  $length：需要截取的长度
* 返回值：$string：截取后的字符串
*/ 
function comsubstr($string,$length){
	$length1 = mb_strlen ($string,$charset); 
	if($length>=$length1){
		return $string;
	}else{
		$string = mb_substr($string,0,$length-3,$charset);
		$string.='...';
		return $string;
	}
}

/** 
* 函数名：comstrag_tags($string)
* 功  能：去除字符串中的html标签
* 参  数：$string：待处理的字符串 
* 返回值：$string：处理后的字符串
*/ 
function comstrag_tags($string){
	return strip_tags($string);
}

/** 
* 函数名：sreadfile($filename)
* 功  能：获取文件内容
* 参  数：$filename：	待读取文件的文件名 
* 返回值：$string：		文件内容
*/
function sreadfile($filename) {
	$content = '';
	if(function_exists('file_get_contents')) {
		@$content = file_get_contents($filename);
	} else {
		if(@$fp = fopen($filename, 'r')) {
			@$content = fread($fp, filesize($filename));
			@fclose($fp);
		}
	}
	return $content;
}

/** 
* 函数名：swritefile($filename, $writetext, $openmod='w')
* 功  能：写入文件
* 参  数：$filename：	待写入文件的文件名 
* 		  $string：		文件内容
* 返回值：bool
*/
function swritefile($filename, $writetext, $openmod='w') {
	if(@$fp = fopen($filename, $openmod)) {
		flock($fp, 2);
		fwrite($fp, $writetext);
		fclose($fp);
		return true;
	} else {
		//runlog('error', "File: $filename write error.");
		return false;
	}
}

/** 
* 函数名：random($length, $numeric = 0)
* 功  能：产生随机字符
* 参  数：$length：		要产生的随机字符串长度
* 		  $numeric：	是否为纯数字，当为0是表示非纯数字
* 返回值：$string		随机字符串
*/
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}

/** 
* 函数名：strexists($haystack, $needle)
* 功  能：判断字符串是否存在
* 参  数：$haystack：	查找范围
* 		  $needle：		要查找的内容
* 返回值：bool
*/
function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}

/** 
* 函数名：fileext($filename)
* 功  能：获取文件名后缀
* 参  数：$filename：	待处理的文件名
* 返回值：$string		文件后缀名
*/
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

/** 
* 函数名：dbconnect()
* 功  能：数据库连接
* 参  数：
* 返回值：
*/
function dbconnect() {
	global $dbhost,$dbuser, $dbpw, $dbname,$dbcharset,$db;
	if(empty($db)) {
		$db = new MYSQL_DB;
		$db->connect($dbhost, $dbuser, $dbpw, $dbname, 0, TRUE, $dbcharset);
	}
}

/** 
* 函数名：inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0)
* 功  能：添加数据
* 参  数：$tablename	目标表名（如member）
*		  $insertsqlarr 操作数据（如$member['uid'] = NULL;	$member['email'] = 'aaa@aaa.com';）
*		  $returnid 是否返回刚插入的id
*		  。。。。
* 返回值：insert_id()	插入记录的id
*/
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
	global $db;

	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$db->query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $db->insert_id();
	}
}

/** 
* 函数名：updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0)
* 功  能：更新数据
* 参  数：$tablename	目标表名（如member）
*		  $insertsqlarr 操作数据（如$member['password'] = 123456;	$member['email'] = 'aaa@aaa.com';）
*		  $wheresqlarr	where条件数组（如$member['uid'] = 1;	$member['email'] = 'aaa@aaa.com';）
*		  。。。。
* 返回值：bool
*/
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
	global $db;

	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	//echo 'UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'';
	$db->query('UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'');
	return true;
}

/** 
* 函数名：sreaddir($dir, $extarr=array())
* 功  能：获取某个目录下的所有文件名
* 参  数：$dir		目录名（如 $dir = PLIB_ROOT.'./data/'）
*		  $extarr	文件后缀名
* 返回值：数组
*/
function sreaddir($dir, $extarr=array()) {
	$dirs = array();
	if($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if(!empty($extarr) && is_array($extarr)) {
				if(in_array(strtolower(fileext($file)), $extarr)) {
					$dirs[] = $file;
				}
			} else if($file != '.' && $file != '..') {
				$dirs[] = $file;
			}
		}
		closedir($dh);
	}
	return $dirs;
} 

/** 
* 函数名：shtmlspecialchars($string) 
* 功  能：对$string中的html标签进行替换转义
* 参  数：$string：需要转义的字符串 
* 返回值：$string：转义后的结果
*/ 
function shtmlspecialchars($string) { 
	if(is_array($string)) { //如果转义的是数组则对数组中的value进行递归转义 
		foreach($string as $key => $val) { 
			$string[$key] = shtmlspecialchars($val); 
		} 
	} else { 
		$string = htmlspecialchars($string); //对html标签进行替换，进行转义 
	} 
	return $string; 
} 

/** 
* 函数名：getrobot()
* 功  能：检查是否为蜘蛛程序，定义常量IS_ROBOT
* 参  数：
* 返回值：IS_ROBOT（TRUE or FALSE）
*/
function getrobot() {
	if(!defined('IS_ROBOT')) {
		$kw_spiders = 'Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla';
		$kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
		if(!strexists($_SERVER['HTTP_USER_AGENT'], 'http://') && preg_match("/($kw_browsers)/i", $_SERVER['HTTP_USER_AGENT'])) {
			define('IS_ROBOT', FALSE);
		} elseif(preg_match("/($kw_spiders)/i", $_SERVER['HTTP_USER_AGENT'])) {
			define('IS_ROBOT', TRUE);
		} else {
			define('IS_ROBOT', FALSE);
		}
	}
	return IS_ROBOT;
}

/** 
* 函数名：ssetcookie($var,$value,$time)
* 功  能：设置cookie
* 参  数：$var		变量名
*		  $value	变量值
*		  $time		cookie生存期（单位秒）
* 返回值：
*/
function ssetcookie($var,$value,$time=0){
	global $cookiepre;
	$var=$cookiepre.$var;
	if($time!=0){
		setcookie($var,$value,time()+$time);
	}else{
		setcookie($var,$value);
	}
}

/** 
* 函数名：delcookie($var)
* 功  能：清除cookie
* 参  数：$var	变量名
* 返回值：
*/
function delcookie($var){
	global $cookiepre;
	$var=$cookiepre.$var;
	setcookie($var,'',time()-3600);
}

/** 
* 函数名：checkcookie($var)
* 功  能：检验cookie
* 参  数：$var	变量名
* 返回值：bool
*/
function checkcookie($var){
	global $cookiepre;
	$var=$cookiepre.$var;
	if(isset($_COOKIE[$var])){
		return 1;
	}else{
		return 0;
	}
}

/** 
* 函数名：getcookie($var)
* 功  能：获取cookie
* 参  数：$var	变量名
* 返回值：
*/
function getcookie($var){
	global $cookiepre;
	$var=$cookiepre.$var;
	if(isset($_COOKIE[$var])){
		return $_COOKIE[$var];
	}else{
		return 0;
	}
}

/** 
* 函数名：getIP()
* 功  能：获取客户端IP
* 参  数：
* 返回值：IP
*/
function getIP(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
       else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
       else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
       else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
       else
           $ip = "unknown";
   return($ip);
}

/** 
* 函数名：NoRand($begin,$end,$limit=9)
* 功  能：产生不重复的数字
* 参  数：
* 返回值：
**/
function NoRand($begin,$end,$limit=9){ 
	$rand_array=range($begin,$end); 
	shuffle($rand_array);//调用现成的数组随机排列函数 
	return array_slice($rand_array,0,$limit);//截取前$limit个 
}

//---------------------------------以下是PLIB专属用函数------------------------------

/** 
* 函数名：isCensor($string)
* 功  能：屏蔽字符串中字符
* 参  数：$string：待查字符串
* 返回值：替换好的字符串，返回0为该字符串包含禁用语
**/
function isCensor($string){
	include_once(PLIB_ROOT.'./cache/cache_censor.php');
	if($CACHE['censor']['banned'] && preg_match($CACHE['censor']['banned'], $string)) {
		return 0;
	} else {
		$string = empty($CACHE['censor']['filter']) ? $string :
		@preg_replace($CACHE['censor']['filter']['find'], $CACHE['censor']['filter']['replace'], $string);
	}
	return $string;
}

/** 
* 函数名：unescape($str)
* 功  能：解码ajax压缩的字符串
* 参  数：
* 返回值：
**/
function unescape($str) { 
$str = rawurldecode($str); 
preg_match_all("/(?:%u.{4})|.+/",$str,$r); 
$ar = $r[0]; 
foreach($ar as $k=>$v) { 
if(substr($v,0,2) == "%u" && strlen($v) == 6) 
$ar[$k] = iconv("UCS-2","GB2312",pack("H4",substr($v,-4))); 
} 
return join("",$ar); 
} 

/** 
* 函数名：createEditor($inputName, $inputValue = '',$height='520',$toolbarSet='Default')
* 功  能：生成编辑器
* 参  数：
* 返回值：
**/
function createEditor($inputName, $inputValue = '',$height='520',$toolbarSet='Default',$width='700'){
	global $editor;
    $editor = new FCKeditor($inputName) ;
    $editor->BasePath = "./fckeditor/";
    $editor->ToolbarSet = "Default";
    $editor->Width = $width;
    $editor->Height = $height;
    $editor->Value = $inputValue;
    return $editor->CreateHtml();
}


/** 
* 函数名：
* 功  能：获取规定条数数据
* 参  数：
* 返回值：
**/
function fetch_with_limit($condition,$begin=0,$num=1){
	global $db;
	$result = array();
	$result = $db->fetch_all($condition." LIMIT $begin,$num");
	if (count($result)) return $result;else return 0;
}

/** 
* 函数名：
* 功  能：创建文件夹
* 参  数：
* 返回值：
**/
function createdir($dir)
{
	if(file_exists($dir) && is_dir($dir)){//如果存在这个文件并且这个文件是个目录就不动作
	}else{
	   mkdir($dir,0777);//否则就创造这个目录
	}
}

/** 
* 函数名：
* 功  能：将题目中#转义
* 参  数：
* 返回值：
**/
function pro_transform($str){
	return str_replace('#', '<;^', $str);	
}

/** 
* 函数名：
* 功  能：将题目中#反转义
* 参  数：
* 返回值：
**/
function pro_untransform($str){
	return str_replace('<;^', '#', $str);
}

/** 
* 函数名：
* 功  能：分页函数
* 参  数：$fields--搜索字段名
			$table_name--表名，可为ARRAY或字符
			$start--开始记录
			$where--WHERE子句
			$items_per_page--每页的记录数
			$order--排序规则
* 返回值：
**/
function page_division_sql($fields, $table_name, $start, $where='', $items_per_page=30, $order=''){
	if(is_array($table_name))
		$tables = implode(',', $table_name);
	else 
		$tables = $table_name;
	return "SELECT $fields FROM $tables $where LIMIT $start,$items_per_page $order";
}

/** 
* 函数名：
* 功  能：将{LMT)替换为相应SQL
* 参  数：$sql--用于分页的SQL
			$start--开始页
			$items_per_page--每页记录数
* 返回值：
**/
function add_limit($sql, $start, $items_per_page){
	return str_replace('{LMT)', " LIMIT $start , $items_per_page ", $sql);
}

/** 
* 函数名：
* 功  能：分页函数
* 参  数：$count_sql--计算记录总条数的SQL
			$sql--用于分页的SQL
			$page
			&$page_arr	显示的页 数组
			$perpage
* 返回值：
**/
function page_division($count_sql, $sql, $page, &$page_arr, $items_per_page=20){
	global $db;
	$query = $db->query($count_sql);
	$sum = $db->fetch_array($query,MYSQL_NUM);
	$page_sum = ceil($sum[0] / $items_per_page);
	$left = $page-5;
	$right = $page+5;
	if ($left <= 0)	$left = 1;
	if ($right > $page_sum)	$right = $page_sum;
	for($i = $left;$i <= $right;$i++){
		$page_arr[] = $i;	
	}
	return $db->fetch_all(add_limit($sql, ($page-1)*$items_per_page, $items_per_page));
}

/** 
* 函数名：
* 功  能：生成选择框
* 参  数：$arr key->id,value->值
* 返回值：$str
**/
function build_selection($arr,$name){
	$sel = "<select name=\"$name\">";
	foreach($arr as $key => $value){
		$sel .= "<option value=$key>$value</option>";
	}
	$sel .= '</select>';
	return $sel;
}
//---------------------------------以上是PLIB专属用函数------------------------------
?>
