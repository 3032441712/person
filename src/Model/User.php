<?php
/**
 * 用户信息处理模型
 *
 * PHP version 5.4
 *
 * @category Model
 * @package  Model
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id
 * @link     http://www.168helps.com/blog
 */
namespace Model;

use Db\Local;

/**
 * User 类
 *
 * @category Model
 * @package  Model
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @link     http://www.168helps.com/blog
 */
class User
{

    /**
     * 获取用户列表
     *
     * @param int $page  当前页
     * @param int $limit 每页数据显示条数
     *
     * @return array
     */
    public static function getList($page = 1, $limit = 10)
    {
        $sql = 'SELECT {FIELD} FROM z_users';
        $field = 'user_id,user_name,user_sex,user_email,user_address,createtime,last_login_time';
        $total = Local::fetchOne(str_replace('{FIELD}', 'COUNT(1) as total', $sql));
        $data = Local::fetchAll(str_replace('{FIELD}', $field, $sql) . ' LIMIT ' . ($page - 1) * $limit . ',' . $limit);
        
        return array(
            'total' => $total['total'],
            'rows' => $data
        );
    }

    /**
     * 根据用户ID获取用户信息
     *
     * @param int $id 用户ID
     *
     * @return array
     */
    public static function getUserDataById($id)
    {
        $data = Local::fetchOne('SELECT * FROM z_users WHERE user_id=:user_id LIMIT 1', array(
            ':user_id' => $id
        ));

        return $data;
    }

    /**
     * 通过用户名来获取用户信息
     *
     * @param string $field    查询的字段
     * @param string $username 登录系统的用户名
     *
     * @return array
     */
    public static function getUserDataByUsername($field, $username)
    {
        return Local::fetchOne('SELECT ' . $field . ' FROM z_users WHERE user_name=:user_name LIMIT 1', array(
            ':user_name' => $username
        ));
    }

    /**
     * 获取数据表中字段与默认值
     *
     * @return array
     */
    public static function getTableAttribute()
    {
        $data = array();
        foreach (Local::fetchAll('DESC z_users') as $k => $v) {
            $data[$v['Field']] = ($v['Default'] == null || $v['Default'] == 0 ? '' : $v['Default']);
        }
        return $data;
    }

    /**
     * 插入用户信息
     *
     * @param array $data 用户数据
     *
     * @return int
     * @throw  Exception
     */
    public static function insert(array $data)
    {
        $datetime = date('Y-m-d H:i:s');
        $data['createtime'] = $datetime;
        $data['updatetime'] = $datetime;
        $data['last_login_time'] = $datetime;
        
        $input_params = array();
        foreach ($data as $k => $v) {
            $input_params[':' . $k] = $v;
        }
        $sql = 'INSERT INTO z_users(' . implode(',', array_keys($data)) . ') VALUES (' . implode(',', array_keys($input_params)) . ')';
        
        $statement = Local::query($sql, $input_params);
        $statement->closeCursor();
        
        return Local::getLastInsertId();
    }

    /**
     * 进行数据更新
     *
     * @param array $data 要更新的数据
     * @param int   $id   要更新的用户
     *
     * @return void
     */
    public static function update($data, $id)
    {
        $sql = 'UPDATE z_users SET ';
        $inputParams = array();
        foreach ($data as $k => $v) {
            $sql .= "{$k}=:{$k},";
            $inputParams[':' . $k] = $v;
        }
        $sql = substr($sql, 0, strlen($sql) - 1) . ' WHERE user_id=:user_id';
        $inputParams[':user_id'] = $id;
        
        $statement = Local::query($sql, $inputParams);
        $statement->closeCursor();
    }

    /**
     * 验证登录用户名
     *
     * @param string $username 数据字符串
     * @param int    $min      最小长度
     * @param int    $max      最大长度
     *
     * @return bool true/false
     */
    public static function isUsername($username, $min = 5, $max = 32)
    {
        return preg_match("/^[a-zA-Z0-9_-]{{$min},{$max}}$/", $username);
    }

    /**
     * 验证登录密码
     *
     * @param string $password 数据字符串
     * @param int    $min      最小长度
     * @param int    $max      最大长度
     *
     * @return bool true/false
     */
    public static function isPassword($password, $min = 5, $max = 32)
    {
        return preg_match("/^[a-zA-Z0-9]{{$min},{$max}}$/", $password);
    }

    /**
     * 验证用户真实姓名是否符合规则
     *
     * @param string $realname 数据字符
     *
     * @return bool true/false
     */
    public static function isRealName($realname)
    {
        $strlen = mb_strlen($realname, 'utf-8');
        return ($strlen > 32 || $strlen < 1) ? false : true;
    }

    /**
     * 验证性别是否符合规则
     *
     * @param int $sex 字符数据
     *
     * @return true/false
     */
    public static function isSex($sex)
    {
        return array_search(intval($sex), array(0,1));
    }

    /**
     * 验证年龄是否符合规则
     *
     * @param int $age 字符数据
     *
     * @return bool true/false
     */
    public static function isAge($age)
    {
        $age = intval($age);
        return $age > 16 && $age < 100 ? true : false;
    }

    /**
     * 验证邮箱是否符合规则
     *
     * @param string $email 用户邮箱
     * @param int    $min   最小长度
     * @param int    $max   最大长度
     *
     * @return bool true/false
     */
    public static function isEmail($email, $min = 5, $max = 64)
    {
        $strlen = mb_strlen($email, 'utf-8');
        if ($strlen < $min || $strlen > $max) {
            return false;
        }
        
        return preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/", $email);
    }

    /**
     * 验证座机是否符合规则
     *
     * @param string $phone 固定电话
     * @param int    $min   最小长度
     * @param int    $max   最大长度
     *
     * @return bool true/false
     */
    public static function isPhone($phone, $min = 7, $max = 8)
    {
        return preg_match("/^(0\d{2,3}-\d{{$min},{$max}})$/", $phone);
    }

    /**
     * 验证手机是否符合规则
     *
     * @param int $mobile 字符数据
     *
     * @return bool true/false
     */
    public static function isMobile($mobile)
    {
        return preg_match("/^(1[3584]\d{9})$/", $mobile);
    }

    /**
     * 验证QQ号是否符合规则
     * 
     * @param int $qq  字符数据
     * @param int $min 最小长度
     * @param int $max 最大长度
     *
     * @return bool true/false
     */
    public static function isQQ($qq, $min = 5, $max = 13)
    {
        return preg_match("/^(\d){{$min},{$max}}$/", $qq);
    }
}
