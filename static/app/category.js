$('#category-true').tree({
	url:WEB_URL + '/index.php?d=account&f=category&act=data',
	method:'get',
	animate:true,
	formatter:function(node){
		var s = node.text;
		s += '&nbsp;&nbsp;<a href="#" onclick="add_cat('+node.id+');" class="easyui-linkbutton">添加</a>';
		if (node.id != 0) {
			s += '&nbsp;&nbsp;<a href="#" onclick="edit_cat('+node.id+');" class="easyui-linkbutton">编辑</a>';
			s += '&nbsp;&nbsp;<a href="#" onclick="del_cat('+node.id+');" class="easyui-linkbutton">删除</a>';			
		}
		return s;
	}
});

function category_dialog(params)
{
	$('#category_dialog').dialog(params);
}

function add_cat(id)
{
    var params = {
        title: '添加分类',
        width: 500,
        height: 200,
        closed: false,
        cache: false,
        href: WEB_URL + '/index.php?d=account&f=add_category&act=add&parent_id='+id,
        modal: true,
        draggable:false
    };
    category_dialog(params);
}

function edit_cat(id)
{
    var params = {
            title: '添加分类',
            width: 500,
            height: 200,
            closed: false,
            cache: false,
            href: WEB_URL + '/index.php?d=account&f=add_category&act=edit&cat_id='+id,
            modal: true,
            draggable:false
        };
        category_dialog(params);
}

function del_cat(id)
{
	$.messager.confirm('系统提示', '确定删除该分类吗?', function(r){
		if (r){
			$.post(WEB_URL + '/index.php?d=account&f=add_category&act=delete&cat_id='+id, {a:'1'}, function(data){
				var res = eval("("+data+")");
				if (res.code != 0) {
					$.messager.alert('系统提示',res.msg);
				} else {
					$('#category-true').tree('reload');
				}
			});
		}
	});	
}

function category_form_submit()
{
    $.post($('#category_form').attr('action'), $('#category_form').serialize(), function(data){
    	var res = eval('('+data+')');
    	if (res.code != 0) {
    		$.messager.alert('系统提示',res.msg);
    	} else {
    		category_dialog('close');
    		$('#category-true').tree('reload');
    	}
    });
}