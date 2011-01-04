<?php
	if(!defined('IN_PLIB')) {
		exit('Access Denied');
	}
	if ($op == 'default' || $op == 'display'){
		$knowledges = array();
		$result = $db->query('SELECT * FROM '.tname('knowledge'));
		while($info = $db->fetch_array($result)) {
			$knowledges[] = $info; 
			//print_r($info);
		}
		get_cache('major');
		$op = 'display';
	}
	if($op == 'know_edit'){
	   $know = $_POST["kname"];
		$major = $_POST["mid"];
		$query = "UPDATE ".tname('knowledge')." SET kname='$know',mid='$major' WHERE kid=$_GET[kid]";
		$result1 = $db->query($query);
	   if($result1){
   		header("HTTP/1.1 301 Moved Permanently");
			header("Location: admincp.php?ac=knowledge&op=display");
   	}else 
		echo "update failed!<br>";
	}
	if($op == 'know_insert'){
		$know = $_POST["kname"];
		$major = $_POST["mid"];
		$query = "INSERT INTO ".tname('knowledge')." VALUES(NULL,'$know','$major')";
		$result2 = $db->query($query);
		if($result2){
   		header("HTTP/1.1 301 Moved Permanently");
			header("Location: admincp.php?ac=knowledge&op=display");
   	}else
		echo "insert failed!<br>";
		}
   if($op == 'know_delete'){
   	$query = "DELETE FROM ".tname('knowledge')." WHERE kid=$_GET[kid]";
   	$result3 = $db->query($query);
   	if($result3){
   		header("HTTP/1.1 301 Moved Permanently");
			header("Location: admincp.php?ac=knowledge&op=display");
   	}else 
   	echo "delete failed!<br>";
   	}
?>