<?php
define('NOROBOT', TRUE);
define('INPLIBADMIN', TRUE);
require_once './include/common.inc.php';
include_once './fckeditor/fckeditor.php';
if(!getcookie('is_admin')){
	echo "<script language=javascript>alert('您没有权限进行此操作！');location.href='index.html';</script>";
	exit;
}
$tpldir = 'templates/default/admin/';
$styleid ='admin'; //模板id号
$timeout = 60; //模板缓存文件过期时间
$language = include PLIB_ROOT.$tpldir.'/language.php'; //language.php的编码需要和系统的编码一致
$acs = array('index','problem','paper','test','perusal','group','user','major','knowledge');
$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'index':$_GET['ac'];
$op = isset($_GET['op'])?$_GET['op']:'default';

include_once(PLIB_ROOT.'./include/admin/admincp_'.$ac.'.php');
include_once template("default");
include_once template("$ac");

?>
