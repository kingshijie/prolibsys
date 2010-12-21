<?php

// 数据库配置参数

	$dbtype = 'mysql';	// 数据库类型
	$dbhost = 'localhost';	// 数据库地址
	$dbuser = 'root';	// 数据库用户名
	$dbpw = '1111';		// 数据库密码
	$dbname = 'prolib';		// 数据库名
	$tablepre = 'plib_';	// 表前缀
	$dbcharset = 'utf8';	// MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照默认字符集设定

// Cookie设置

	$cookiepre = 'plib_';	//cookie 前缀
	$cookiedomain = '';	// cookie 作用域
	$cookiepath = '/';	// cookie 作用路径

// 页面设置

	$charset = 'utf-8';	// 页面默认字符集, 可选 'gbk', 'big5', 'utf-8'
	

// 系统配置

	define('PLIB_NAME','ProLibSys');	//站点名称
//	define('PLIB_URL','http://localhost/mblog');	//站点URL
	define('PLIB_UPLOAD_PATH','attachments');	//上传文件目录
	define('DEBUG_MODE',true);	//调试模式
   define('PLIB_VERSION',0);	//系统版本

   $tplrefresh = 1; //是否自动更新模板缓存

?>
