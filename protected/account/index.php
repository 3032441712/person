<?php 
use Model\Account;
$act = isset($_GET['act']) ? $_GET['act'] : '';
if ($act == 'data') {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    
    if ($page < 1) {
        $page = 1;
    }
    
    if ($limit < 10) {
        $limit = 10;
    }
    
    if ($limit > 50) {
        $limit = 50;
    }
    
    $accountData = Account::getList($page, $limit);
    echo json_encode($accountData);
    exit(0);
}
?>
<div id="account_tb">
    <a href="#" onclick="add_account();" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true">添加</a>
    <a href="#" onclick="edit_account();" class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true">编辑</a>
    <a href="#" onclick="del_account();" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true">删除</a>
</div>
<div id="module-wrap">
    <h2>账户管理</h2>
    <table id="account_grid" style="width: 100%; height: auto;"></table>
</div>
<div id="account_dialog"></div>
<div id="select_dialog"></div>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/app/account.js"></script>