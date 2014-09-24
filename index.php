<?php
/**
 * 个人信息管理系统 入口页面
 *
 * PHP version 5.4
 *
 * @category Person
 * @package  Person
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.16helps.com/blog/license.txt 16helps License
 * @version  GIT: $Id
 * @link     http://www.168helps.com/blog
 */
use Exception\App;

//opcache_reset();
define('APP_NAME', '个人信息管理系统');
define('APP_VERSION', '1.0');
define('APP_ROOT', dirname(__FILE__));
define('APP_SCRIPT_PATH', APP_ROOT . DIRECTORY_SEPARATOR . 'protected');
define('APP_SOURCE', APP_ROOT . DIRECTORY_SEPARATOR . 'src');
define('WEB_URL', 'http://127.0.0.1:81/~admin/person');

//设置时区
date_default_timezone_set('Asia/Shanghai');

require APP_ROOT . DIRECTORY_SEPARATOR . 'config.php';

/**
 * 自动加载类库的方法
 *
 * @param string $classname 类名称
 *
 * @return void
 * @throw Exception
 */
function __autoload($classname)
{
    if (class_exists($classname)) {
        return true;
    }

    $classFile = APP_SOURCE . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    if (file_exists($classFile) == false) {
        throw new \Exception("File {$classFile} Not Fount", 500);
    }

    include $classFile;
}

// 定义默认访问的模块
$d = isset($_GET['d']) ? $_GET['d'] : 'login';
$f = isset($_GET['f']) ? $_GET['f'] : 'index';

try {
    $modulePath = APP_SCRIPT_PATH . DIRECTORY_SEPARATOR . $d;
    // 模块不存在
    if (file_exists($modulePath) == false) {
        throw new App("Module Path {$modulePath} Not Found", App::NOTFOUNTDIR);
    }
    
    $modulePathFile = $modulePath . DIRECTORY_SEPARATOR . $f . '.php';
    // 模块的脚本执行文件不存在
    if (file_exists($modulePathFile) == false) {
        throw new App("Module File {$modulePath} Not Found", App::NOTFOUNTFILE);
    }
    
    //开启session
    $sessionHandle = new Session\Data();
    session_set_save_handler(
        array($sessionHandle, 'open'),
        array($sessionHandle, 'close'),
        array($sessionHandle, 'read'),
        array($sessionHandle, 'write'),
        array($sessionHandle, 'destroy'),
        array($sessionHandle, 'gc')
    );

    register_shutdown_function('session_write_close');
    session_start();

    if ($d != 'login' && isset($_SESSION['user_id']) == false) {
        header("Location:index.php?d=login");
        exit(0);
    }

    ob_start();
    include $modulePathFile;
    ob_end_flush();
} catch (App $e) {
    echo $e->getMessage();
} catch (\PDOException $e) {
    echo $e->getMessage();
} catch (\Exception $e) {
    echo $e->getMessage();
}
