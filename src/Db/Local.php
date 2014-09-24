<?php
/**
 * 数据库操作类
 *
 * PHP version 5.4
 *
 * @category Db
 * @package  Db
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
namespace Db;

/**
 * Local类
 *
 * @category Db
 * @package  Db
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @link     http://www.168helps.bom/blog
 */
class Local
{
    /**
     * 实例化 Mysql
     *
     * @var Mysql
     */
    private static $link = null;

    /**
     * 获取数据类库对象
     * 
     * @return Mysql
     */
    private static function getLink()
    {
        if (self::$link instanceof Mysql == false) {
            self::$link = new Mysql(DBHOST, DBPORT, DBUSER, DBPASS, DBNAME);
        }
        return self::$link;
    }

    /**
     * 静态魔术方法
     * 
     * @param string $name 调用的方法名
     * @param string $args 方法的参数
     * 
     * @return void
     */
    public static function __callStatic($name, $args)
    {
        $callback = array(
            self::getLink(),
            $name
        );
        return call_user_func_array($callback, $args);
    }
}
