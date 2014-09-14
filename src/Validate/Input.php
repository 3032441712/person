<?php
/**
 * 对系统输入字符进行验证
 * @package Validate
 * @author zhaoyan<1210965963@qq.com>
 * @version 1.0
 */
namespace Validate;

class Input
{

    /**
     * 验证字符串是否全是中文
     *
     * @param string $string
     *            字符数据
     * @return bool true/false
     */
    public static function isChineseStr($string)
    {
        return preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $string);
    }
}
