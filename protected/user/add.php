<?php
/**
 * 添加编辑用户信息,用户为系统登录用户.
 * 1.添加编辑用户的表单.
 * 2.对表单内容进行安全过滤,去除数据两侧空格.对每个字段进行数据验证.
 * 3.表单令牌验证,防止跨网络攻击.
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
use Form\Response;

$eid = isset($_GET['eid']) ? intval($_GET['eid']) : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';

if ($act == 'save') {
    $userData = isset($_POST['user']) && is_array($_POST['user']) ? $_POST['user'] : array();

    $data = array(
        'user_name' => isset($userData['name']) ? $userData['name'] : '',
        'user_pass' => isset($userData['pass']) && $userData['pass'] != '' ? md5($userData['pass']) : '',
        'user_real_name' => isset($userData['real_name']) ? $userData['real_name'] : '',
        'user_sex' => isset($userData['sex']) && $userData['sex'] != '' ? $userData['sex'] : 1,
        'user_age' => isset($userData['age']) && $userData['age'] != '' ? $userData['age'] : 0,
        'user_email' => isset($userData['email']) ? $userData['email'] : '',
        'user_qq' => isset($userData['qq']) && $userData['qq'] != '' ? $userData['qq'] : 0,
        'user_phone' => isset($userData['phone']) && $userData['phone'] != '' ? $userData['phone'] : 0,
        'user_mobile' => isset($userData['mobile']) && $userData['mobile'] != '' ? $userData['mobile'] : 0
    );
    //去除数据两侧空字符
    $data = array_map('trim', $data);

    if (User::isUsername($data['user_name']) == false) {
        Response::json(array('msg' => '用户名不符合规则,请重新输入'), 1);
    }

    if ($eid > 0) {
        if ($data['user_pass'] != '' && User::isPassword($data['user_pass']) == false) {
            Response::json(array('msg' => '密码不符合规则,请重新输入'), 1);
        }
    } else {
        if (User::isPassword($data['user_pass']) == false) {
            Response::json(array('msg' => '密码不符合规则,请重新输入'), 1);
        }
    }

    //真实姓名
    if ($data['user_real_name'] != '' && User::isRealName($data['user_real_name']) == false) {
        Response::json(array('msg' => '输入的名字不符合规则,请重新输入'), 1);
    }

    //性别
    if ($data['user_sex'] != '' && User::isSex($data['user_sex']) == false) {
        Response::json(array('msg' => '输入的性别不符合规则,请重新输入'), 1);
    }

    //年龄
    if ($data['user_age'] != 0 && User::isAge($data['user_age']) == false) {
        Response::json(array('msg' => '输入的年龄不符合规则,请重新输入'), 1);
    }

    //邮箱
    if ($data['user_email'] != '' && User::isEmail($data['user_email']) == false) {
        Response::json(array('msg' => '输入的邮箱不符合规则,请重新输入'), 1);
    }

    //QQ号
    if ($data['user_qq'] != 0 && User::isQQ($data['user_qq']) == false) {
        Response::json(array('msg' => '输入的QQ不符合规则,请重新输入'), 1);
    }

    //电话
    if ($data['user_phone'] != 0 && User::isPhone($data['user_phone']) == false) {
        Response::json(array('msg' => '输入的座机电话不符合规则,请重新输入'), 1);
    }

    //手机
    if ($data['user_mobile'] != 0 && User::isMobile($data['user_mobile']) == false) {
        Response::json(array('msg' => '输入的手机号不符合规则,请重新输入'), 1);
    }

    if ($eid > 0) {
        $user = User::getUserDataById($eid);
        if (isset($user['user_id']) == false) {
            Response::json(array('msg' => '没有找到该用户'), 1);
        }

        //密码为空,那么不对该数据进行编辑
        if ($data['user_pass'] == '') {
        	unset($data['user_pass']);
        }

        //去除未更新数据.
        foreach ($data as $k => $v) {
            if ($user[$k] == $v) {
                unset($data[$k]);
            }
        }

        unset($user);
        //没有需要进行更新的数据
        if (count($data) < 1) {
            Response::json(array('msg' => '数据未更改,不需要进行更新'), 1);
        }

        User::update($data, $eid);
    } else {
        User::insert($data);
    }

    Response::json(array('msg' => '操作成功'), 0);
}

$formData = array();
if ($eid != '') {
    $formData = User::getUserDataById($eid);
    $formData['user_age'] = ($formData['user_age'] == 0 ? '' : $formData['user_age']);
    $formData['user_qq'] = ($formData['user_qq'] == 0 ? '' : $formData['user_qq']);
    $formData['user_phone'] = ($formData['user_phone'] == 0 ? '' : $formData['user_phone']);
    $formData['user_mobile'] = ($formData['user_mobile'] == 0 ? '' : $formData['user_mobile']);
} else {
    $formData = User::getTableAttribute();
}
?>
<form id="user_form" method="post" action="<?php echo WEB_URL . '/index.php?d=user&f=add&act=save&eid='.$eid ?>">
	<div id="user_action">
		<div class="field-line">
			<div class="field-left">
				<label>登录用户</label> <input <?php if (isset($formData['user_name']) && $formData['user_name'] != ''):?>readonly="readonly"<?php endif;?> type="text" name="user[name]" value="<?php echo $formData['user_name']?>" />
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