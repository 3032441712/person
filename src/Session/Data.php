<?php
/**
 * 扩展SESSION
 * @package Session
 * @author <1210965963@qq.com>
 * @version 1.0
 */
namespace Session;

class Data
{

    private $savePath;

    /**
     *
     * @var \Redis
     */
    private $redis = null;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379, 3);
    }

    public function open($savePath, $sessionName)
    {
        return $this->redis->ping();
    }

    public function close()
    {
        return $this->redis->close();
    }

    public function read($id)
    {
        $id = 'sess_'.$id;
        return $this->redis->get($id);
    }

    public function write($id, $data)
    {
        $time = 3600;
        $id = 'sess_'.$id;
        return $this->redis->setex($id, $time, $data);
    }

    public function destroy($id)
    {
        $id = 'sess_'.$id;
        if ($this->redis->exists($id)) {
            return $this->redis->delete($id);
        }
    	return true;
    }

    public function gc($maxlifetime)
    {
    	return true;
    }

    public function __destruct()
    {
        $this->close();
    }
}
