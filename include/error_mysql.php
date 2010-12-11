<?php
/** 
* 功能：显示错误提示页面
*/ 
$timestamp = time();
$errmsg = '';

$dberror = $this->error();
$dberrno = $this->errno();

if($dberrno == 1114) {

?>
<html>
<head>
<title>达到连接数上限</title>
</head>
<body bgcolor="#FFFFFF">
<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" height="85%">
  <tr align="center" valign="middle">
    <td>
    <table cellpadding="10" cellspacing="0" border="0" width="80%" align="center" style="font-family: Verdana, Tahoma; color: #666666; font-size: 9px">
    <tr>
      <td valign="middle" align="center" bgcolor="#EBEBEB">
        <br /><b style="font-size: 10px">题库系统 达到了登录人数上限</b>
        <br /><br /><br />Sorry, the number of online visitors has reached the upper limit.
        <br />请等待一会儿后重试
        <br /><br />
      </td>
    </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
<?

	exit();

} else {

	if($message) {
		$errmsg = "<b>ProLibSys info</b>: $message\n\n";
	}
	if(isset($GLOBALS['_DSESSION']['discuz_user'])) {
		$errmsg .= "<b>User</b>: ".htmlspecialchars($GLOBALS['_DSESSION']['discuz_user'])."\n";
	}
	$errmsg .= "<b>Time</b>: ".gmdate("Y-n-j g:ia", $timestamp + ($GLOBALS['timeoffset'] * 3600))."\n";
	$errmsg .= "<b>Script</b>: ".$_SERVER['PHP_SELF']."\n\n";
	if($sql) {
		$errmsg .= "<b>SQL</b>: ".htmlspecialchars($sql)."\n";//htmlspecialchars() 函数把一些预定义的字符转换为 HTML 实体
	}
	$errmsg .= "<b>Error</b>:  $dberror\n";
	$errmsg .= "<b>Errno.</b>:  $dberrno";

	echo "</table></table></table></table></table>\n";
	echo "<p style=\"font-family: Verdana, Tahoma; font-size: 11px; background: #FFFFFF;\">";
	echo nl2br(str_replace($GLOBALS['tablepre'], '[Table]', $errmsg));

	if($GLOBALS['adminemail']) {
		$errlog = array();
		if(@$fp = fopen(DISCUZ_ROOT.'./forumdata/dberror.log', 'r')) {
			while((!feof($fp)) && count($errlog) < 20) {
				$log = explode("\t", fgets($fp, 50));
				if($timestamp - $log[0] < 86400) {
					$errlog[$log[0]] = $log[1];
				}
			}
			fclose($fp);
		}

		if(!in_array($dberrno, $errlog)) {
			$errlog[$timestamp] = $dberrno;
			@$fp = fopen(DISCUZ_ROOT.'./forumdata/dberror.log', 'w');
			@flock($fp, 2);
			foreach(array_unique($errlog) as $dateline => $errno) {
				@fwrite($fp, "$dateline\t$errno");
			}
			@fclose($fp);
			if(function_exists('errorlog')) {
				errorlog('MySQL', basename($GLOBALS['_SERVER']['PHP_SELF'])." : $dberror - ".cutstr($sql, 120), 0);
			}

			if($GLOBALS['dbreport']) {
				echo "<br /><br />An error report has been dispatched to our administrator.";
				@sendmail($GLOBALS['adminemail'], '[ProLibSys] MySQL Error Report',
						"There seems to have been a problem with the database of your prolib\n\n".
						strip_tags($errmsg)."\n\n".
						"Please check-up your MySQL server and forum scripts, similar errors will not be reported again in recent 24 hours\n".
						"If you have troubles in solving this problem, please visit prolib Community http://www.prolib.net.");
			}

		} else {
			echo '<br /><br />Similar error report has been dispatched to administrator before.';
		}

	}
	echo '</p>';
	echo '<p style="font-family: Verdana, Tahoma; font-size: 12px; background: #FFFFFF;"><a href="http://faq.prolib.com/?type=mysql&dberrno='.$dberrno.'&dberror='.rawurlencode($dberror).'" target="_blank">&#x5230; http://faq.prolib.com &#x641c;&#x7d22;&#x6b64;&#x9519;&#x8bef;&#x7684;&#x89e3;&#x51b3;&#x65b9;&#x6848;</a></p>';

	exit();

}

?>
