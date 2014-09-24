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
 * Account 类
 *
 * @category Model
 * @package  Model
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @link     http://www.168helps.com/blog
 */
class Account
{

    /**
     * 保存账户信息到数据库
     *
     * @param array $data 账户数据
     *
     * @return int
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
     * @param array $data 要更新的数据
     * @param int   $id   数据ID
     *
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
     * @param int $page  当前页
     * @param int $limit 每页显示数据条数
     *
     * @return array
     */
    public static function getList($page = 1, $limit = 10)
    {
        $sql = 'SELECT {FIELD} FROM z_accounts a LEFT JOIN z_account_cats c ON a.account_cat=c.cat_id LEFT JOIN z_users u ON a.user_id=u.user_id';
        $field = 'a.account_id,a.account_title,a.account_cat,a.user_id,a.acount_status,a.createtime,c.cat_title,u.user_name';
        $total = Local::fetchOne(str_replace('{FIELD}', 'COUNT(1) as total', $sql));
        $data = Local::fetchAll(str_replace('{FIELD}', $field, $sql) . ' LIMIT ' . ($page - 1) * $limit . ',' . $limit);

        return array(
            'total' => $total['total'],
            'rows' => $data
        );
    }

    /**
     * 根据账户ID获取单条数据记录
     *
     * @param int    $account_id 账户ID主键
     * @param string $field      检索的字段
     *
     * @return array
     */
    public static function getAccountById($account_id, $field = '*')
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

    /**
     * 验证分类是否符合规则
     *
     * @param int $catid 分类ID
     *
     * @return bool true/false
     */
    public static function isCat($catid)
    {
        return $catid;
    }

    /**
     * 验证标题
     *
     * @param string $account_title 帐号标题
     * @param int    $min           最小长度
     * @param int    $max           最大长度
     *
     * @return bool true/false
     */
    public static function isAccountTitle($account_title, $min = 1, $max = 32)
    {
        return preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{{$min},{$max}}$/u", $account_title);
    }
}
