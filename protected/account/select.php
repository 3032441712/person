<?php 
use Model\Account\Cat;

$act = isset($_GET['act']) ? $_GET['act'] : '';
if ($act == 'data') {
    $cats = Cat::getEasyUITreeData();
    echo '[{"id": 0,"text": "根分类","children":'.json_encode($cats).'}]';
    exit(0);
}
?>
<div id="module-wrap">
    <ul id="select_category_tree"></ul>
</div>
<script type="text/javascript">
$('#select_category_tree').tree({
	url:WEB_URL + '/index.php?d=account&f=select&act=data',
	method:'get',
	animate:true,
	formatter:function(node){
		var s = node.text;
		if (node.id > 0) {
			s += '&nbsp;&nbsp;<a href="#" onclick="get_select_category(\'<?php echo $_GET['id']?>\','+node.id+',\''+s+'\');" class="easyui-linkbutton">选择</a>';
		}
		return s;
	}
});
</script>