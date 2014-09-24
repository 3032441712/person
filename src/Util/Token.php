<?php
/**
 * 生成站点的表单令牌.
 * 表单令牌用来对站点提交的表单进行验证,防止跨站攻击.
 * 包含的方法:1.令牌生成 2.进行令牌验证
 *
 * PHP version 5.3
 *
 * @category Util
 * @package  Util
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
namespace Util;

/**
 * Token 表单生成类库
 *
 * @category Util
 * @package  Util
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog Private License
 * @link     http://www.168helps.com/blog
 */
class Token
{
    /**
     * 创建令牌,返回令牌的字符串.
     *
     * @return string
     */
    public static function create()
    {
        $_SESSION['token'] = md5(time().APP_SYSTEM_SECRET_KEY);
        return $_SESSION['token'];
    }

    /**
     * 验证令牌是否合法
     *
     * @param string $token 传入需要进行验证的令牌字符串
     *
     * @return bool true/false
     */
    public static function validate($token)
    {
        return ($_SESSION['token'] === $token) ? true : false;
    }
}
