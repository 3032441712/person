<?php 
use Model\User;
$act = isset($_GET['act']) ? $_GET['act'] : '';
if ($act == 'data')
{
    $userData = User::getList();
    echo json_encode($userData);
    exit(0);
}
?>
<div id="tb">
    <a href="#" onclick="add_user();" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true">添加</a>
    <a href="#" onclick="edit_user();" class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true">编辑</a>
    <a href="#" onclick="del_user();" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true">删除</a>
</div>
<div id="module-wrap">
    <h2>用户管理</h2>
    <table id="user_grid" style="width: 100%; height: auto;"></table>
</div>
<div id="user_dialog"></div>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/app/user.js"></script>