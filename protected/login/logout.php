<?php
/**
 * 用户登出功能页面
 * 1.清除$_SESSION变量.
 * 2.执行销毁session的方法.
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
unset($_SESSION);
session_destroy();
header('Location:index.php?d=login');
exit(0);
