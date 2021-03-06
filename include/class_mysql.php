<?php
	define(PLIB_ROOT,'./');
/** 
* 类  名：MYSQL_DB

* 功  能：完成与数据库相关的操作 

* 属  性：$version：版本号
		  $querynum：记录成功的请求次数
		  $link：连接标识

* 方  法：连接数据库 
		  connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE, $dbcharset2 = '')
		  
		  选择数据库 
		  select_db($dbname)

		  将查询结果提取为数组 
		  fetch_array($query, $result_type = MYSQL_ASSOC)

		  以数组形势返回查询结果中第一条记录 
		  fetch_first($sql)

		  返回查询结果中第一条记录的第一个单元 
		  result_first($sql)

		  提交一条sql语句返回结果标志符 
		  query($sql, $type = '')

		  返回上次请求所影响的行号
		  affected_rows() 

		  返回MYSQL错误内容 
		  error()

		  返回MYSQL错误编号 
		  errno()

		  取出结果中第$row+1条记录（一个单元） 
		  result($query, $row = 0)

		  返回结果集的行数
		  num_rows($query)

		  返回结果集的列数
		  num_fields($query)

		  释放资源
		  free_result($query)

		  取得最后插入的ID号
		  insert_id()

		  取出一行记录
		  fetch_row($query)

		  从结果集中取得列信息并作为对象返回
		  fetch_fields($query)

		  返回MYSQL版本号
		  version()

		  关闭连接
		  close()
		  
		  SELECT函数
		  selector

		  提示错误信息 
		  halt()
*/

class MYSQL_DB{

	var $version = '';
	var $querynum = 0;
	var $link = null;
	var $result=null;

    /** 
	* 函数名：connect
	* 功  能：连接数据库 
	* 参  数：$dbhost：数据库host名 
			  $dbuser：数据库用户名
			  $dbpw：用户密码
			  $dbname：要连接的数据库名
			  $pconnect：设置是否为永久连接 0为否 1为是
			  $halt：设置是否显示错误信息
	*/ 
	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE, $dbcharset2 = '') {

		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$this->link = @$func($dbhost, $dbuser, $dbpw, 1)) {
			$halt && $this->halt('Can not connect to MySQL server');
		} else {
			if($this->version() > '4.1') {
				global $charset, $dbcharset;
				$dbcharset = $dbcharset2 ? $dbcharset2 : $dbcharset;
				$dbcharset = !$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8')) ? str_replace('-', '', $charset) : $dbcharset;
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $this->link);
			}
			$dbname && @mysql_select_db($dbname, $this->link);//没有传入$dbname则不执行mysql_select_db
		}
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));//!!!!!
	}

	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}

	function fetch_all($sql){
		$rearr = array();
		$this->query($sql);
		while($re = $this->fetch_array($this->result))
			$rearr[] = $re;
		return $rearr;
	}	
			
	/** 
	* 函数名：query 
	* 功  能：对sql的一些字符进行转义
	* 参  数：$sql：请求语句
			  $type：请求类型控制 enum('UNBUFFERED','RETRY','')
	* 返回值：资源标识符
	*/ 
	function query($sql, $type = '') {

		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';//mysql_unbuffered_query()查询的时候不产生结果集合的缓冲
		if(!($query = $func($sql, $this->link))) {
			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {//'RETRY'用以说明是重新连接，只允许重连一次，否则显示错误信息
				$this->close();
				require PLIB_ROOT.'./config.inc.php';
				$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, $dbcharset);
				return $this->query($sql, 'RETRY'.$type);
			} elseif($type != 'SILENT' && substr($type, 5) != 'SILENT') {//$type设置为'SILENT'用以抑制错误信息**substr($type,5)表示输出下标5元素之后的串
				$this->halt('MySQL Query Error', $sql);
			}
		}

		$this->querynum++;
		$this->result = $query;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());//返回mysql错误描述
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());//返回mysql错误编号
	}

	function result($query, $row = 0) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);//注意赋值语句外括号的使用
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->link);
		}
		return $this->version;
	}

	function close() {
		return mysql_close($this->link);
	}

	function selector($what,$table,$where='',$orderby='',$order='',$limit='',$type='') {
		$sql='SELECT '.$what.' FROM '.tname($table);
		if($where)$sql.=' WHERE '.$where;
		if($orderby)$sql.=' ORDER BY '.$orderby.' '.$order;
		if($limit)$sql.=' LIMIT '.$limit;
		//echo $sql;
		return $this->query($sql,$type);
	}

	/** 
	* 函数名：halt 
	* 功  能：退出并提示错误信息 
	* 参  数：$message：错误信息
			  $sql：发生错误的SQL语句
	*/ 
	function halt($message = '', $sql = '') {
		define('CACHE_FORBIDDEN', TRUE);
		require_once PLIB_ROOT.'./include/error_mysql.php';//const
	}
}

?>
