<?php
/**
 * 用户信息分类处理模型
 * @package Model
 * @author zhaoyan<1210965963@qq.com>
 * @version 1.0
 */
namespace Model\Account;

use Db\Local;

class Cat
{

    /**
     * 录入分类信息
     *
     * @param array $data
     *            录入的数据
     * @return int
     */
    public static function insert(array $data)
    {
        $data['createtime'] = date('Y-m-d H:i:s');
        $input_params = array();
        foreach ($data as $k => $v) {
            $input_params[':' . $k] = $v;
        }
        
        $sql = 'INSERT INTO z_account_cats(' . implode(',', array_keys($data)) . ') VALUES (' . implode(',', array_keys($input_params)) . ')';
        $statement = Local::query($sql, $input_params);
        $statement->closeCursor();
        
        return Local::getLastInsertId();
    }

    /**
     * 更新分类数据
     *
     * @param array $data
     *            更新的数据
     * @param string $cid
     *            分类ID
     * @return void
     */
    public static function update($data, $cid)
    {
        $sql = 'UPDATE z_account_cats SET ';
        $inputParam = array();
        foreach ($data as $k => $v) {
            $inputParam[':' . $k] = $v;
            $sql .= "{$k}=:{$k},";
        }
        $sql = substr($sql, 0, strlen($sql) - 1) . ' WHERE cat_id=:cat_id';
        
        $inputParam[':cat_id'] = $cid;
        $statement = Local::query($sql, $inputParam);
        $statement->closeCursor();
    }

    /**
     * 删除分类
     *
     * @param string $cid
     *            分类ID
     * @return void
     */
    public static function delete($cid)
    {
        $hasChildren = Local::fetchOne('SELECT COUNT(1) as total FROM z_account_cats WHERE cat_parent=:cat_id', array(
            ':cat_id' => $cid
        ));
        
        if ($hasChildren['total'] > 0) {
        	echo '{"code":"1", "msg":"该分类下还有分类,请先删除子分类."}';
        	exit(0);
        }
        
        $statement = Local::query('DELETE FROM z_account_cats WHERE cat_id=:cat_id', array(
            ':cat_id' => $cid
        ));
        $statement->closeCursor();
    }

    /**
     * 根据分类ID获取分类数据
     *
     * @param string $field
     *            要检索的字段
     * @param int $cid
     *            分类ID
     * @return array
     */
    public static function getCatsDataById($field = '*', $cid)
    {
        $catData = Local::fetchOne('SELECT ' . $field . ' FROM z_account_cats WHERE cat_id=:cat_id LIMIT 1', array(
            ':cat_id' => $cid
        ));
        
        return $catData;
    }

    /**
     * 获取easyui格式的数据
     *
     * @return string
     */
    public static function getEasyUITreeData()
    {
        $catData = Local::fetchAll('SELECT * FROM z_account_cats WHERE cat_status=1');
        
        return self::getCatTree(0, $catData);
    }

    /**
     * 获取分类数
     *
     * @param int $root_id
     *            根分类ID
     * @param array $cat_data
     *            分类数据
     * @return array
     */
    public static function getCatTree($root_id, $cat_data = array())
    {
        $childrens = self::getCatTreeChildren($cat_data, $root_id);
        if (empty($childrens)) {
            return null;
        }
        
        foreach ($childrens as $k => $v) {
            $rescurTree = self::getCatTree($v['cat_id'], $cat_data);
            if (null != $rescurTree) {
                $childrens[$k]['children'] = $rescurTree;
            }
        }
        
        return $childrens;
    }

    /**
     * 获得分类数下的子分类
     *
     * @param array $arr
     *            分类数据
     * @param int $cid
     *            分类ID
     * @return array
     */
    public static function getCatTreeChildren(&$arr, $cid)
    {
        $childrens = array();
        foreach ($arr as $k => $v) {
            if ($v['cat_parent'] == $cid) {
                $v['id'] = $v['cat_id'];
                $v['text'] = $v['cat_title'];
                $childrens[] = $v;
            }
        }
        
        return $childrens;
    }
}
