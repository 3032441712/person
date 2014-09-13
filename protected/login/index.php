<?php 
use Model\User;
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $userPostData = isset($_POST['user']) && is_array($_POST['user']) ? $_POST['user'] : array();
    $userPostData = array_map('trim', $userPostData);

    $username = isset($userPostData['name']) ? $userPostData['name'] : '';
    $password = isset($userPostData['pass']) ? $userPostData['pass'] : '';

    if ($username != '') {
    	$userData = User::getUserDataByUsername('user_id,user_pass', $username);
    	if (isset($userData['user_id']) == false) {
    		//没有找到用户
    	} elseif (md5($password) != $userData['user_pass']) {
    	    //密码输入有误
    	} else {
    	    $_SESSION['user_id'] = $userData['user_id'];
    	    $_SESSION['user_name'] = $username;
    	    header("Location:index.php?d=main");
    	    exit(0);
    	}
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo APP_NAME . ' ' . APP_VERSION?></title>
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
<form method="post" action="<?php echo WEB_URL?>/index.php?d=login&f=index">
    <div id="login_wrap">
        <div class="login">
            <h2>系统登录</h2>
            <?php if (isset($_SESSION['user_id']) == false):?>
            <div class="line">
                <label for="username">用户名称</label>
                <input id="username" name="user[name]" type="text" value="" />
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
                <input style="width: 100px; height: 25px; line-height: 25px; cursor: pointer;" type="submit" value="登录系统" />
            </div>
            <?php else:?>
            <div class="line" style="height: 30px; line-height: 30px;">
                <strong>当前用户:<?php echo $_SESSION['user_name']?></strong>
            </div>
            <div class="line">
                <input onclick="login_system();" style="width: 100px; height: 25px; line-height: 25px; cursor: pointer;" type="button" value="登录系统" />
            </div>           
            <?php endif;?>
        </div>
    </div>
</form>
<script type="text/javascript">
function login_system()
{
	window.location.href = 'index.php?d=main';
}
</script>
</body>
</html>