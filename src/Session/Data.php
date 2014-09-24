<?php
/**
 * SESSION 扩展类
 *
 * PHP version 5.4
 *
 * @category Exception
 * @package  Exception
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
namespace Session;

/**
 * Data 类
 *
 * @category Exception
 * @package  Exception
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @link     http://www.168helps.com/blog
 */
class Data
{

    private $savePath;

    /**
     * @var \Redis
     */
    private $redis = null;

    /**
     * 构造方法
     *
     * @return void
     * @throw  Exception
     */
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379, 3);
    }

    /**
     * 打开SESSION
     *
     * @param string $savePath    SESSION保存的路径
     * @param string $sessionName SESSION的KEY
     *
     * @return bool true/false
     */
    public function open($savePath, $sessionName)
    {
        return $this->redis->ping();
    }

    /**
     * 关闭Redis
     *
     * @return void
     */
    public function close()
    {
        return $this->redis->close();
    }

    /**
     * 根据SESSION KEY 读取数据
     *
     * @param int $id key
     *
     * @return array
     */
    public function read($id)
    {
        $id = 'sess_'.$id;
        return $this->redis->get($id);
    }

    /**
     * 写入SESSION
     *
     * @param int    $id   key
     * @param string $data 数据
     *
     * @return bool true/false
     */
    public function write($id, $data)
    {
        $time = 3600;
        $id = 'sess_'.$id;
        return $this->redis->setex($id, $time, $data);
    }

    /**
     * 摧毁SESSION
     *
     * @param int $id key
     *
     * @return bool true/false
     */
    public function destroy($id)
    {
        $id = 'sess_'.$id;
        if ($this->redis->exists($id)) {
            return $this->redis->delete($id);
        }

        return true;
    }

    /**
     * 最大存活时间
     *
     * @param int $maxlifetime 最大生存时间
     *
     * @return bool true/false
     */
    public function gc($maxlifetime)
    {
        return true;
    }

    /**
     * 析构函数
     *
     * @return void
     */
    public function __destruct()
    {
        $this->close();
    }
}
