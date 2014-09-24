<?php
/**
 * 数据库操作类
 *
 * PHP version 5.4
 *
 * @category Db
 * @package  Db
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168helps License
 * @version  GIT: $Id
 * @link     http://www.168helps.com/blog
 */
namespace Db;

/**
 * Local类
 *
 * @category Db
 * @package  Db
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168helps License
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

    private static function getLink()
    {
        if (self::$link instanceof Mysql == false) {
            self::$link = new Mysql(DBHOST, DBPORT, DBUSER, DBPASS, DBNAME);
        }
        return self::$link;
    }

    public static function __callStatic($name, $args)
    {
        $callback = array(
            self::getLink(),
            $name
        );
        return call_user_func_array($callback, $args);
    }
}
