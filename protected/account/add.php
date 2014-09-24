<?php 
use Model\Account;
use Encrypt\Data;

$act = isset($_GET['act']) ? $_GET['act'] : '';
$eid = isset($_GET['eid']) ? $_GET['eid'] : 0;
//实例化加密模块
$encrypt = new Data(APP_SYSTEM_SECRET_KEY);

if ($act == 'save') {
    $accountPost = isset($_POST['account']) && is_array($_POST['account']) ? $_POST['account'] : '';
    $data = array(
    	'account_title' => isset($accountPost['title']) ? $accountPost['title'] : '',
        'account_cat' => isset($accountPost['cat_id']) ? $accountPost['cat_id'] : '',
        'account_content' => isset($accountPost['content']) ? $accountPost['content'] : '',
        'user_id' => $_SESSION['user_id']
    );
    
    $data = array_map('trim', $data);

    if (Account::isCat($data['account_cat']) == false) {
        echo '{"code":"1","msg":"选择的分类有误,请重新选择."}';
        exit(0);
    }
    
    if (Account::isAccountTitle($data['account_title']) == false) {
        echo '{"code":"1","msg":"输入的帐号标题有误,请重新输入."}';
        exit(0);
    }

    $data['account_content'] = $encrypt->encode($data['account_content']);
    if ($eid > 0) {
    	$account = Account::getAccountById($eid, '*');
    	if (isset($account['account_id']) == false) {
    	    echo '{"code":"1","msg":"要更新的数据没有被找到"}';
    	    exit(0);
    	}
    	
    	foreach ($data as $k => $v) {
    		if ($account[$k] == $v) {
    			unset($data[$k]);
    		}
    	}
    	
    	if (count($data) < 1) {
    		echo '{"code":"1","msg":"数据没有更改"}';
    		exit(0);
    	}
    	
    	Account::update($data, $eid);
    } else {
        Account::insert($data);
    }
    
    echo '{"code":"0","msg":"数据更新成功"}';
	exit(0);
}

$buttonTitle = ($eid > 0 ? '编辑' : '添加');
if ($eid > 0) {
    $accountData = Account::getAccountById($eid, '*');
    $accountData['account_content'] = $encrypt->decode($accountData['account_content']);
} else {
    $accountData = Account::getTableAttribute();
    $accountData['cat_title'] = '请选择一个分类';
}
?>
<form id="account_form" method="post" action="<?php echo WEB_URL . '/index.php?d=account&f=add&act=save&eid='.$eid?>">
<div id="form_wrap">
    <div class="field_line">
        <label>分类</label>
        <input id="account_cat_id" name="account[cat_id]" readonly="readonly" style="width:50px;text-align:center;" value="<?php echo $accountData['account_cat']?>" />
        <input style="width:500px;text-align:center;" value="<?php echo $accountData['cat_title']?>" disabled="disabled" />
        <a href="#" onclick="select_category('account_cat_id')" style="display: inline-block; width: 33px; text-decoration: none;">选择</a>
    </div>
    <div class="field_line">
        <label>标题</label>
        <input name="account[title]" style="width:600px;" value="<?php echo $accountData['account_title']?>" />
    </div>
    <div class="field_line">
        <label style="float: left; position: relative; left: 25px;">账户内容</label>
        <textarea name="account[content]" style="width: 600px; height: 335px; margin-left: 5px;"><?php echo $accountData['account_content']?></textarea>
    </div>
    <div class="field_line">
		<a href="#" onclick="account_form_submit();" class="easyui-linkbutton"><?php echo $buttonTitle?></a>
		&nbsp;&nbsp;
		<a href="#" onclick="account_dialog('close');" class="easyui-linkbutton">关闭</a>
    </div>
</div>
</form>
