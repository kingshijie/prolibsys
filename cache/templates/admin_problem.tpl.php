<?php if(!defined('IN_PLIB')) exit('Access Denied'); checktplrefresh('/var/www/randy/PHP/prolibsys/templates/default/admin//problem.htm', 1292059508); ?>
<div class="main_header">
<div id="icon-center" class="icon32"><br /></div> 
<h2>题库管理</h2>
</div>
<div class="content">
<div ><a class="show_info" href="./fancybox/fancybox.php?op=add_pro">添加题目</a></div>
<?php if($op == 'default' || $op == 'display') { ?>
<table border="1">
<tr><td>题目id</td><td style="width:500px;">描述</td><td>答案</td><td>类型</td><td>科目</td><td>是否客观</td><td>是否考试题</td><td colspan="2">操作</td></tr><?php if(is_array($pro_arr)) { foreach($pro_arr as $pro) { $pro['description'] = substr($pro['description'],0,80); ?><tr><td><?php echo $pro['pid']; ?></td><td><a  class="pro_des" href="./fancybox/fancybox.php?op=show_pro&amp;pid=<?php echo $pro['pid']; ?>&amp;typeid=<?php echo $pro['typeid']; ?>"><?php echo $pro['description']; ?>...</a></td><td><?php echo $pro['ans']; ?></td><td><?php echo $CACHE['pro_type'][$pro['typeid']]; ?></td><td><?php echo $CACHE['major'][$pro['mid']]; ?></td><td><?php echo $pro['autocheck']?'主观':'客观'; ?></td><td><?php echo $pro['isexer']?'练习':'考试'; ?></td><td><a href="admincp.php?ac=edit&amp;pid=<?php echo $pro['pid']; ?>">编辑</a></td><td><a href="admincp.php?ac=del&amp;pid=<?php echo $pro['pid']; ?>">删除</a></td></tr><?php } } ?></table>
<br />
<!-- 页码显示段 -->
<?php if($page > $page_arr[0]) { ?><a href="admincp.php?ac=problem&amp;page=<?php echo $page-1; ?>">上一页</a><?php } if(is_array($page_arr)) { foreach($page_arr as $no) { if($no != $page) { ?>
<a href="admincp.php?ac=problem&amp;page=<?php echo $no; ?>"><?php echo $no; ?></a>
<?php } else { echo $no; } } } if($page < $no) { ?><a href="admincp.php?ac=problem&amp;page={$page+1}">下一页</a><?php } } elseif($op == 'show_add') { ?>
<form action="admincp.php?ac=problem&amp;op=add_pro&amp;typeid=<?php echo $typeid; ?>" method="post">
<input type="hidden" name="typeid" value="<?php echo $typeid; ?>">
<input type="hidden" name="mid" value="<?php echo $mid; ?>">
<input type="hidden" name="is_exer" value="<?php echo $is_exer; ?>">
<input type="hidden" name="parent" value="<?php echo $parent; ?>"><?php echo show_add_pro($typeid,$mid,$is_exer); ?></form>
<?php } ?>
</div>