<?php
/**
 * 自定义MYSQL操作类库
 * @package Db
 * @author zhaoyan<1210965963@qq.com>
 * @version 1.0 
 */
namespace Db;

final class Mysql
{

    /**
     *
     * @var \PDO
     */
    private $dbLink = null;

    /**
     * 实例化数据库
     *
     * @param string $dbhost
     *            MYSQL主机地址
     * @param string $dbport
     *            MYSQL主机端口
     * @param string $dbuser
     *            MYSQL用户
     * @param string $dbpass
     *            MYSQL密码
     * @param string $dbname
     *            MYSQL数据库
     * @param string $charset
     *            数据库编码
     * @return void
     */
    public function __construct($dbhost, $dbport, $dbuser, $dbpass, $dbname, $charset = 'utf8')
    {
        if ($this->dbLink instanceof \PDO == false) {
            $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
            $options = array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}",
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            );
            $this->dbLink = new \PDO($dsn, $dbuser, $dbpass, $options);
        }
    }

    /**
     * 获取单条数据
     *
     * @param string $sql
     *            执行的sql语句
     * @param array $input_parameters
     *            预处理数据
     * @param int $fetch_style
     *            数据检索出来的数据格式
     * @return array
     */
    public function fetchOne($sql, $input_parameters = array(), $fetch_style = \PDO::FETCH_ASSOC)
    {
        $statement = $this->query($sql, $input_parameters);
        $data = $statement->fetch($fetch_style);
        $statement->closeCursor();

        return $data;
    }

    /**
     * 获取多条数据
     *
     * @param string $sql
     *            执行的sql语句
     * @param array $input_parameters
     *            预处理数据
     * @param int $fetch_style
     *            数据检索出来的数据格式
     * @return array
     */
    public function fetchAll($sql, $input_parameters = array(), $fetch_style = \PDO::FETCH_ASSOC)
    {
        $statement = $this->query($sql, $input_parameters);
        $data = $statement->fetchAll($fetch_style);
        $statement->closeCursor();

        return $data;
    }

    public function getLastInsertId()
    {
        return $this->dbLink->lastInsertId();
    }

    /**
     * 执行SQL语句
     *
     * @return \PDOStatement
     */
    public function query($sql, $input_parameters = array())
    {
        $statement = $this->dbLink->prepare($sql);
        $statement->execute($input_parameters);

        return $statement;
    }

    /**
     * 开启事务处理
     *
     * @return bool true/false
     */
    public function beginTransaction()
    {
        return $this->dbLink->beginTransaction();
    }

    public function rollBack()
    {
        return $this->dbLink->rollBack();
    }

    /**
     * 开启事务后进行提交
     *
     * @return bool true/false
     */
    public function commit()
    {
        return $this->dbLink->commit();
    }

    /**
     * 返回PDO对象
     *
     * @return \PDO
     */
    public function getDbLink()
    {
        return $this->dbLink;
    }

    /**
     * 关闭连接
     *
     * @return void
     */
    public function close()
    {
        $this->dbLink = null;
    }

    public function __destruct()
    {
        $this->close();
    }
}
