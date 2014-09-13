<?php
use Model\User;
$eid = isset($_GET['eid']) ? intval($_GET['eid']) : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';

if ($act == 'save') {
    $userData = isset($_POST['user']) && is_array($_POST['user']) ? $_POST['user'] : array();

    $data = array(
        'user_name' => isset($userData['name']) ? $userData['name'] : '',
        'user_pass' => isset($userData['pass']) && $userData['pass'] != '' ? md5($userData['pass']) : '',
        'user_real_name' => isset($userData['real_name']) ? $userData['real_name'] : '',
        'user_sex' => isset($userData['sex']) ? $userData['sex'] : '',
        'user_age' => isset($userData['age']) ? $userData['age'] : '',
        'user_email' => isset($userData['email']) ? $userData['email'] : '',
        'user_qq' => isset($userData['qq']) ? $userData['qq'] : '',
        'user_phone' => isset($userData['phone']) ? $userData['phone'] : '',
        'user_mobile' => isset($userData['mobile']) ? $userData['mobile'] : ''
    );

    if ($eid > 0) {
        $user = User::getUserDataById($eid);
        if (isset($user['user_id']) == false) {
            echo '{"code":"1","msg":"没有找到该用户."}';
            exit(0);
        }
        
        //密码为空,那么不对该数据进行编辑
        if ($data['user_pass'] == '') {
        	unset($data['user_pass']);
        }

        //去除为更新数据.
        foreach ($data as $k => $v) {
            if ($user[$k] == $v) {
                unset($data[$k]);
            }
        }

        unset($user);
        //没有需要进行更新的数据
        if (count($data) < 1) {
            echo '{"code":"1","msg":"数据未更改,不需要进行更新."}';
            exit(0);
        }

        User::update($data, $eid);
    } else {
        User::insert($data);
    }

    echo '{"code":"0","msg":"操作成功"}';
    exit(0);
}

$formData = array();
if ($eid != '') {
    $formData = User::getUserDataById($eid);
} else {
    $formData = User::getTableAttribute();
}
?>
<form id="user_form" method="post" action="<?php echo WEB_URL . '/index.php?d=user&f=add&act=save&eid='.$eid ?>">
	<div id="user_action">
		<div class="field-line">
			<div class="field-left">
				<label>登录用户</label> <input <?php if (isset($formData['user_name'])):?>readonly="readonly"<?php endif;?> type="text" name="user[name]" value="<?php echo $formData['user_name']?>" />
			</div>
			<div class="field-right">
				<label>登录密码</label> <input type="password" name="user[pass]" value="" />
			</div>
		</div>
		<div class="field-line">
			<div class="field-left">
				<label>真实姓名</label> <input type="text" name="user[real_name]" value="<?php echo $formData['user_real_name']?>" />
			</div>
			<div class="field-right">
				<label>年龄</label> <input type="text" style="width: 35px; text-align: center;" name="user[age]" value="<?php echo $formData['user_age']?>" />
			</div>
		</div>
		<div class="field-line">
			<div class="field-left">
				<label>邮箱</label> <input type="text" name="user[email]" value="<?php echo $formData['user_email']?>" />
			</div>
			<div class="field-right">
				<label>QQ</label> <input type="text" name="user[qq]" value="<?php echo $formData['user_qq']?>" />
			</div>
		</div>
		<div class="field-line">
			<div class="field-left">
				<label>座机</label> <input type="text" name="user[phone]" value="<?php echo $formData['user_phone']?>" />
			</div>
			<div class="field-right">
				<label>手机</label> <input type="text" name="user[mobile]" value="<?php echo $formData['user_mobile']?>" />
			</div>
		</div>
		<div class="field-line">
			<div class="field-left" style="float: none;">
				<label>性别</label>
				<?php 
				$userSexData = array(
					array('title'=>'女','value'=>0),
                    array('title'=>'男','value'=>1)
				);
                foreach ($userSexData as $item):
				?>
				<input <?php if ($item['value'] == $formData['user_sex']):?>checked="checked"<?php endif;?> type="radio" name="user[sex]" value="<?php echo $item['value']?>" /><?php echo $item['title']?>
				<?php
				endforeach;
				?>
			</div>
		</div>
		<div class="field-line" style="text-align: center;">
			<a href="#" onclick="user_form_submit();" class="easyui-linkbutton"
				data-options="plain:true"><?php echo ($eid != '' ? '编辑' : '添加')?></a>
			<a href="#" onclick="user_dialog('close');" class="easyui-linkbutton"
				data-options="plain:true">关闭</a>
		</div>
	</div>
</form>