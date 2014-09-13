<?php
/**
 * 用户信息处理模型
 * @package Model
 * @author zhaoyan<1210965963@qq.com>
 * @version 1.0
 */
namespace Model;

use Db\Local;

class User
{

    public static function getList()
    {
        $sql = 'SELECT {FIELD} FROM z_users';
        $field = 'user_id,user_name,user_sex,user_email,user_address,createtime,last_login_time';
        $total = Local::fetchOne(str_replace('{FIELD}', 'COUNT(1) as total', $sql));
        $data = Local::fetchAll(str_replace('{FIELD}', $field, $sql));
        
        return array(
            'total' => $total['total'],
            'rows' => $data
        );
    }

    /**
     * 根据用户ID获取用户信息
     *
     * @param int $id
     *            用户ID
     * @return array
     */
    public static function getUserDataById($id)
    {
        return Local::fetchOne('SELECT * FROM z_users WHERE user_id=:user_id LIMIT 1', array(
            ':user_id' => $id
        ));
    }

    /**
     * 通过用户名来获取用户信息
     *
     * @param string $field
     *            查询的字段
     * @param string $username
     *            登录系统的用户名
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
            $data[$v['Field']] = $v['Default'] == null ? '' : $v['Default'];
        }
        return $data;
    }

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
     * @param array $data
     *            要更新的数据
     * @param int $id
     *            要更新的用户
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
}
