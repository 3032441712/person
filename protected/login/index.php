<?php
/**
 * 用户登录页面
 * 1.实现用户登录功能
 * 2.验证码验证功能
 * 3.表单令牌登录验证
 *
 * PHP version 5.3
 *
 * @category Login
 * @package  Login
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
use Model\User;
use Util\Token;
use Form\Response;

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $userPostData = isset($_POST['user']) && is_array($_POST['user']) ? $_POST['user'] : array();
    $userPostData = array_map('trim', $userPostData);

    $username = isset($userPostData['name']) ? $userPostData['name'] : '';
    $password = isset($userPostData['pass']) ? $userPostData['pass'] : '';

    //进行表单令牌验证
    if (Token::validate($_POST['token']) === false) {
        Response::json(array('msg' => '非法访问,请刷新表单'), 1);
    }

    if (User::isUsername($username) == false) {
        Response::json(array('msg' => '账号不符合规则,请重新输入'), 1);
    }

    if (User::isPassword($password) == false) {
        Response::json(array('msg' => '密码不符合规则,请重新输入'), 1);
    }

    $userData = User::getUserDataByUsername('user_id,user_pass', $username);
    if (isset($userData['user_id']) == false) {
        Response::json(array('msg' => '您输入的帐号不存在,请重新输入'), 1);
    }

    if (md5($password) != $userData['user_pass']) {
        Response::json(array('msg' => '您输入的密码有误,请重新输入'), 1);
    }

    $_SESSION['user_id'] = $userData['user_id'];
    $_SESSION['user_name'] = $username;

    Response::json(array('msg' => '系统登录成功'), 0);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo APP_NAME . ' ' . APP_VERSION?></title>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/jquery.min.js"></script>
<style type="text/css">
#login_wrap {
    font-family: arial;
    font-size: 12px;
    margin: 150px 100px;
    text-align: center;	
}

#login_wrap .login {
    border: 1px solid darkseagreen;
    margin: 0 300px;	
}

#login_wrap .login h2 {
    background-color: silver;
    margin: 0 0 5px;
    height: 30px;
    line-height: 30px;
}

#login_wrap .login .line {
    margin: 5px 0;	
}

#login_wrap .login .line label {
    display: inline-block;
    text-align: right;
    width: 50px;	
}

#login_wrap .login .line input {
	width: 200px;
}

#login_wrap .login .line img {
	
}
</style>
</head>
<body>
<form id="login_form" method="post" action="<?php echo WEB_URL?>/index.php?d=login&f=index">
    <div id="login_wrap">
        <div class="login">
            <h2>系统登录</h2>
            <?php if (isset($_SESSION['user_id']) == false):?>
            <div class="line">
                <label for="username">用户名称</label>
                <input id="username" name="user[name]" type="text" value="" />
                <span></span>
            </div>
            <div class="line">
                <label for="password">登录密码</label>
                <input id="password" name="user[pass]" type="password" value="" />
            </div>
            <!--
            <div class="line">
                <label for="">验证码</label>
                <input type="text" />
                <img alt="验证码" src="">
            </div>
            -->
            <div class="line">
                <input type="hidden" id="token" name="token" value="<?php echo Token::Create(); ?>" />
                <input id="login_btn" onclick="login_submit();" style="width: 100px; height: 25px; line-height: 25px; cursor: pointer;" type="button" value="登录系统" />
            </div>
            <?php else:?>
            <div class="line" style="height: 30px; line-height: 30px;">
                <strong>当前用户:<?php echo $_SESSION['user_name']?></strong>
            </div>
            <div class="line">
                <input onclick="login_system();$(this).attr('disabled', true);" style="width: 100px; height: 25px; line-height: 25px; cursor: pointer;" type="button" value="登录系统" />
            </div>           
            <?php endif;?>
        </div>
    </div>
</form>
<script type="text/javascript">
function login_submit()
{
	$('#login_btn').val('正在登录...');
	$('#login_btn').attr('disabled', true);
	$.post($('#login_form').attr('action'), $('#login_form').serialize(), function(data){
        var res = eval("("+data+")");
        if (res.code != 0) {
            $('#token').val(res.token);
            alert(res.msg);
            $('#login_btn').val('登录系统');
            $('#login_btn').attr('disabled', false);
        } else {
            login_system();
        }
	});
}

function login_system()
{
	window.location.href = 'index.php?d=main';
}
</script>
</body>
</html>