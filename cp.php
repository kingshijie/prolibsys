<?php
require_once './include/common.inc.php';
//允许的方法
$acs = array('index','home','login');
$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'home':$_GET['ac'];
$op = empty($_GET['op'])?'':$_GET['op'];
include_once('./include/cp_'.$ac.'.php');
?>
