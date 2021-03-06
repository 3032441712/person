<?php
/**
 * 用户列表界面
 * 1.列出符合检索规则的用户报表
 * 2.操作功能项:添加 修改 删除.
 *
 * PHP version 5.3
 *
 * @category user
 * @package  user
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
use Model\User;

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

    $userData = User::getList($page, $limit);
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