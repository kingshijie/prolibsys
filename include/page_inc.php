<?php
$perpage = 20;
$page = isset($_GET['page']) ? max(intval($_GET['page']), 1) : 1;
$pagesum = ceil($sum / $perpage);
$displayPages = array();
$left = $page-5;
$right = $page+5;
if ($left < 0)
	$left = 1;
if ($right > $pagesum)
	$right = $pagesum;
for ($i = $left;$i <= $right;$i++){
	$displayPages[$i] = $i;
}
?>
