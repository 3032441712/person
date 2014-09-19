<?php
/**
 * 自定义应用异常
 *
 * PHP version 5.4
 *
 * @category Exception
 * @package  Exception
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168helps License
 * @version  GIT: $Id
 * @link     http://www.168helps.com/blog
 */
namespace Exception;

/**
 * App 类
 *
 * @category Exception
 * @package  Exception
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168helps License
 * @link     http://www.168helps.com/blog
 */
class App extends \Exception
{
    // 目录没有找到
    const NotFountDir = 1000;
    
    // 文件没有找到
    const NotFountFile = 1001;
}
