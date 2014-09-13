<?php
/**
 * 数据库操作实例
 * @package Db
 * @author zhaoyan<1210965963@qq.com>
 * @version 1.0
 */
namespace Db;

class Local
{

    /**
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
