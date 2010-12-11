<?php
//error_reporting(0);	////禁用错误报告
$mtime = explode(' ', microtime());	//处理当前时间
$mblog_starttime = $mtime[1] + $mtime[0];//处理当前时间

define('IN_PLIB', TRUE);
define('PLIB_ROOT', substr(dirname(__FILE__), 0, -7));
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());		//获取系统配置（是否关闭自动转义）

//php旧版本支持
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}

//基本文件
if(!@include_once(PLIB_ROOT.'./config.inc.php')){
	header("Location: install/index.php");//安装
	exit();
}

require_once PLIB_ROOT.'./include/function_global.php';
require_once PLIB_ROOT.'./include/function_cache.php';
require_once PLIB_ROOT.'./include/function_template.php';
require_once PLIB_ROOT.'./include/class_mysql.php';


//限制蜘蛛程序访问
getrobot();
if(defined('NOROBOT') && IS_ROBOT) {
	exit(header("HTTP/1.1 403 Forbidden"));
}

//GPC过滤
if(!MAGIC_QUOTES_GPC) {
	$_GET = saddslashes($_GET);
	$_POST = saddslashes($_POST);
	$_COOKIE = saddslashes($_COOKIE);
}

//获取cookie
$cookieuid = getcookie('uid');
$cookieusername = getcookie('username');

//链接数据库
dbconnect();

//$editor = '';//编辑器初始化 

$tpldir = './templates/default'; //模板文件目录
$styleid = 1; //模板id号
$timeout = 60; //模板缓存文件过期时间
$language = include PLIB_ROOT.$tpldir.'/language.php'; //language.php的编码需要和博客系统的编码一致
?>
