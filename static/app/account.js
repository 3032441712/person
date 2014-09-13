$('#account_grid').datagrid({
	url:WEB_URL + '/index.php?d=account&f=index&act=data',
	method:'post',
	pagination:true,
	toolbar:'#account_tb',
	singleSelect:true,
	columns:[[
        {field:'ck', checkbox:true},
	    {field:'account_title',title:'账户标题',width:180},
	    {field:'cat_title',title:'分类',width:100,align:'center'},
	    {field:'user_name',title:'创建用户',width:200},
	    {field:'createtime',title:'创建时间',width:300}
	]],
	loadMsg:'请稍等,正在进行数据加载...'
});

function account_dialog(params)
{
	$('#account_dialog').dialog(params);
}

function add_account()
{
	var params = {
		title: '添加账户',
		width: 800,
		height: 500,
		closed: false,
		cache: false,
		href: WEB_URL + '/index.php?d=account&f=add',
		modal: true,
		draggable:false
	};
	account_dialog(params);
}

function get_account_checked()
{
	return $('#account_grid').datagrid('getChecked');
}

function edit_account()
{
	var accountChecked = get_account_checked();
	if (accountChecked.length != 1) {
		$.messager.alert('系统提示','请选择一个要编辑的数据.');
		return false;
	}	

	var params = {
		title: '编辑账户',
		width: 800,
		height: 500,
		closed: false,
		cache: false,
		href: WEB_URL + '/index.php?d=account&f=add&eid='+accountChecked[0].account_id,
		modal: true,
		draggable:false
	};
	account_dialog(params);	
}

function del_account()
{
	
}

function select_category(id)
{
	$('#select_dialog').dialog({
		title: '选择分类',
		width: 600,
		height: 300,
		closed: false,
		cache: false,
		href: WEB_URL + '/index.php?d=account&f=select&id='+id,
		modal: true,
		draggable:false
	});
}

function get_select_category(id,cat_id,cat_title)
{
	var obj = $('#'+id);
	obj.val(cat_id);
	obj.next().val(cat_title);
	$('#select_dialog').dialog('close');
}

function account_form_submit()
{
    $.post($('#account_form').attr('action'), $('#account_form').serialize(), function(data){
    	var res = eval('('+data+')');
    	if (res.code != 0) {
    		$.messager.alert('系统提示',res.msg);
    	} else {
    		$('#account_grid').datagrid('reload');
    		account_dialog('close');
    	}
    });
}