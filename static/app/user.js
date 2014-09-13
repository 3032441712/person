$('#user_grid').datagrid({
	url:WEB_URL + '/index.php?d=user&f=index&act=data',
	method:'post',
	pagination:true,
	toolbar:'#tb',
	singleSelect:true,
	columns:[[
        {field:'ck', checkbox:true},
	    {field:'user_name',title:'用户名称',width:180},
	    {field:'user_sex',title:'性别',width:100,align:'center',formatter: function(value,row,index){
	    	return value == 0 ? '女' : '男';
	    }},
	    {field:'user_email',title:'邮箱',width:200},
	    {field:'user_address',title:'地址',width:300},
	    {field:'createtime',title:'创建时间',width:130,align:'center'},
	    {field:'last_login_time',title:'最后登录时间',width:130,align:'center'}
	]],
	loadMsg:'请稍等,正在进行数据加载...'
});

function user_dialog(params)
{
	$('#user_dialog').dialog(params);
}

function get_user_checked()
{
	return $('#user_grid').datagrid('getChecked');
}

function add_user()
{
	var params = {
	    title: '添加用户',
		width: 700,
		height: 260,
		closed: false,
		cache: false,
		href: WEB_URL + '/index.php?d=user&f=add',
		modal: true,
		draggable:false
	};
	user_dialog(params);
}

function edit_user()
{
	var userChecked = get_user_checked();
	if (userChecked.length != 1) {
		$.messager.alert('系统提示','请选择一个要编辑的数据.');
		return false;
	}
	
	var params = {
		title: '编辑用户',
		width: 700,
		height: 260,
		closed: false,
		cache: false,
		href: WEB_URL + '/index.php?d=user&f=add&eid='+userChecked[0].user_id,
		modal: true,
		draggable:false
	};
	user_dialog(params);
}

function del_user()
{
    alert('删除用户');
}

function user_form_submit()
{
    $.post($('#user_form').attr('action'), $('#user_form').serialize(), function(data){
    	var res = eval("("+data+")");
    	if (res.code != 0) {
    		$.messager.alert('系统提示',res.msg);
    	} else {
    		$('#user_grid').datagrid('reload');
    		user_dialog('close');
    	}
    });
}