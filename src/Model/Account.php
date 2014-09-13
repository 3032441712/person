<?php
/**
 * 用户信息处理模型
 * @package Model
 * @author  zhaoyan
 * @version 1.0 
 */
namespace Model;

use Db\Local;

class Account
{

    /**
     * 保存账户信息到数据库
     *
     * @param array $data
     *            账户数据
     * @return int 主键ID
     */
    public static function insert(array $data)
    {
        $data['createtime'] = date("Y-m-d H:i:s");
        $input_params = array();
        foreach ($data as $k => $v) {
            $input_params[':' . $k] = $v;
        }
        $sql = 'INSERT INTO z_accounts(' . implode(',', array_keys($data)) . ') VALUES (' . implode(',', array_keys($input_params)) . ')';
        
        $statement = Local::query($sql, $input_params);
        $statement->closeCursor();
        return Local::getLastInsertId();
    }

    /**
     * 更新账户信息
     * 
     * @param array $data
     *            要更新的数据
     * @param int $id
     *            数据ID
     * @return void
     */
    public static function update($data, $id)
    {
        $sql = 'UPDATE z_accounts SET ';
        $inputParams = array();
        foreach ($data as $k => $v) {
            $sql .= "{$k}=:{$k},";
            $inputParams[':' . $k] = $v;
        }
        $sql = substr($sql, 0, strlen($sql) - 1) . ' WHERE account_id=:account_id';
        $inputParams[':account_id'] = $id;
        
        $statement = Local::query($sql, $inputParams);
        $statement->closeCursor();
    }

    /**
     * 获取账户信息列表
     *
     * @return array
     */
    public static function getList()
    {
        $sql = 'SELECT {FIELD} FROM z_accounts a LEFT JOIN z_account_cats c ON a.account_cat=c.cat_id LEFT JOIN z_users u ON a.user_id=u.user_id';
        $field = 'a.account_id,a.account_title,a.account_cat,a.user_id,a.acount_status,a.createtime,c.cat_title,u.user_name';
        $total = Local::fetchOne(str_replace('{FIELD}', 'COUNT(1) as total', $sql));
        $data = Local::fetchAll(str_replace('{FIELD}', $field, $sql));
        
        return array(
            'total' => $total['total'],
            'rows' => $data
        );
    }

    /**
     * 根据账户ID获取单条数据记录
     *
     * @param int $account_id
     *            账户ID主键
     * @return array
     */
    public static function getAccountById($field = '*', $account_id)
    {
        return Local::fetchOne('SELECT a.' . $field . ',c.cat_title FROM z_accounts a LEFT JOIN z_account_cats c ON a.account_cat=c.cat_id WHERE account_id=:account_id LIMIT 1', array(
            ':account_id' => $account_id
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
        foreach (Local::fetchAll('DESC z_accounts') as $k => $v) {
            $data[$v['Field']] = $v['Default'] == null ? '' : $v['Default'];
        }
        return $data;
    }
}
