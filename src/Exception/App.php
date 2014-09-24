<?php
/**
 * 自定义应用异常
 *
 * PHP version 5.4
 *
 * @category Exception
 * @package  Exception
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
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
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @link     http://www.168helps.com/blog
 */
class App extends \Exception
{
    // 目录没有找到
    const NOTFOUNTDIR = 1000;
    
    // 文件没有找到
    const NOTFOUNTFILE = 1001;
}
