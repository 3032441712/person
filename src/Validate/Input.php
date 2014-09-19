<?php
/**
 * 验证系统输入
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
namespace Validate;

/**
 * Input 类
 *
 * @category Exception
 * @package  Exception
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168helps License
 * @link     http://www.168helps.com/blog
 */
class Input
{

    /**
     * 验证字符串是否全是中文
     *
     * @param string $string 字符数据
     *
     * @return bool true/false
     */
    public static function isChineseStr($string)
    {
        return preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $string);
    }
}
