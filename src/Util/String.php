<?php
/**
 * 字符操作类
 *
 * PHP version 5.4
 *
 * @category Util
 * @package  Util
 * @author   zhaoyan <3032441712@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
namespace Util;

/**
 * String 类
 *
 * @category Util
 * @package  Util
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168helps License
 * @link     http://www.168helps.com/blog
 */
class String
{

    /**
     * 对字符串进行安全过滤
     * 1.过滤特殊字符
     * 2.去除两侧空格
     *
     * @param mixed $data 输入数据
     *
     * @return string 返回过滤后的字符
     */
    public static function safe($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::safe($v);
            }
        } elseif (is_string($data)) {
            return addslashes(trim($data));
        }

        return $data;
    }

    /**
     * 将字符转换为bytes数组
     * 
     * @param string $str      字符数据
     * @param string $encoding 字符编码
     *
     * @return array
     */
    public static function bytes($str, $encoding = 'utf-8')
    {
        $size = mb_strlen($str, $encoding);
        $data = new \SplFixedArray($size);
        for ($i = 0; $i < $size; $i++) {
            $data[$i] = mb_substr($str, $i, 1, $encoding);
        }

        return $data;
    }
}
